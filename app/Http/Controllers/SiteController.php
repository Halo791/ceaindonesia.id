<?php

namespace App\Http\Controllers;

use App\Models\AdminContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('home', $this->shared());
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
            'navigation' => request()->is('admin*') ? $this->adminNavigation() : config('cea.navigation'),
            'adminUser' => $this->adminUser(),
        ];
    }

    private function findSection(string $key): ?array
    {
        return collect(config('cea.navigation'))->firstWhere('key', $key);
    }

    private function renderPublicPage(array $section, ?array $item = null, mixed $siblings = null, ?string $contentKey = null): View
    {
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
