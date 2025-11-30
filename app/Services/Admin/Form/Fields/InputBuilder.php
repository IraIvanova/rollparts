<?php

namespace App\Services\Admin\Form\Fields;

use App\Services\Admin\Form\Fields\Traits\HasAutoLabel;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;

class InputBuilder extends TextInput
{
    use HasAutoLabel;

    protected function makeComponent(string $name): Component
    {
        return TextInput::make($name);
    }

    public function autoSlug(): static
    {
        $this->afterStateUpdated(fn($set, ?string $state) => $set('../../slug', Str::slug($state)));

        return $this;
    }
}
