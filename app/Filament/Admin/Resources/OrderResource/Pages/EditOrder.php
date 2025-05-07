<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Constant\StatusesConstants;
use App\Filament\Admin\Forms\OrderClientInfoForm;
use App\Filament\Admin\Forms\OrderInfoForm;
use App\Filament\Admin\Forms\OrderPaymentSectionForm;
use App\Filament\Admin\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Filament\Actions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    #[On('refreshForm')]
    public function refreshForm(): void
    {
        parent::refreshFormData(array_keys($this->record->toArray()));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            OrderInfoForm::makeEditFormSections(),
                            OrderPaymentSectionForm::make(),
                        ]),
                ]),
            OrderClientInfoForm::make(),
            Section::make()
                ->schema([
                    Fieldset::make('Order total & applied discounts')
                        ->schema([
                            TextInput::make('total_price_with_discount')
                                ->label('Final Price (with all discounts applied)')
                                ->prefix('₺')
                                ->numeric()
                                ->reactive()
                                ->afterStateHydrated(function (callable $set, callable $get) {
                                    $discount = $get('manual_discount') ?? 0;
                                    $set(
                                        'total_price_with_discount',
                                        +number_format($get('total_price_with_discount') - $discount, 2, '.', '')
                                    );
                                })
                                ->disabled(),
                            TextInput::make('total_price')
                                ->label('Net price')
                                ->prefix('₺')
                                ->disabled(),
                            TextInput::make('manual_discount')
                                ->numeric()
                                ->prefix('₺')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, callable $set, callable $get, Order $record) {
                                    $set(
                                        'total_price_with_discount',
                                        OrderService::calculateTotalPriceWithManualDiscount($record, $state)
                                    );
                                })
                                ->label('Manual discount'),
                            TextInput::make('cargo_price')
                                ->label('Cargo Price')
                                ->numeric()
                                ->prefix('₺')
                                ->required()
                                ->default(250),
                            TextInput::make('used_promo')
                                ->label('Used promo code')
                                ->disabled(),
                            Placeholder::make('total')
                                ->label('Total price with shipping')
                                ->inlineLabel()
                                ->content(fn($get) => $get('total_price_with_discount') + $get('cargo_price'))
                                ->columnSpanFull(),
                        ])
                ])
        ]);
    }

    /**
     * @throws ValidationException
     */
    protected function beforeSave(): void
    {
        $orderService = app(OrderService::class);

        $oldStatus = $this->oldFormState['data']['status_id'];
        $newStatus = +$this->data['status_id'];

        if ($oldStatus !== $newStatus && !$orderService->canTransitionTo(
                $this->oldFormState['data']['status_id'],
                +$this->data['status_id']
            )) {
            throw ValidationException::withMessages([
                'status' => 'This record cannot be updated because it doesn’t meet the required conditions.',
            ]);
        }
    }

    protected function afterSave(): void
    {
        $order = $this->record;
        $payment = $order->payment;

        if ($payment && $payment->hasMedia('payment_confirmation')) {
            $payment->status = StatusesConstants::SUCCESSFUL;
            $payment->save();
        }

        $orderService = app(OrderService::class);

        if (in_array($this->data['status_id'], StatusesConstants::CANCELLATION_STATUSES)) {
            $orderService->returnProductsToStock($order);
        }
    }
}
