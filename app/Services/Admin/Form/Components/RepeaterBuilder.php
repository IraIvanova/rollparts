<?php

namespace App\Services\Admin\Form\Components;

use Filament\Forms\Components\Repeater;
use Illuminate\Support\Str;

class RepeaterBuilder extends Repeater
{
    protected Repeater $repeater;

    public static function make(string $name, ?string $label = null): static
    {
        return parent::make($name);
    }

//    public function
}
