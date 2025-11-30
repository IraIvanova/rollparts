<?php

namespace App\Services\Admin\Form\Fields;

use App\Services\Admin\Form\Fields\Traits\HasAutoLabel;
use Filament\Forms\Components\Select;
use App\Models\Language;

class SelectBuilder extends Select
{
    use HasAutoLabel;

    public static function make(string $name): static
    {
        return parent::make($name);
    }

    public function languagesType(): static
    {
        //move languages pluck to other service
        $this->options(Language::all()->pluck('name', 'code')->toArray())
            ->searchable()
            ->default('tr');

        return $this;
    }
}
