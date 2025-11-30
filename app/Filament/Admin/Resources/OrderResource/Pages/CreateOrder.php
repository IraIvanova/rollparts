<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Forms\SearchOrCreateClientForm;
use App\Filament\Admin\Forms\SearchProductForm;
use App\Filament\Admin\Resources\OrderResource;
use App\Models\Product;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    public array $selectedProducts = [];

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('New Order')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('status_id')
                                ->label('Status')
                                ->relationship('status', 'name')
                                ->required(),

                            Textarea::make('notes')
                                ->label('Order notes')
                                ->columnSpanFull(),
                        ]),
                ]),
            //TODO search existing or create new client + create order history after creating order
            SearchOrCreateClientForm::make(),
            Section::make('Order Products')
                ->schema([
                    Actions::make([
                        Action::make('add_products')
                            ->label('Add product to order')
                            ->icon('heroicon-o-user-plus')
                            ->color('primary')
                        ->form(SearchProductForm::make())
                            ->action(function (array $data) {
                                $this->addProductToSelection($data['product_id']);
                            }),
                    ]),
                    View::make('livewire.selected-products-table')
                        ->viewData([
                            'selectedProducts' => $this->selectedProducts
                        ]),
                ]),
        ]);
    }

    public function addProductToSelection(int $productId): void
    {
        $product = Product::find($productId);

        if ($product) {
            // Check if product already exists in selection
            $exists = collect($this->selectedProducts)->contains('id', $productId);

            if (!$exists) {
                $this->selectedProducts[] = $product;
                $this->dispatch('productsUpdated', selectedProducts: $this->selectedProducts);
            }
        }
    }

    public function removeProduct(int $productId): void
    {
        $initialCount = count($this->selectedProducts);
        $this->selectedProducts = array_filter($this->selectedProducts, function($product) use ($productId) {
            return $product['id'] !== $productId;
        });

        // Only dispatch if a product was actually removed
        if (count($this->selectedProducts) !== $initialCount) {
            $this->dispatch('productsUpdated');
        }
    }

//    protected function afterCreate(): void
//    {
//        // Handle saving the selected products to the order
//        if ($this->record && !empty($this->selectedProducts)) {
//            $products = collect($this->selectedProducts)->mapWithKeys(function ($product) {
//                return [$product['id'] => [
//                    'quantity' => 1, // You might want to add quantity field to your form
//                    'price' => $product['price']
//                ]];
//            });
//
//            $this->record->products()->attach($products->toArray());
//        }
//
//        parent::afterCreate();
//    }
}
