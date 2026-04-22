<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class StaffLayout extends Component
{
    public $staff;

    /**
     * Create a new component instance.
     */
    public function __construct($staff = null)
    {
        $this->staff = $staff ?: Auth::guard('staff')->user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.staff-layout');
    }
}
