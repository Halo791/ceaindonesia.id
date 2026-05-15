<?php

namespace App\Http\Controllers;

use App\Models\AdminContent;
use App\Models\AdminPage;
use App\Models\AdminUpdate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('home', $this->shared([
            'latestUpdates' => $this->latestPublicUpdates(),
        ]));
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

        $section = [
            'key' => 'halaman',
            'label' => $page->parent?->menu_label ?: $page->parent?->title ?: 'Halaman',
            'description' => 'Halaman website',
            'publicHref' => $page->parent ? route('dynamic.page', $page->parent->slug) : route('dynamic.page', $page->slug),
        ];
        $siblings = $page->parent
            ? $page->parent->children()->where('status', 'active')->where('show_in_navigation', true)->get()
            : $page->children;

        return view('pages.public', $this->shared([
            'section' => $section,
            'item' => [
                'key' => $page->slug,
                'label' => $page->menu_label ?: $page->title,
                'description' => $page->subtitle ?: '',
            ],
            'content' => [
                'eyebrow' => $page->parent?->menu_label ?: $page->parent?->title ?: 'Halaman',
                'title' => $page->title,
                'subtitle' => $page->subtitle ?: '',
                'body' => $page->body ?: '',
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

        return view('pages.public', $this->shared([
            'section' => [
                'key' => 'update',
                'label' => $update->category,
                'description' => $update->excerpt ?: $update->title,
                'publicHref' => route('public.update', $update->slug),
            ],
            'item' => null,
            'content' => [
                'eyebrow' => $update->category,
                'title' => $update->title,
                'subtitle' => $update->excerpt ?: '',
                'body' => $update->body ?: '',
                'image_path' => $update->image_path ?: '',
                'source_href' => '',
                'status' => $update->status,
                'cards' => [],
            ],
            'siblings' => collect(),
            'updates' => collect(),
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
                ->withErrors(['database' => 'Tabel admin_updates belum tersedia. Jalankan migration atau import database/sql/admin_updates.sql terlebih dulu.']);
        }

        $validated = $this->validateAdminUpdate($request);

        try {
            AdminUpdate::create($validated);
        } catch (\Throwable) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Tabel admin_updates belum tersedia. Jalankan migration atau import database/sql/admin_updates.sql terlebih dulu.']);
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
                ->withErrors(['database' => 'Tabel admin_updates belum tersedia. Jalankan migration atau import database/sql/admin_updates.sql terlebih dulu.']);
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
                ->withErrors(['database' => 'Tabel admin_pages belum tersedia. Jalankan migration atau import database/sql/admin_pages.sql terlebih dulu.']);
        }

        $validated = $this->validateAdminPage($request);

        try {
            AdminPage::create($validated);
        } catch (\Throwable) {
            return back()
                ->withInput()
                ->withErrors(['database' => 'Tabel admin_pages belum tersedia. Jalankan migration atau import database/sql/admin_pages.sql terlebih dulu.']);
        }

        return redirect()->route('admin.pages.index')->with('status', 'Halaman baru berhasil dibuat.');
    }

    public function editAdminPage(AdminPage $page): View
    {
        abort_if($this->adminIsRestricted(), 403, 'Hanya super admin yang dapat mengelola halaman dinamis.');

        return view('admin.pages.form', $this->shared([
            'page' => $page,
            'parentPages' => $this->parentPageOptions($page),
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
                ->withErrors(['database' => 'Tabel admin_pages belum tersedia. Jalankan migration atau import database/sql/admin_pages.sql terlebih dulu.']);
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
            'content' => $this->adminContent($sectionData),
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
        return $data + [
            'navigation' => request()->is('admin*') ? $this->adminNavigation() : $this->publicNavigation(),
            'adminUser' => $this->adminUser(),
        ];
    }

    private function findSection(string $key): ?array
    {
        return collect(config('cea.navigation'))->firstWhere('key', $key);
    }

    private function renderPublicPage(array $section, ?array $item = null, mixed $siblings = null, ?string $contentKey = null): View
    {
        $contentKey ??= $item['key'] ?? '';
        $pageContent = $this->pageContent($section, $item);
        $dbContent = $this->adminContent($section, $item, $contentKey);
        $content = $dbContent['_from_database']
            ? array_merge($pageContent, array_filter($dbContent, fn ($value, $key) => $key !== '_from_database' && filled($value), ARRAY_FILTER_USE_BOTH))
            : $pageContent;

        return view('pages.public', $this->shared([
            'section' => $section,
            'item' => $item,
            'content' => $content,
            'siblings' => $siblings ? collect($siblings)->values() : collect($section['children'] ?? [])->values(),
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
            ]), ['_from_database' => true]);
        } catch (\Throwable) {
            return $fallback;
        }
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
        ]);

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
            $pages = AdminPage::query()
                ->whereNull('parent_id')
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

    private function adminPageNavigationItem(AdminPage $page): array
    {
        $children = $page->children()
            ->where('status', 'active')
            ->where('show_in_navigation', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return [
            'key' => 'page-'.$page->slug,
            'label' => $page->menu_label ?: $page->title,
            'href' => route('dynamic.page', $page->slug),
            'publicHref' => route('dynamic.page', $page->slug),
            'description' => $page->subtitle ?: $page->title,
            'children' => $children->map(fn (AdminPage $child) => $this->adminPageNavigationItem($child))->values()->all(),
        ];
    }

    private function validateAdminPage(Request $request, ?AdminPage $page = null): array
    {
        $validated = $request->validate([
            'parent_id' => ['nullable', 'integer', 'exists:admin_pages,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:120'],
            'menu_label' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,active,archived'],
            'show_in_navigation' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['title']) ?: 'halaman';
        $validated['show_in_navigation'] = $request->boolean('show_in_navigation');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['parent_id'] = $validated['parent_id'] ?: null;

        if ($page && $validated['parent_id'] === $page->id) {
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
            'slug' => ['nullable', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
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
