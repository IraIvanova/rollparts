<?php

namespace App\Services\Admin\Form\Fields\Traits;

use Illuminate\Support\Str;

trait HasAutoLabel
{
    protected static function applyAutoLabel($instance, string $name, ?string $label = null)
    {
        $instance->label($label ?? Str::headline($name));

        return $instance;
    }
}
