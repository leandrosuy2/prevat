<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use TallStackUi\View\Components\Select\Traits\InteractsWithSelectOptions;

class SelectStyled extends Component
{
    /**
     * Create a new component instance.
     */
    use InteractsWithSelectOptions;
    public function __construct(
        public ?string $label = null,
        public ?string $value = null,
//        public ?string $hint = null,
        public Collection|array $options = [],
//        public ?string $select = null,
//        public ?array $selectable = [],
    )
    {
//        $this->options();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-styled');
    }
}
