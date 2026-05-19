<?php

namespace App\Http\Controllers;

use App\Models\AdminContent;
use App\Models\AdminPage;
use App\Models\AdminUpdate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('home', $this->shared([
            'homeContent' => $this->homepageContent(),
            'socialLinks' => $this->homepageSocialLinks(),
            'donationSettings' => $this->homepageDonationSettings(),
            'latestUpdates' => $this->latestPublicUpdates(),
        ]));
    }

    public function switchLanguage(Request $request, string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, ['id', 'en'], true), 404);

        $request->session()->put('site_locale', $locale);
        app()->setLocale($locale);

        return redirect()->back();
    }

    public function riwayat(): View
    {
        $section = $this->findSection('profil');
        $item = collect($section['children'] ?? [])->firstWhere('key', 'riwayat');

        return $this->renderPublicPage($section, $item);
    }

    public function publicSection(string $section): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        return $this->renderPublicPage($sectionData);
    }

    public function publicItem(string $section, string $slug): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $item = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($item, 404);

        return $this->renderPublicPage($sectionData, $item);
    }

    public function publicNestedItem(string $section, string $slug, string $child): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $parent = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($parent, 404);

        $item = collect($parent['children'] ?? [])->firstWhere('key', $child);
        abort_unless($item, 404);

        return $this->renderPublicPage($sectionData, $item, collect($parent['children'] ?? [])->values(), "{$slug}/{$child}");
    }

    public function publicNestedLeaf(string $section, string $slug, string $child, string $leaf): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $parent = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($parent, 404);

        $group = collect($parent['children'] ?? [])->firstWhere('key', $child);
        abort_unless($group, 404);

        $item = collect($group['children'] ?? [])->firstWhere('key', $leaf);
        abort_unless($item, 404);

        return $this->renderPublicPage($sectionData, $item, collect($group['children'] ?? [])->values(), "{$slug}/{$child}/{$leaf}");
    }

    public function blog(): View
    {
        return view('blog.index', $this->shared([
            'posts' => config('cea.blog'),
        ]));
    }

    public function blogShow(int $id): View
    {
        $post = collect(config('cea.blog'))->firstWhere('id', $id);
        abort_unless($post, 404);

        return view('blog.show', $this->shared([
            'post' => $post,
        ]));
    }

    public function dynamicPage(string $slug): View
    {
        $page = AdminPage::query()
            ->with(['parent', 'children' => fn ($query) => $query->where('status', 'active')->where('show_in_navigation', true)])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $parentLabel = $page->parent ? $this->localizedPageLabel($page->parent) : ($this->currentLocale() === 'en' ? 'Page' : 'Halaman');
        $pageLabel = $this->localizedPageLabel($page);
        $pageTitle = $this->localizedModelValue($page, 'title');
        $pageSubtitle = $this->localizedModelValue($page, 'subtitle');
        $pageBody = $this->localizedModelValue($page, 'body');

        $section = [
            'key' => 'halaman',
            'label' => $parentLabel,
            'description' => $this->currentLocale() === 'en' ? 'Website page' : 'Halaman website',
            'publicHref' => $page->parent ? route('dynamic.page', $page->parent->slug) : route('dynamic.page', $page->slug),
        ];
        $siblings = $page->parent
            ? $page->parent->children()->where('status', 'active')->where('show_in_navigation', true)->get()
            : $page->children;

        return view('pages.public', $this->shared([
            'section' => $section,
            'item' => [
                'key' => $page->slug,
                'label' => $pageLabel,
                'description' => $pageSubtitle ?: '',
            ],
            'content' => [
                'eyebrow' => $parentLabel,
                'title' => $pageTitle,
                'subtitle' => $pageSubtitle ?: '',
                'body' => $pageBody ?: '',
                'image_path' => $page->image_path ?: '',
                'source_href' => '',
                'status' => $page->status,
                'cards' => [],
            ],
            'siblings' => collect($siblings)->map(fn ($item) => $this->adminPageNavigationItem($item))->values(),
            'updates' => collect(),
        ]));
    }

    public function publicUpdate(string $slug): View
    {
        $update = AdminUpdate::query()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $category = $this->localizedModelValue($update, 'category');
        $title = $this->localizedModelValue($update, 'title');
        $excerpt = $this->localizedModelValue($update, 'excerpt');
        $body = $this->localizedModelValue($update, 'body');

        $content = [
            'eyebrow' => $category,
            'title' => $title,
            'subtitle' => $excerpt ?: '',
            'body' => $body ?: '',
            'image_path' => $update->image_path ?: '',
            'source_href' => route('public.update', $update->slug),
            'status' => $update->status,
            'cards' => [],
            'published_at' => $update->published_at,
        ];

        return view('pages.update', $this->shared([
            'section' => [
                'key' => 'update',
                'label' => $category,
                'description' => $excerpt ?: $title,
                'publicHref' => route('public.update', $update->slug),
            ],
            'item' => null,
            'content' => $content,
            'update' => $update,
            'relatedUpdates' => $this->latestPublicUpdates(5)->where('id', '!=', $update->id)->take(4)->values(),
            'siblings' => collect(),
            'updates' => collect(),
            'donationSettings' => $this->donationSettingsForOwner($update->owner_section_key, $update->owner_item_key),
        ]));
    }

    public function admin(): View|RedirectResponse
    {
        if ($this->adminIsRestricted()) {
            return redirect($this->adminLandingUrl($this->adminUser()));
        }

        $nav = $this->adminNavigation();
        $dropdownSections = collect($nav)->filter(fn ($item) => ! empty($item['children']))->values();
        $childItems = collect($this->flattenAdminItems($nav))
            ->filter(fn ($item) => $this->adminCanManage($item['section_key'], $item['item_key']))
            ->values();

        return view('admin.index', $this->shared(compact('dropdownSections', 'childItems')));
    }

    public function adminPages(): View
    {
        abort_if($this->adminIsRestricted(), 403, 'Hanya super admin yang dapat mengelola halaman dinamis.');

        return view('admin.pages.index', $this->shared([
            'pages' => $this->adminPagesReady()
                ? AdminPage::query()->with('parent')->orderBy('parent_id')->orderBy('sort_order')->orderBy('title')->get()
                : collect(),
            'navigationParents' => $this->navigationParentOptions(),
            'dbReady' => $this->adminPagesReady(),
        ]));
    }

    public function adminUpdates(): View
    {
        $query = AdminUpdate::query()->latest('published_at')->latest();

        if ($this->adminIsRestricted()) {
            $adminUser = $this->adminUser();
            $query->where('owner_section_key', $adminUser['section_key'] ?? '')
                ->where('owner_item_key', $adminUser['item_key'] ?? '');
        }

        return view('admin.updates.index', $this->shared([
            'updates' => $this->adminUpdatesReady() ? $query->get() : collect(),
            'dbReady' => $this->adminUpdatesReady(),
        ]));
    }

    public function createAdminUpdate(): View
    {
        return view('admin.updates.form', $this->shared([
            'update' => new AdminUpdate(['status' => 'draft', 'category' => 'Berita', 'published_at' => now()]),
            'targets' => $this->updateTargetOptions(),
            'formAction' => route('admin.updates.store'),
            'method' => 'POST',
            'title' => 'Tambah Update',
            'dbReady' => $this->adminUpdatesReady(),
        ]));
    }

    public function storeAdminUpdate(Request $request): RedirectResponse
    {
        if (! $this->adminUpdatesReady()) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Tabel admin_updates belum siap. Jalankan migration atau import database/sql/admin_updates.sql dan database/sql/add_bilingual_fields.sql terlebih dulu.']);
        }

        $validated = $this->validateAdminUpdate($request);

        try {
            AdminUpdate::create($validated);
        } catch (\Throwable) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Tabel admin_updates belum siap. Jalankan migration atau import database/sql/admin_updates.sql dan database/sql/add_bilingual_fields.sql terlebih dulu.']);
        }

        return redirect()->route('admin.updates.index')->with('status', 'Update berhasil dibuat.');
    }

    public function editAdminUpdate(AdminUpdate $update): View
    {
        $this->authorizeUpdateOwner($update);

        return view('admin.updates.form', $this->shared([
            'update' => $update,
            'targets' => $this->updateTargetOptions(),
            'formAction' => route('admin.updates.update', $update),
            'method' => 'PUT',
            'title' => 'Edit Update',
            'dbReady' => $this->adminUpdatesReady(),
        ]));
    }

    public function updateAdminUpdate(Request $request, AdminUpdate $update): RedirectResponse
    {
        $this->authorizeUpdateOwner($update);

        try {
            $update->update($this->validateAdminUpdate($request, $update));
        } catch (\Throwable) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Tabel admin_updates belum siap. Jalankan migration atau import database/sql/admin_updates.sql dan database/sql/add_bilingual_fields.sql terlebih dulu.']);
        }

        return redirect()->route('admin.updates.index')->with('status', 'Update berhasil diperbarui.');
    }

    public function destroyAdminUpdate(AdminUpdate $update): RedirectResponse
    {
        $this->authorizeUpdateOwner($update);
        $update->delete();

        return redirect()->route('admin.updates.index')->with('status', 'Update berhasil dihapus.');
    }

    public function createAdminPage(): View
    {
        abort_if($this->adminIsRestricted(), 403, 'Hanya super admin yang dapat mengelola halaman dinamis.');

        return view('admin.pages.form', $this->shared([
            'page' => new AdminPage(['status' => 'draft', 'show_in_navigation' => true, 'sort_order' => 0]),
            'parentPages' => $this->parentPageOptions(),
            'navigationParents' => $this->navigationParentOptions(),
            'formAction' => route('admin.pages.store'),
            'method' => 'POST',
            'title' => 'Tambah Halaman',
            'dbReady' => $this->adminPagesReady(),
        ]));
    }

    public function storeAdminPage(Request $request): RedirectResponse
    {
        abort_if($this->adminIsRestricted(), 403, 'Hanya super admin yang dapat mengelola halaman dinamis.');
        if (! $this->adminPagesReady()) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Tabel admin_pages belum siap. Jalankan migration atau import database/sql/admin_pages.sql dan database/sql/add_bilingual_fields.sql terlebih dulu.']);
        }

        $validated = $this->validateAdminPage($request);

        try {
            AdminPage::create($validated);
        } catch (\Throwable) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Tabel admin_pages belum siap. Jalankan migration atau import database/sql/admin_pages.sql dan database/sql/add_bilingual_fields.sql terlebih dulu.']);
        }

        return redirect()->route('admin.pages.index')->with('status', 'Halaman baru berhasil dibuat.');
    }

    public function editAdminPage(AdminPage $page): View
    {
        abort_if($this->adminIsRestricted(), 403, 'Hanya super admin yang dapat mengelola halaman dinamis.');

        return view('admin.pages.form', $this->shared([
            'page' => $page,
            'parentPages' => $this->parentPageOptions($page),
            'navigationParents' => $this->navigationParentOptions(),
            'formAction' => route('admin.pages.update', $page),
            'method' => 'PUT',
            'title' => 'Edit Halaman',
            'dbReady' => $this->adminPagesReady(),
        ]));
    }

    public function updateAdminPage(Request $request, AdminPage $page): RedirectResponse
    {
        abort_if($this->adminIsRestricted(), 403, 'Hanya super admin yang dapat mengelola halaman dinamis.');

        try {
            $page->update($this->validateAdminPage($request, $page));
        } catch (\Throwable) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Tabel admin_pages belum siap. Jalankan migration atau import database/sql/admin_pages.sql dan database/sql/add_bilingual_fields.sql terlebih dulu.']);
        }

        return redirect()->route('admin.pages.index')->with('status', 'Halaman berhasil diperbarui.');
    }

    public function destroyAdminPage(AdminPage $page): RedirectResponse
    {
        abort_if($this->adminIsRestricted(), 403, 'Hanya super admin yang dapat mengelola halaman dinamis.');

        try {
            $page->delete();
        } catch (\Throwable) {
            return back()->withErrors(['database' => 'Halaman belum dapat dihapus karena database belum siap.']);
        }

        return redirect()->route('admin.pages.index')->with('status', 'Halaman berhasil dihapus.');
    }

    public function adminSection(string $section): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);
        $this->authorizeAdminContent($sectionData['key']);

        return view('admin.section', $this->shared([
            'section' => $sectionData,
            'content' => $sectionData['key'] === 'beranda' ? $this->homepageAdminContent() : $this->adminContent($sectionData),
            'contentKey' => '',
            'formAction' => route('admin.section.update', $sectionData['key']),
            'dbReady' => $this->databaseReady(),
        ]));
    }

    public function adminItem(string $section, string $slug): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $item = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($item, 404);
        $this->authorizeAdminContent($sectionData['key'], $slug);

        return view('admin.item', $this->shared([
            'section' => $sectionData,
            'item' => $item,
            'content' => $this->adminContent($sectionData, $item, $slug),
            'contentKey' => $slug,
            'formAction' => route('admin.item.update', [$sectionData['key'], $slug]),
            'dbReady' => $this->databaseReady(),
        ]));
    }

    public function adminNestedItem(string $section, string $slug, string $child): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $parent = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($parent, 404);

        $item = collect($parent['children'] ?? [])->firstWhere('key', $child);
        abort_unless($item, 404);

        $contentKey = "{$slug}/{$child}";
        $this->authorizeAdminContent($sectionData['key'], $contentKey);

        return view('admin.item', $this->shared([
            'section' => $sectionData,
            'item' => $item,
            'content' => $this->adminContent($sectionData, $item, $contentKey),
            'contentKey' => $contentKey,
            'formAction' => route('admin.nested.item.update', [$sectionData['key'], $slug, $child]),
            'dbReady' => $this->databaseReady(),
        ]));
    }

    public function adminNestedLeaf(string $section, string $slug, string $child, string $leaf): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $parent = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($parent, 404);

        $group = collect($parent['children'] ?? [])->firstWhere('key', $child);
        abort_unless($group, 404);

        $item = collect($group['children'] ?? [])->firstWhere('key', $leaf);
        abort_unless($item, 404);

        $contentKey = "{$slug}/{$child}/{$leaf}";
        $this->authorizeAdminContent($sectionData['key'], $contentKey);

        return view('admin.item', $this->shared([
            'section' => $sectionData,
            'item' => $item,
            'content' => $this->adminContent($sectionData, $item, $contentKey),
            'contentKey' => $contentKey,
            'formAction' => route('admin.nested.leaf.update', [$sectionData['key'], $slug, $child, $leaf]),
            'dbReady' => $this->databaseReady(),
        ]));
    }

    public function updateAdminSection(Request $request, string $section): RedirectResponse
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        return $this->saveAdminContent($request, $sectionData);
    }

    public function updateAdminItem(Request $request, string $section, string $slug): RedirectResponse
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $item = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($item, 404);

        return $this->saveAdminContent($request, $sectionData, $item, $slug);
    }

    public function updateAdminNestedItem(Request $request, string $section, string $slug, string $child): RedirectResponse
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $parent = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($parent, 404);

        $item = collect($parent['children'] ?? [])->firstWhere('key', $child);
        abort_unless($item, 404);

        return $this->saveAdminContent($request, $sectionData, $item, "{$slug}/{$child}");
    }

    public function updateAdminNestedLeaf(Request $request, string $section, string $slug, string $child, string $leaf): RedirectResponse
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $parent = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($parent, 404);

        $group = collect($parent['children'] ?? [])->firstWhere('key', $child);
        abort_unless($group, 404);

        $item = collect($group['children'] ?? [])->firstWhere('key', $leaf);
        abort_unless($item, 404);

        return $this->saveAdminContent($request, $sectionData, $item, "{$slug}/{$child}/{$leaf}");
    }

    public function placeholder(Request $request, string $title): View
    {
        return view('placeholder', $this->shared([
            'title' => $title,
        ]));
    }

    private function shared(array $data = []): array
    {
        $locale = $this->currentLocale();
        app()->setLocale($locale);
        $navigation = request()->is('admin*') ? $this->adminNavigation() : $this->translateNavigation($this->publicNavigation(), $locale);

        return $data + [
            'navigation' => $navigation,
            'currentLocale' => $locale,
            'ui' => $this->uiText($locale),
            'adminUser' => $this->adminUser(),
            'donationSettings' => $data['donationSettings'] ?? $this->homepageDonationSettings(),
        ];
    }

    private function currentLocale(): string
    {
        $locale = session('site_locale', 'id');

        return in_array($locale, ['id', 'en'], true) ? $locale : 'id';
    }

    private function uiText(string $locale): array
    {
        $text = [
            'id' => [
                'search_placeholder' => 'Cari kabar, rilis, dan referensi...',
                'search_content_placeholder' => 'Cari konten Pooling Fund - KSO...',
                'view_hubs' => 'lihat simpul',
                'open_menu' => 'Buka menu',
                'close_menu' => 'Tutup menu',
                'mobile_menu' => 'Menu mobile',
                'footer_description' => 'Platform mandat kolektif antar CSO untuk menghimpun dan menyalurkan dana kemanusiaan berbasis kebutuhan komunitas dan kepemimpinan lokal.',
                'read_mandate' => 'Baca Mandat',
                'see_hubs' => 'Lihat Simpul',
                'menu' => 'Menu',
                'public_channels' => 'Kanal Publik',
                'contact' => 'Kontak',
                'donate_qris' => 'Donasi via QRIS',
                'donation_title' => 'Donasi Pooling Fund - KSO',
                'donation_body' => 'Dukungan Anda membantu memperkuat respon kemanusiaan berbasis komunitas dan kepemimpinan lokal.',
                'qris_placeholder' => 'QRIS Donasi<br>segera tersedia',
                'donation_note' => 'Tempatkan gambar QRIS resmi di area ini saat sudah tersedia. Pastikan nama penerima dan nominal dicek sebelum transaksi.',
                'donation_recipient' => 'Penerima donasi',
                'close_donation' => 'Tutup modal donasi',
                'summary' => 'Ringkasan',
                'summary_prefix' => 'Ringkasan',
                'diagram_relation' => 'Diagram Relasi',
                'members_heading' => 'Simpul & Anggota PF KSO',
                'members_description' => 'Setiap simpul bekerja otonom sesuai konteks wilayah, dengan :active simpul aktif dan :pending simpul yang datanya dapat terus dilengkapi.',
                'regions' => 'Simpul',
                'active' => 'Aktif',
                'members' => 'Anggota',
                'collective_mandate' => 'Mandat Kolektif',
                'humanitarian_pooling' => 'Pooling Fund Kemanusiaan',
                'member_data_soon' => 'Data anggota menyusul',
                'youtube_video' => 'YouTube video',
                'latest_video' => 'Latest Video',
                'new_article' => 'New Article',
                'news_intro' => 'Ikuti cerita, aktivitas, dan pembelajaran dari simpul lokal. Ruang ini menampilkan dokumentasi video dan narasi kerja bersama dalam ekosistem Pooling Fund - KSO.',
                'no_active_news' => 'Belum ada berita aktif untuk halaman ini.',
                'map_label' => 'Peta Simpul',
                'map_title' => 'Jelajahi simpul dan anggota melalui peta interaktif.',
                'search_province' => 'Search Province',
                'province_placeholder' => 'Enter province name...',
                'back' => 'Kembali',
                'search' => 'Search',
                'all_hubs' => 'Semua Simpul',
                'open_page' => 'Buka halaman',
                'learn' => 'Pelajari',
                'read_more' => 'Baca selengkapnya',
            ],
            'en' => [
                'search_placeholder' => 'Search news, releases, and references...',
                'search_content_placeholder' => 'Search Pooling Fund - KSO content...',
                'view_hubs' => 'view hubs',
                'open_menu' => 'Open menu',
                'close_menu' => 'Close menu',
                'mobile_menu' => 'Mobile menu',
                'footer_description' => 'A collective mandate platform among CSOs to pool and channel humanitarian funds based on community needs and local leadership.',
                'read_mandate' => 'Read Mandate',
                'see_hubs' => 'View Hubs',
                'menu' => 'Menu',
                'public_channels' => 'Public Channels',
                'contact' => 'Contact',
                'donate_qris' => 'Donate via QRIS',
                'donation_title' => 'Donate to Pooling Fund - KSO',
                'donation_body' => 'Your support helps strengthen community-based humanitarian response and local leadership.',
                'qris_placeholder' => 'Donation QRIS<br>coming soon',
                'donation_note' => 'Place the official QRIS image here when it is available. Please verify the recipient name and amount before completing a transaction.',
                'donation_recipient' => 'Donation recipient',
                'close_donation' => 'Close donation modal',
                'summary' => 'Overview',
                'summary_prefix' => 'Overview of',
                'diagram_relation' => 'Relationship Diagram',
                'members_heading' => 'PF KSO Hubs & Members',
                'members_description' => 'Each hub works autonomously according to its regional context, with :active active hubs and :pending hubs whose data can continue to be completed.',
                'regions' => 'Hubs',
                'active' => 'Active',
                'members' => 'Members',
                'collective_mandate' => 'Collective Mandate',
                'humanitarian_pooling' => 'Humanitarian Pooling Fund',
                'member_data_soon' => 'Member data coming soon',
                'youtube_video' => 'YouTube video',
                'latest_video' => 'Latest Video',
                'new_article' => 'New Article',
                'news_intro' => 'Follow stories, activities, and learning from local hubs. This space features video documentation and narratives of collective work within the Pooling Fund - KSO ecosystem.',
                'no_active_news' => 'No active news is available for this page yet.',
                'map_label' => 'Hub Map',
                'map_title' => 'Explore hubs and members through the interactive map.',
                'search_province' => 'Search Province',
                'province_placeholder' => 'Enter province name...',
                'back' => 'Back',
                'search' => 'Search',
                'all_hubs' => 'All Hubs',
                'open_page' => 'Open page',
                'learn' => 'Learn',
                'read_more' => 'Read more',
            ],
        ];

        return $text[$locale] ?? $text['id'];
    }

    private function translateNavigation(array $items, string $locale): array
    {
        if ($locale !== 'en') {
            return $items;
        }

        $labels = [
            'beranda' => 'HOME',
            'profil' => 'ABOUT KSO',
            'riwayat' => 'KSO Profile',
            'mandat-visi-nilai' => 'Mandate, Vision, Mission',
            'tujuan-prinsip' => 'Goals & Principles',
            'struktur-gerak' => 'Mandate Architecture',
            'sumber-daya' => 'Resource Governance',
            'kontak' => 'Contact',
            'regio' => 'REGIONAL HUBS',
            'simpul' => 'Hub Distribution',
            'anggota' => 'Members',
        ];

        return collect($items)
            ->map(function (array $item) use ($labels, $locale) {
                if (isset($labels[$item['key']])) {
                    $item['label'] = $labels[$item['key']];
                }

                if (! empty($item['children'])) {
                    $item['children'] = $this->translateNavigation($item['children'], $locale);
                }

                return $item;
            })
            ->all();
    }

    private function findSection(string $key): ?array
    {
        return collect(config('cea.navigation'))->firstWhere('key', $key);
    }

    private function renderPublicPage(array $section, ?array $item = null, mixed $siblings = null, ?string $contentKey = null): View
    {
        $contentKey ??= $item['key'] ?? '';
        $locale = $this->currentLocale();
        $pageContent = $this->pageContent($section, $item);
        $dbContent = $this->adminContent($section, $item, $contentKey);
        $fromDatabase = $dbContent['_from_database'];
        $content = $dbContent['_from_database']
            ? array_merge($pageContent, array_filter($dbContent, fn ($value, $key) => $key !== '_from_database' && filled($value), ARRAY_FILTER_USE_BOTH))
            : $pageContent;
        $content = $this->localizeStaticContent($content, $section['key'], $contentKey);
        $content = $fromDatabase ? $this->localizeAdminContent($content) : $content;
        $content = $this->localizeRegioGeneratedContent($content, $section['key'], $contentKey);

        $localizedSection = $this->translateNavigation([$section], $locale)[0] ?? $section;
        $localizedItem = $item ? ($this->translateNavigation([$item], $locale)[0] ?? $item) : null;
        $siblingItems = $siblings ? collect($siblings)->values() : collect($section['children'] ?? [])->values();
        $siblingItems = $siblingItems
            ->map(fn ($sibling) => $this->translateNavigation([$sibling], $locale)[0] ?? $sibling)
            ->values();

        return view('pages.public', $this->shared([
            'section' => $localizedSection,
            'item' => $localizedItem,
            'content' => $content,
            'siblings' => $siblingItems,
            'socialLinks' => $this->contentSocialLinks($content),
            'donationSettings' => $this->contentDonationSettings($content),
            'updates' => $this->publicUpdates($section['key'], $contentKey),
        ]));
    }

    private function pageContent(array $section, ?array $item = null): array
    {
        $pages = config('cea.page_contents');
        $content = $item
            ? data_get($pages, "{$section['key']}.{$item['key']}", [])
            : data_get($pages, "{$section['key']}._section", []);
        $embeddedContent = $item
            ? collect($item)->only(['eyebrow', 'title', 'subtitle', 'body', 'image_path', 'source_href', 'cards'])->all()
            : [];

        return array_merge([
            'eyebrow' => $section['label'],
            'title' => $item['label'] ?? $section['label'],
            'subtitle' => $item['description'] ?? $section['description'],
            'body' => $item['description'] ?? $section['description'],
            'image_path' => '/assets/img/cea/campur.png',
            'source_href' => $item['sourceHref'] ?? $item['publicHref'] ?? $section['sourceHref'] ?? '',
            'status' => 'active',
            'cards' => [],
        ], $embeddedContent, $content);
    }

    private function adminContent(array $section, ?array $item = null, ?string $contentKey = null): array
    {
        $contentKey ??= $item['key'] ?? '';
        $fallback = [
            'title' => $item['label'] ?? $section['label'],
            'subtitle' => $item['description'] ?? $section['description'],
            'body' => $item['description'] ?? $section['description'],
            'image_path' => '',
            'source_href' => $item['sourceHref'] ?? $item['publicHref'] ?? $section['sourceHref'] ?? '',
            'status' => 'draft',
            'meta' => [],
            '_from_database' => false,
        ];

        try {
            $content = AdminContent::query()
                ->where('section_key', $section['key'])
                ->where('item_key', $contentKey)
                ->first();

            if (! $content) {
                return $fallback;
            }

            return array_merge($fallback, $content->only([
                'title',
                'subtitle',
                'body',
                'image_path',
                'source_href',
                'status',
                'meta',
            ]), ['_from_database' => true]);
        } catch (\Throwable) {
            return $fallback;
        }
    }

    private function localizeAdminContent(array $content): array
    {
        if ($this->currentLocale() !== 'en') {
            return $content;
        }

        $meta = (array) ($content['meta'] ?? []);

        foreach (['eyebrow', 'title', 'subtitle', 'body', 'source_href'] as $field) {
            $translated = $meta[$field.'_en'] ?? null;

            if (filled($translated)) {
                $content[$field] = $translated;
            }
        }

        return $content;
    }

    private function localizeStaticContent(array $content, string $sectionKey, string $contentKey): array
    {
        if ($this->currentLocale() !== 'en') {
            return $content;
        }

        $key = $contentKey === '' ? '_section' : $contentKey;
        $translation = data_get($this->staticContentTranslations(), "{$sectionKey}.{$key}", []);

        return empty($translation) ? $content : array_merge($content, $translation);
    }

    private function localizeRegioGeneratedContent(array $content, string $sectionKey, string $contentKey): array
    {
        if ($this->currentLocale() !== 'en' || $sectionKey !== 'regio' || ! str_starts_with($contentKey, 'simpul/')) {
            return $content;
        }

        $segments = explode('/', $contentKey);
        $region = $this->regionByKey($segments[1] ?? '');

        if (! $region) {
            return $content;
        }

        if (count($segments) === 2) {
            $members = $region['members'] ?? [];
            $memberLines = empty($members)
                ? 'Member data for this regional hub will be completed later.'
                : "Members:\n".implode("\n", array_map(fn ($member) => "- {$member}", $members));

            return array_merge($content, [
                'eyebrow' => 'Hub Distribution',
                'title' => $region['label'],
                'subtitle' => 'KSO-Pooling Fund regional hub.',
                'body' => "{$region['label']} is a regional hub within the KSO-Pooling Fund ecosystem.\n\n{$memberLines}",
                'cards' => empty($members) ? ['Member data coming soon'] : $members,
            ]);
        }

        if (count($segments) === 3) {
            $member = collect($region['members'] ?? [])->first(fn ($name) => $this->memberSlug($name) === $segments[2]);

            if (! $member) {
                return $content;
            }

            return array_merge($content, [
                'eyebrow' => $region['shortLabel'],
                'title' => $member,
                'subtitle' => "Member of {$region['label']}.",
                'body' => "{$member} is a member of {$region['label']} within the KSO-Pooling Fund ecosystem.",
                'cards' => [$region['shortLabel'], 'Hub Member', 'KSO-Pooling Fund'],
            ]);
        }

        return $content;
    }

    private function staticContentTranslations(): array
    {
        return [
            'profil' => [
                '_section' => [
                    'eyebrow' => 'KSO-Pooling Fund Profile',
                    'title' => 'Pooling Fund - KSO',
                    'subtitle' => 'A collective mandate platform among CSOs to pool and channel humanitarian funds together.',
                    'body' => "Large-scale change does not grow from one institution alone, but from a connected ecosystem.\n\nPooling Fund - KSO is a collective mandate platform among CSOs to pool and channel humanitarian funds together, based on community needs and local leadership, without creating a new legal entity.\n\nTagline: Strengthening local action, expanding impact.",
                    'cards' => ['Collective Mandate', 'Local Leadership', 'Humanitarian Response', 'Transparency', 'Accountability'],
                ],
                'riwayat' => [
                    'eyebrow' => 'KSO-Pooling Fund Profile',
                    'title' => 'Pooling Fund - KSO Profile',
                    'subtitle' => 'An operational cooperation platform connecting civil society strengths across Indonesia.',
                    'body' => "Pooling Fund - KSO is not a single hierarchical entity, but a shared infrastructure that connects civil society strengths across Indonesia.\n\nAs an operational cooperation platform, this structure is designed to protect the sovereignty of each member organization while strengthening collective bargaining power in humanitarian resource governance.\n\nKSO moves through seven autonomous and independent regional hubs that remain bound by one shared vision: just local leadership.",
                    'cards' => ['No New Legal Entity', 'Community-Based', 'Local Leadership', 'Seven Regional Hubs'],
                ],
                'mandat-visi-nilai' => [
                    'eyebrow' => 'Mandate, Vision, Mission',
                    'title' => 'Mandate, Vision, Mission of KSO-Pooling Fund',
                    'subtitle' => 'One collective mandate for local leadership and a just humanitarian response.',
                    'body' => "The PF-KSO mandate is to strengthen local leadership, build a social collaboration ecosystem, and promote humanitarian responses that are just, inclusive, and rooted in communities.\n\nVision: one collective mandate for local leadership and a just humanitarian response.\n\nMission: strengthen local leadership and community roles in social and humanitarian response; build an inclusive, equal, and trust-based multi-stakeholder collaboration ecosystem; develop pooling fund approaches and transparent, accountable shared resource governance; encourage knowledge exchange, capacity strengthening, and collective learning; and ensure social development and humanitarian response are more just, participatory, and aligned with vulnerable groups.\n\nKSO-Pooling Fund was formed to pool and manage humanitarian funds quickly, transparently, and accountably; share operational risk, responsibility, and governance collectively; strengthen local leadership in disaster and humanitarian response; reduce response fragmentation; become a trusted communication gateway to donors and the public; and serve as a transition model toward a more established pooling fund institution.",
                    'cards' => ['Collective Mandate', 'Just Vision', 'Collaborative Mission', 'Formation Goals', 'Local First'],
                ],
                'tujuan-prinsip' => [
                    'eyebrow' => 'Goals & Principles',
                    'title' => 'Goals, Principles, and Character of KSO-Pooling Fund',
                    'subtitle' => 'The foundation for fast, transparent, accountable, community-rooted humanitarian response.',
                    'body' => "KSO-Pooling Fund was established to pool and manage humanitarian funds quickly, transparently, and accountably.\n\nThis platform shares operational risk, responsibility, and governance collectively; strengthens local leadership in humanitarian disaster response; reduces response fragmentation; becomes a trusted communication gateway to donors and the public; and serves as a transition model toward a more established pooling fund institution.\n\nIts principles include equality among members, one CSO one vote, community-needs-based work, speed as a core value, transparency as a strategic asset, collective accountability, and local leadership with a local first approach.",
                    'cards' => ['Fast and Accountable', 'Shared Risk', 'Local Leadership', 'Trust Building', 'One CSO One Vote', 'Local First'],
                ],
                'struktur-gerak' => [
                    'eyebrow' => 'Mandate Architecture',
                    'title' => 'Collective Mandate Architecture',
                    'subtitle' => 'Seven autonomous and independent regional hubs connected by one vision of local leadership.',
                    'body' => "Pooling Fund KSO is not a single hierarchical entity, but a shared infrastructure connecting civil society strengths across Indonesia.\n\nThis architecture protects each member organization's sovereignty while strengthening collective bargaining power in humanitarian resource governance. Each regional hub works autonomously and independently while staying connected to the same vision.\n\nThe movement is grounded in a collective mandate through the Member Forum with a one organization, one vote principle; a separation between strategic roles and operational administration; and ecosystem resilience through learning exchange, shared risk, and shared responsibility among regional hubs.",
                    'cards' => ['Member Forum', 'Committee', 'Administrator', 'Regional Hubs', 'One Organization One Vote'],
                ],
                'sumber-daya' => [
                    'eyebrow' => 'Governance',
                    'title' => 'Resource Governance',
                    'subtitle' => 'Resources are treated as a collective mandate to strengthen the humanitarian ecosystem and local leadership.',
                    'body' => "KSO treats resources not as institutional assets, but as a collective mandate to strengthen the humanitarian ecosystem and local leadership.\n\nDecisions are made by those closest to the crisis, so funds are governed transparently for community sovereignty and resilience in each region.\n\nThis approach strengthens response speed, collective accountability, and donor and public trust in locally led humanitarian work.",
                    'cards' => ['Collective Mandate', 'Transparency', 'Accountability', 'Community Sovereignty', 'Regional Resilience'],
                ],
                'kontak' => [
                    'eyebrow' => 'Contact',
                    'title' => 'Contact Us',
                    'subtitle' => 'Pooling Fund - KSO Secretariat in Bantul, DI Yogyakarta.',
                    'body' => "Pooling Fund - KSO Secretariat\nJl. Patih Singoranu No. 155\nTamanan, Banguntapan, Bantul\nDI Yogyakarta\n\nEmail: sekretariat@simpulpfb.id",
                    'cards' => ['Secretariat', 'Email', 'Collaboration', 'Public Information'],
                ],
            ],
            'regio' => [
                '_section' => [
                    'eyebrow' => 'Regional Hubs',
                    'title' => 'Pooling Fund - KSO Regional Hubs',
                    'subtitle' => 'A working map of regional hubs and member organizations in the Pooling Fund - KSO ecosystem.',
                    'body' => 'Regional hubs are spaces for consolidating local CSOs, community organizations, forums, individuals, and community groups within the Pooling Fund - KSO network. Each hub works according to its regional context while remaining connected nationally.',
                    'cards' => ['Hubs', 'Members', 'Focal Point', 'Working Area'],
                ],
                'simpul' => [
                    'eyebrow' => 'Regional Hubs',
                    'title' => 'KSO-Pooling Fund Hub Distribution',
                    'subtitle' => 'Regional hubs and KSO-Pooling Fund members across Indonesia.',
                    'body' => 'The KSO-Pooling Fund ecosystem is organized through regional hubs across Sumatra, Papua, Kalimantan, Java, Sulawesi, and Bali Nusra. Each hub coordinates member organizations based on local context and collective mandate.',
                    'cards' => ['Sumbagsel Tangguh', 'Sumbagsel Pulih dan Lestari', 'Tanah Papua', 'Solidaritas Kemanusiaan Borneo', 'Java', 'Sulawesi', 'Bali Nusra'],
                ],
                'anggota' => [
                    'eyebrow' => 'Regional Hubs',
                    'title' => 'Members',
                    'subtitle' => 'Directory of member organizations and hub relationships.',
                    'body' => 'Pooling Fund - KSO members include civil society organizations, communities, forums, and actors working across development and humanitarian sectors. This member directory can be expanded through the admin panel.',
                    'cards' => ['Organizations', 'Communities', 'Forums', 'Networks'],
                ],
            ],
        ];
    }

    private function regionByKey(string $key): ?array
    {
        return collect(config('cea.simpul_regions', []))->firstWhere('key', $key);
    }

    private function memberSlug(string $member): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $member), '-'));
    }

    private function homepageSection(): array
    {
        return $this->findSection('beranda') ?: [
            'key' => 'beranda',
            'label' => 'BERANDA',
            'description' => 'Halaman utama Pooling Fund - KSO.',
            'sourceHref' => url('/'),
        ];
    }

    private function homepageDefaults(): array
    {
        return [
            'title' => 'Menguatkan lokal, memperluas dampak.',
            'subtitle' => 'Menguatkan Lokal, Memperluas Dampak',
            'body' => 'Perubahan besar tidak lahir dari satu lembaga, tapi dari ekosistem yang terhubung. Pooling Fund - KSO menghimpun dan menyalurkan dana kemanusiaan secara bersama, berbasis kebutuhan komunitas dan kepemimpinan lokal, tanpa membentuk badan hukum baru.',
            'image_path' => '/assets/img/cea/video.mp4',
            'source_href' => '/',
            'status' => 'active',
            'meta' => [
                'title_en' => 'Strengthening local action, expanding impact.',
                'subtitle_en' => 'Strengthening Local Action, Expanding Impact',
                'body_en' => 'Large-scale change does not grow from one institution alone, but from a connected ecosystem. Pooling Fund - KSO pools and channels humanitarian funds collectively, based on community needs and local leadership, without creating a new legal entity.',
                'social_instagram' => '',
                'social_facebook' => '',
                'social_youtube' => '',
                'social_threads' => '',
                'qris_image_path' => '',
                'qris_recipient' => '',
                'qris_title' => '',
                'qris_body' => '',
                'qris_note' => '',
                'qris_image_alt' => '',
                'primary_label' => 'Baca Mandat',
                'primary_label_en' => 'Read Mandate',
                'primary_href' => '/profil/mandat-visi-nilai',
                'secondary_label' => 'Lihat Simpul',
                'secondary_label_en' => 'View Hubs',
                'secondary_href' => '/regio/simpul',
                'panel_label' => 'Ekosistem KSO',
                'panel_label_en' => 'KSO Ecosystem',
                'panel_value' => '7',
                'panel_description' => 'Simpul regional otonom yang terhubung dalam satu mandat kolektif.',
                'panel_description_en' => 'Autonomous regional hubs connected through one collective mandate.',
            ],
        ];
    }

    private function homepageAdminContent(): array
    {
        $defaults = $this->homepageDefaults();
        $content = $this->adminContent($this->homepageSection());

        if (! ($content['_from_database'] ?? false)) {
            return $defaults + ['_from_database' => false];
        }

        $meta = array_merge($defaults['meta'], (array) ($content['meta'] ?? []));
        $merged = array_merge($defaults, array_filter($content, fn ($value, $key) => $key !== 'meta' && $key !== '_from_database' && filled($value), ARRAY_FILTER_USE_BOTH));
        $merged['meta'] = $meta;
        $merged['_from_database'] = true;

        return $merged;
    }

    private function homepageContent(): array
    {
        $content = $this->homepageAdminContent();

        if (($content['_from_database'] ?? false) && ($content['status'] ?? 'active') !== 'active') {
            $content = $this->homepageDefaults() + ['_from_database' => false];
        }

        $meta = array_merge($this->homepageDefaults()['meta'], (array) ($content['meta'] ?? []));
        $title = $content['title'] ?: $this->homepageDefaults()['title'];
        $subtitle = $content['subtitle'] ?: $this->homepageDefaults()['subtitle'];
        $body = $content['body'] ?: $this->homepageDefaults()['body'];

        if ($this->currentLocale() === 'en') {
            $title = filled($meta['title_en'] ?? null) ? $meta['title_en'] : $title;
            $subtitle = filled($meta['subtitle_en'] ?? null) ? $meta['subtitle_en'] : $subtitle;
            $body = filled($meta['body_en'] ?? null) ? $meta['body_en'] : $body;
        }

        return [
            'eyebrow' => $subtitle,
            'title' => $title,
            'description' => $body,
            'video_path' => $content['image_path'] ?: $this->homepageDefaults()['image_path'],
            'primary_label' => $this->localizedMetaLabel($meta, 'primary_label'),
            'primary_href' => $meta['primary_href'] ?? '',
            'secondary_label' => $this->localizedMetaLabel($meta, 'secondary_label'),
            'secondary_href' => $meta['secondary_href'] ?? '',
            'panel_label' => $this->localizedMetaLabel($meta, 'panel_label'),
            'panel_value' => $meta['panel_value'] ?? '',
            'panel_description' => $this->localizedMetaLabel($meta, 'panel_description'),
        ];
    }

    private function homepageSocialLinks(): array
    {
        $content = $this->homepageAdminContent();
        $meta = array_merge($this->homepageDefaults()['meta'], (array) ($content['meta'] ?? []));

        return $this->socialLinksFromMeta($meta);
    }

    private function homepageDonationSettings(): array
    {
        $content = $this->homepageAdminContent();
        $meta = array_merge($this->homepageDefaults()['meta'], (array) ($content['meta'] ?? []));

        return $this->donationSettingsFromMeta($meta);
    }

    private function contentSocialLinks(array $content): array
    {
        return $this->socialLinksFromMeta((array) ($content['meta'] ?? []));
    }

    private function contentDonationSettings(array $content): array
    {
        return $this->donationSettingsFromMeta((array) ($content['meta'] ?? []));
    }

    private function donationSettingsForOwner(?string $sectionKey, ?string $itemKey): array
    {
        try {
            $content = AdminContent::query()
                ->where('section_key', $sectionKey ?? '')
                ->where('item_key', $itemKey ?? '')
                ->first();

            if ($content) {
                return $this->donationSettingsFromMeta((array) $content->meta);
            }
        } catch (\Throwable) {
            //
        }

        return $this->homepageDonationSettings();
    }

    private function donationSettingsFromMeta(array $meta): array
    {
        return [
            'qris_image_path' => trim((string) ($meta['qris_image_path'] ?? '')),
            'qris_recipient' => trim((string) ($meta['qris_recipient'] ?? '')),
            'qris_title' => trim((string) ($this->localizedMetaLabel($meta, 'qris_title') ?: '')),
            'qris_body' => trim((string) ($this->localizedMetaLabel($meta, 'qris_body') ?: '')),
            'qris_note' => trim((string) ($this->localizedMetaLabel($meta, 'qris_note') ?: '')),
            'qris_image_alt' => trim((string) ($this->localizedMetaLabel($meta, 'qris_image_alt') ?: '')),
        ];
    }

    private function socialLinksFromMeta(array $meta): array
    {
        $items = [
            'instagram' => ['label' => 'Instagram', 'icon' => 'fab fa-instagram'],
            'facebook' => ['label' => 'Facebook', 'icon' => 'fab fa-facebook-f'],
            'youtube' => ['label' => 'YouTube', 'icon' => 'fab fa-youtube'],
            'threads' => ['label' => 'Threads', 'icon' => 'threads'],
        ];

        return collect($items)
            ->map(function (array $item, string $key) use ($meta) {
                $url = trim((string) ($meta['social_'.$key] ?? ''));

                if ($url === '') {
                    return null;
                }

                return $item + ['key' => $key, 'url' => $url];
            })
            ->filter()
            ->values()
            ->all();
    }

    private function localizedMetaLabel(array $meta, string $key): string
    {
        if ($this->currentLocale() === 'en' && filled($meta[$key.'_en'] ?? null)) {
            return $meta[$key.'_en'];
        }

        return $meta[$key] ?? '';
    }

    private function saveAdminContent(Request $request, array $section, ?array $item = null, ?string $contentKey = null): RedirectResponse
    {
        $contentKey ??= $item['key'] ?? '';
        $this->authorizeAdminContent($section['key'], $contentKey);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'source_href' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,active,archived'],
            'meta' => ['nullable', 'array'],
            'meta.*' => ['nullable', 'string', 'max:10000'],
        ]);
        $validated['meta'] = collect($request->input('meta', []))
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->all();
        $validated['meta'] = empty($validated['meta']) ? null : $validated['meta'];

        try {
            AdminContent::updateOrCreate(
                [
                    'section_key' => $section['key'],
                    'item_key' => $contentKey,
                ],
                $validated
            );

            return back()->with('status', 'Konten berhasil disimpan ke database.');
        } catch (\Throwable $exception) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Database belum siap atau tabel admin_contents belum dibuat. Import database/sql/admin_contents.sql terlebih dulu.']);
        }
    }

    private function adminUser(): ?array
    {
        return session('admin_user');
    }

    private function adminIsRestricted(): bool
    {
        return ($this->adminUser()['role'] ?? null) === 'member';
    }

    private function adminCanManage(string $sectionKey, string $itemKey = ''): bool
    {
        $adminUser = $this->adminUser();

        if (($adminUser['role'] ?? 'super_admin') === 'super_admin') {
            return true;
        }

        return ($adminUser['section_key'] ?? null) === $sectionKey
            && ($adminUser['item_key'] ?? null) === $itemKey;
    }

    private function authorizeAdminContent(string $sectionKey, string $itemKey = ''): void
    {
        abort_unless($this->adminCanManage($sectionKey, $itemKey), 403, 'Akun ini hanya dapat mengelola submenu yang ditugaskan.');
    }

    private function adminNavigation(): array
    {
        $navigation = config('cea.navigation');
        $adminUser = $this->adminUser();

        if (($adminUser['role'] ?? 'super_admin') !== 'member') {
            return $navigation;
        }

        return $this->filterNavigationForAdmin($navigation, $adminUser);
    }

    private function filterNavigationForAdmin(array $items, array $adminUser, ?string $sectionKey = null, array $path = []): array
    {
        $allowedSection = $adminUser['section_key'] ?? null;
        $allowedItemKey = $adminUser['item_key'] ?? '';
        $filtered = [];

        foreach ($items as $item) {
            $currentSection = $sectionKey ?? $item['key'];
            $currentPath = $sectionKey ? array_merge($path, [$item['key']]) : [];

            if ($currentSection !== $allowedSection) {
                continue;
            }

            $children = $this->filterNavigationForAdmin($item['children'] ?? [], $adminUser, $currentSection, $currentPath);
            $currentItemKey = implode('/', $currentPath);
            $isAssignedItem = $currentItemKey !== '' && $currentItemKey === $allowedItemKey;

            if ($isAssignedItem || ! empty($children)) {
                $item['children'] = $children;
                $filtered[] = $item;
            }
        }

        return $filtered;
    }

    private function flattenAdminItems(array $navigation): array
    {
        $items = [];

        foreach ($navigation as $section) {
            foreach ($section['children'] ?? [] as $item) {
                $this->appendAdminItem($items, $section, $item, [$item['key']], 1);
            }
        }

        return $items;
    }

    private function appendAdminItem(array &$items, array $section, array $item, array $path, int $depth): void
    {
        $itemKey = implode('/', $path);
        $items[] = $item + [
            'section_key' => $section['key'],
            'section_label' => $section['label'],
            'item_key' => $itemKey,
            'depth' => $depth,
            'admin_href' => $this->adminUrlForContent($section['key'], $itemKey),
        ];

        foreach ($item['children'] ?? [] as $child) {
            $this->appendAdminItem($items, $section, $child, array_merge($path, [$child['key']]), $depth + 1);
        }
    }

    private function adminLandingUrl(?array $adminUser): string
    {
        if (($adminUser['role'] ?? null) !== 'member') {
            return route('admin.index');
        }

        return $this->adminUrlForContent($adminUser['section_key'] ?? '', $adminUser['item_key'] ?? '');
    }

    private function adminUrlForContent(string $sectionKey, string $itemKey = ''): string
    {
        if ($sectionKey === '') {
            return route('admin.index');
        }

        if ($itemKey === '') {
            return route('admin.section', $sectionKey);
        }

        $segments = explode('/', $itemKey);

        return match (count($segments)) {
            1 => route('admin.item', [$sectionKey, $segments[0]]),
            2 => route('admin.nested.item', [$sectionKey, $segments[0], $segments[1]]),
            3 => route('admin.nested.leaf', [$sectionKey, $segments[0], $segments[1], $segments[2]]),
            default => route('admin.index'),
        };
    }

    private function publicNavigation(): array
    {
        $navigation = config('cea.navigation');

        try {
            $hasNavigationParentKey = Schema::hasColumn('admin_pages', 'navigation_parent_key');

            if ($hasNavigationParentKey) {
                $submenuPages = AdminPage::query()
                    ->whereNotNull('navigation_parent_key')
                    ->where('navigation_parent_key', '!=', '')
                    ->where('status', 'active')
                    ->where('show_in_navigation', true)
                    ->orderBy('sort_order')
                    ->orderBy('title')
                    ->get();

                $navigation = $this->attachAdminPagesToNavigation($navigation, $submenuPages);
            }

            $pages = AdminPage::query()
                ->whereNull('parent_id')
                ->when($hasNavigationParentKey, fn ($query) => $query->where(function ($query) {
                    $query->whereNull('navigation_parent_key')
                        ->orWhere('navigation_parent_key', '');
                }))
                ->where('status', 'active')
                ->where('show_in_navigation', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get();

            foreach ($pages as $page) {
                $navigation[] = $this->adminPageNavigationItem($page);
            }
        } catch (\Throwable) {
            return $navigation;
        }

        return $navigation;
    }

    private function attachAdminPagesToNavigation(array $navigation, $pages, string $parentPath = ''): array
    {
        return collect($navigation)
            ->map(function (array $item) use ($pages, $parentPath) {
                $path = $parentPath === '' ? $item['key'] : "{$parentPath}/{$item['key']}";
                $children = $item['children'] ?? [];
                $attachedPages = collect($pages)
                    ->where('navigation_parent_key', $path)
                    ->map(fn (AdminPage $page) => $this->adminPageNavigationItem($page))
                    ->values()
                    ->all();

                if (! empty($children)) {
                    $children = $this->attachAdminPagesToNavigation($children, $pages, $path);
                }

                $item['children'] = array_values(array_merge($children, $attachedPages));

                return $item;
            })
            ->all();
    }

    private function adminPageNavigationItem(AdminPage $page): array
    {
        $children = $page->children()
            ->where('status', 'active')
            ->where('show_in_navigation', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();
        $label = $this->localizedPageLabel($page);
        $description = $this->localizedModelValue($page, 'subtitle') ?: $this->localizedModelValue($page, 'title');

        return [
            'key' => 'page-'.$page->slug,
            'label' => $label,
            'href' => route('dynamic.page', $page->slug),
            'publicHref' => route('dynamic.page', $page->slug),
            'description' => $description,
            'children' => $children->map(fn (AdminPage $child) => $this->adminPageNavigationItem($child))->values()->all(),
        ];
    }

    private function localizedPageLabel(AdminPage $page): string
    {
        if ($this->currentLocale() === 'en') {
            return $page->menu_label_en ?: $page->title_en ?: $page->menu_label ?: $page->title;
        }

        return $page->menu_label ?: $page->title;
    }

    private function localizedModelValue(object $model, string $field): string
    {
        if ($this->currentLocale() === 'en') {
            $translatedField = $field.'_en';
            $translated = $model->{$translatedField} ?? null;

            if (filled($translated)) {
                return $translated;
            }
        }

        return (string) ($model->{$field} ?? '');
    }

    private function validateAdminPage(Request $request, ?AdminPage $page = null): array
    {
        $validated = $request->validate([
            'parent_id' => ['nullable', 'integer', 'exists:admin_pages,id'],
            'navigation_parent_key' => ['nullable', 'string', 'max:190'],
            'title' => ['required', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:120'],
            'menu_label' => ['nullable', 'string', 'max:255'],
            'menu_label_en' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'subtitle_en' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'body_en' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,active,archived'],
            'show_in_navigation' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['title']) ?: 'halaman';
        $validated['show_in_navigation'] = $request->boolean('show_in_navigation');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['parent_id'] = $validated['parent_id'] ?: null;
        $validated['navigation_parent_key'] = $validated['navigation_parent_key'] ?? null;

        if ($page && $validated['parent_id'] === $page->id) {
            $validated['parent_id'] = null;
        }

        if (! Schema::hasColumn('admin_pages', 'navigation_parent_key')) {
            unset($validated['navigation_parent_key']);
        } elseif ($validated['navigation_parent_key']) {
            $validNavigationParents = collect($this->navigationParentOptions())->pluck('key')->all();

            if (! in_array($validated['navigation_parent_key'], $validNavigationParents, true)) {
                $validated['navigation_parent_key'] = null;
            }

            $validated['parent_id'] = null;
        }

        $slugExists = AdminPage::query()
            ->where('slug', $validated['slug'])
            ->when($page, fn ($query) => $query->whereKeyNot($page->id))
            ->exists();

        if ($slugExists) {
            $validated['slug'] = $this->uniquePageSlug($validated['slug'], $page);
        }

        return $validated;
    }

    private function validateAdminUpdate(Request $request, ?AdminUpdate $update = null): array
    {
        $rules = [
            'target' => ['nullable', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:80'],
            'category_en' => ['nullable', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'excerpt_en' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'body_en' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,active,archived'],
            'published_at' => ['nullable', 'date'],
        ];
        $validated = $request->validate($rules);
        $adminUser = $this->adminUser();

        if ($this->adminIsRestricted()) {
            $validated['owner_section_key'] = $adminUser['section_key'] ?? '';
            $validated['owner_item_key'] = $adminUser['item_key'] ?? '';
        } else {
            [$sectionKey, $itemKey] = array_pad(explode('|', $validated['target'] ?? '', 2), 2, '');
            $validated['owner_section_key'] = $sectionKey ?: 'regio';
            $validated['owner_item_key'] = $itemKey;
        }

        unset($validated['target']);
        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['title']) ?: 'update';

        if (AdminUpdate::query()->where('slug', $validated['slug'])->when($update, fn ($query) => $query->whereKeyNot($update->id))->exists()) {
            $validated['slug'] = $this->uniqueUpdateSlug($validated['slug'], $update);
        }

        return $validated;
    }

    private function uniqueUpdateSlug(string $slug, ?AdminUpdate $update = null): string
    {
        $baseSlug = $slug;
        $counter = 2;

        while (AdminUpdate::query()->where('slug', $slug)->when($update, fn ($query) => $query->whereKeyNot($update->id))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function authorizeUpdateOwner(AdminUpdate $update): void
    {
        if (! $this->adminIsRestricted()) {
            return;
        }

        $adminUser = $this->adminUser();
        abort_unless(
            $update->owner_section_key === ($adminUser['section_key'] ?? null)
            && $update->owner_item_key === ($adminUser['item_key'] ?? null),
            403,
            'Akun ini hanya dapat mengelola update pada halaman yang ditugaskan.'
        );
    }

    private function updateTargetOptions(): array
    {
        if ($this->adminIsRestricted()) {
            $adminUser = $this->adminUser();

            return [[
                'value' => ($adminUser['section_key'] ?? '').'|'.($adminUser['item_key'] ?? ''),
                'label' => 'Halaman saya',
            ]];
        }

        return collect($this->flattenAdminItems(config('cea.navigation')))
            ->map(fn ($item) => [
                'value' => $item['section_key'].'|'.$item['item_key'],
                'label' => $item['section_label'].' / '.str_repeat('- ', max($item['depth'] - 1, 0)).$item['label'],
            ])
            ->values()
            ->all();
    }

    private function publicUpdates(string $sectionKey, string $itemKey)
    {
        try {
            return AdminUpdate::query()
                ->where('owner_section_key', $sectionKey)
                ->where('owner_item_key', $itemKey)
                ->where('status', 'active')
                ->latest('published_at')
                ->latest()
                ->limit(6)
                ->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    private function latestPublicUpdates(int $limit = 4)
    {
        try {
            return AdminUpdate::query()
                ->where('status', 'active')
                ->latest('published_at')
                ->latest()
                ->limit($limit)
                ->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    private function uniquePageSlug(string $slug, ?AdminPage $page = null): string
    {
        $baseSlug = $slug;
        $counter = 2;

        while (AdminPage::query()->where('slug', $slug)->when($page, fn ($query) => $query->whereKeyNot($page->id))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function parentPageOptions(?AdminPage $exceptPage = null)
    {
        try {
            $excludedIds = $exceptPage ? array_merge([$exceptPage->id], $this->descendantPageIds($exceptPage)) : [];

            return AdminPage::query()
                ->when(! empty($excludedIds), fn ($query) => $query->whereNotIn('id', $excludedIds))
                ->orderBy('title')
                ->get();
        } catch (\Throwable) {
            return collect();
        }
    }

    private function navigationParentOptions(): array
    {
        return $this->flattenNavigationParentOptions(config('cea.navigation'));
    }

    private function flattenNavigationParentOptions(array $items, string $parentPath = '', string $labelPrefix = ''): array
    {
        return collect($items)
            ->flatMap(function (array $item) use ($parentPath, $labelPrefix) {
                $path = $parentPath === '' ? $item['key'] : "{$parentPath}/{$item['key']}";
                $label = trim($labelPrefix.($item['label'] ?? $item['key']));
                $options = [[
                    'key' => $path,
                    'label' => $label,
                ]];

                if (! empty($item['children'])) {
                    $options = array_merge(
                        $options,
                        $this->flattenNavigationParentOptions($item['children'], $path, "{$label} / ")
                    );
                }

                return $options;
            })
            ->values()
            ->all();
    }

    private function descendantPageIds(AdminPage $page): array
    {
        $ids = [];

        foreach ($page->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->descendantPageIds($child));
        }

        return $ids;
    }

    private function adminPagesReady(): bool
    {
        try {
            foreach (['navigation_parent_key', 'title_en', 'menu_label_en', 'subtitle_en', 'body_en'] as $column) {
                if (! Schema::hasColumn('admin_pages', $column)) {
                    return false;
                }
            }

            AdminPage::query()->limit(1)->exists();

            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    private function adminUpdatesReady(): bool
    {
        try {
            AdminUpdate::query()->limit(1)->exists();

            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    private function databaseReady(): bool
    {
        try {
            AdminContent::query()->limit(1)->exists();

            return true;
        } catch (\Throwable) {
            return false;
        }
    }
}
