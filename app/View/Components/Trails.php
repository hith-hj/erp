<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Trails extends Component
{
    public $breadcrumbs;

    public $titles;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($titles = [])
    {
        $this->generateBreadcrumbs();
    }

    private function generateBreadcrumbs(): void
    {
        // 1. Anchor node (Home)
        $this->breadcrumbs[] = [
            'link' => url('/'),
            'name' => __('locale.Home'),
            'active' => false,
        ];

        $segments = request()->segments();
        $totalSegments = count($segments);

        if ($totalSegments === 0 || request()->path() === '/') {
            $this->breadcrumbs[0]['active'] = true;
            $this->breadcrumbs[0]['link'] = null;
            return;
        }

        foreach ($segments as $index => $segment) {
            $isLast = ($index === $totalSegments - 1);

            if (is_numeric($segment) || Str::isUuid($segment)) {
                continue;
            }

            if ($isLast) {
                $link = null;
            } else {
                $link = str_contains(request()->path(), 'all')
                    ? 'javascript:void(0)'
                    : url($segment . '/all');
            }

            $this->breadcrumbs[] = [
                'link' => $link,
                'name' => $this->resolveSegmentName($segment, $isLast),
                'active' => $isLast,
            ];
        }
    }

    /**
     * Translate or transform URL slugs into clean title nodes.
     */
    private function resolveSegmentName(string $segment, bool $isLast): string
    {
        if ($isLast && !empty($this->titles)) {
            return implode(' - ', $this->titles);
        }

        $translationKey = $isLast
            ? 'locale.' . Str::studly($segment)
            : 'locale.' . Str::studly(Str::plural($segment));

        return Lang::has($translationKey)
            ? __($translationKey)
            : Str::headline($segment);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.trails');
    }
}
