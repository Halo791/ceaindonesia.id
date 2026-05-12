<?php

namespace App\Http\Controllers;

use App\Models\AdminContent;
use Illuminate\Database\QueryException;
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

    public function admin(): View
    {
        $nav = config('cea.navigation');
        $dropdownSections = collect($nav)->filter(fn ($item) => ! empty($item['children']))->values();
        $childItems = $dropdownSections->flatMap(function ($section) {
            return collect($section['children'])->map(fn ($child) => $child + [
                'section_key' => $section['key'],
                'section_label' => $section['label'],
            ]);
        })->values();

        return view('admin.index', $this->shared(compact('dropdownSections', 'childItems')));
    }

    public function adminSection(string $section): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        return view('admin.section', $this->shared([
            'section' => $sectionData,
            'content' => $this->adminContent($sectionData),
            'dbReady' => $this->databaseReady(),
        ]));
    }

    public function adminItem(string $section, string $slug): View
    {
        $sectionData = $this->findSection($section);
        abort_unless($sectionData, 404);

        $item = collect($sectionData['children'] ?? [])->firstWhere('key', $slug);
        abort_unless($item, 404);

        return view('admin.item', $this->shared([
            'section' => $sectionData,
            'item' => $item,
            'content' => $this->adminContent($sectionData, $item),
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

        return $this->saveAdminContent($request, $sectionData, $item);
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
            'navigation' => config('cea.navigation'),
        ];
    }

    private function findSection(string $key): ?array
    {
        return collect(config('cea.navigation'))->firstWhere('key', $key);
    }

    private function renderPublicPage(array $section, ?array $item = null): View
    {
        $pageContent = $this->pageContent($section, $item);
        $dbContent = $this->adminContent($section, $item);
        $content = $dbContent['_from_database']
            ? array_merge($pageContent, array_filter($dbContent, fn ($value, $key) => $key !== '_from_database' && filled($value), ARRAY_FILTER_USE_BOTH))
            : $pageContent;

        return view('pages.public', $this->shared([
            'section' => $section,
            'item' => $item,
            'content' => $content,
            'siblings' => collect($section['children'] ?? [])->values(),
        ]));
    }

    private function pageContent(array $section, ?array $item = null): array
    {
        $pages = config('cea.page_contents');
        $content = $item
            ? data_get($pages, "{$section['key']}.{$item['key']}", [])
            : data_get($pages, "{$section['key']}._section", []);

        return array_merge([
            'eyebrow' => $section['label'],
            'title' => $item['label'] ?? $section['label'],
            'subtitle' => $item['description'] ?? $section['description'],
            'body' => $item['description'] ?? $section['description'],
            'image_path' => '/assets/img/cea/campur.png',
            'source_href' => $item['sourceHref'] ?? $section['sourceHref'] ?? '',
            'status' => 'active',
            'cards' => [],
        ], $content);
    }

    private function adminContent(array $section, ?array $item = null): array
    {
        $fallback = [
            'title' => $item['label'] ?? $section['label'],
            'subtitle' => $item['description'] ?? $section['description'],
            'body' => $item['description'] ?? $section['description'],
            'image_path' => '',
            'source_href' => $item['sourceHref'] ?? $section['sourceHref'] ?? '',
            'status' => 'draft',
            '_from_database' => false,
        ];

        try {
            $content = AdminContent::query()
                ->where('section_key', $section['key'])
                ->where('item_key', $item['key'] ?? '')
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

    private function saveAdminContent(Request $request, array $section, ?array $item = null): RedirectResponse
    {
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
                    'item_key' => $item['key'] ?? '',
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
