<?php

namespace App\Filament\Admin\Forms;

use App\Models\Order;
use App\Models\Status;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\HtmlString;

class OrderPaymentSectionForm
{
    public static function make(): Fieldset
    {
        return Fieldset::make('Payment')
            ->relationship('payment')
            ->schema([
                Placeholder::make('payment_method')
                    ->label('Payment method')
                    ->inlineLabel()
                    ->content(fn($get) => $get('../payment_method'))
                    ->columnSpanFull(),
                Placeholder::make('status')
                    ->label('Payment status')
                    ->inlineLabel()
                    ->content(function ($get) {
                        $status = $get('status');

                        if ($status) return $status;

                        return 'No payment information available';
                    })
                    ->extraAttributes(fn($get) => [
                        'class' => $get(
                            'status'
                        ) === 'success' ? 'text-green-600 font-bold' : 'text-red-600 font-bold',
                    ])
                    ->columnSpanFull(),
                Placeholder::make('transaction_timestamp')
                    ->label('Created at')
                    ->inlineLabel()
                    ->content(fn($get, $record) => $get('transaction_timestamp') ?? $record->created_at->format('d.m.Y H:i:s'))
                    ->visible(fn($get, $record) => $get('transaction_timestamp') || $record?->hasMedia('payment_confirmation'))
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('payment_confirmation')
                    ->collection('payment_confirmation')
                    ->helperText('Upload a bank receipt or payment proof (PDF, JPG, PNG)')
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->preserveFilenames()
                    ->visible(fn($record, $get) => $get('../payment_method')!== 'online' && !$record?->hasMedia('payment_confirmation'))
                    ->columnSpan('full'),


                Forms\Components\Placeholder::make('payment_confirmation_view')
                    ->label('Payment confirmation')
                    ->inlineLabel()
                    ->content(function ($record) {
                        $media = $record->getFirstMedia('payment_confirmation');

                        return new HtmlString('<a href="' . $media->getFullUrl() . '" target="_blank" class="text-primary-600 underline">View Payment Confirmation</a>');
                    })
                    ->visible(fn($record) => $record && $record->hasMedia('payment_confirmation'))
                    ->columnSpanFull(),

                Actions::make([
                    Action::make('remove_payment_confirmation')
                        ->label('Remove confirmation')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->visible(fn($record) => $record && $record->hasMedia('payment_confirmation'))
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->clearMediaCollection('payment_confirmation');
                            $record->delete();
                        })
                ]),
            ])
            ->columnSpan(1);
    }
}
