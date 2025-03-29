<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageHeader extends Component
{
    public $pageHeader;
    /**
     * Create a new component instance.
     */
    public function __construct($pageHeader)
    {
        $this->pageHeader = $pageHeader;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-header');
    }
}
