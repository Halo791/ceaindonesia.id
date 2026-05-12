<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('home', $this->shared());
    }

    public function riwayat(): View
    {
        return view('pages.riwayat', $this->shared());
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
        ]));
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
}
