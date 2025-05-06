<?php

namespace App\Filament\Admin\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class WebsiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    public static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    public static string $view = 'filament.pages.website-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(
            \App\Models\WebsiteSettings::first()->toArray()
        );
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('free_shipping_threshold')
                ->label('Free Shipping Threshold')
                ->numeric()
                ->required(),

            TextInput::make('fixed_shipping_price')
                ->label('Fixed Shipping Price')
                ->numeric()
                ->required(),
        ];
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function save(): void
    {
        $settings = \App\Models\WebsiteSettings::first();
        $settings->update($this->form->getState());

        Notification::make()
            ->title('Settings updated successfully.')
            ->success()
            ->send();
    }
}
