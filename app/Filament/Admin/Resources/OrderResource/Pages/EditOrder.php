<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Constant\StatusesConstants;
use App\Filament\Admin\Resources\OrderResource;
use App\Services\OrderService;
use Filament\Actions;
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
