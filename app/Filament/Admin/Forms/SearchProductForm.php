<?php

namespace App\Filament\Admin\Forms;

use App\Models\ProductTranslation;
use App\Models\User;
use App\Services\UserService;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class SearchProductForm
{
    public static function make(): array
    {
        return [
                Select::make('product_id')
                    ->label('Product')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $query) {
//                        $existingProductIds = $this->ownerRecord->orderProducts->pluck('product_id')->toArray();

                        return ProductTranslation::where('name', 'like', "%{$query}%")
//                            ->whereNotIn('product_id', $existingProductIds)
                            ->limit(20)
                            ->pluck('name', 'product_id');
                    })
                    ->required(),

//                Actions::make([
//                    Action::make('create_new_client')
//                        ->label('Create New Client')
//                        ->icon('heroicon-o-user-plus')
//                        ->color('primary')
//                        ->modalHeading('Create New Client')
//                        ->form(ClientForm::makeClientForOrderPage())
//                        ->action(function (array $data, callable $set) {
//                            $user = User::create([
//                                'name' => $data['name'],
//                                'last_name' => $data['last_name'],
//                                'email' => $data['email'],
//                                'phone' => $data['phone'],
//                                'password' => bcrypt($data['password']),
//                            ]);
//
//                            $user->assignRole('client');
//
//                            // Automatically select the newly created user
//                            $set('user_id', $user->id);
//                        }),
//                ])
//                ->columnSpan(2)
            ]
            ;
    }
}
