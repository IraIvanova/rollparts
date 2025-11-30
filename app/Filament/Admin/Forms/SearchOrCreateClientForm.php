<?php

namespace App\Filament\Admin\Forms;

use App\Models\User;
use App\Services\UserService;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class SearchOrCreateClientForm
{
    public static function make(): Section
    {
        return Section::make('Client')
            ->schema([
                Select::make('user_id')
                    ->label('Select Existing Client')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search) {
                        return UserService::searchClients($search);
                    })
                    ->getOptionLabelUsing(fn($value) => $value)
                    ->placeholder('Search by name or email')
                    ->columnSpan(2),

                Actions::make([
                    Action::make('create_new_client')
                        ->label('Create New Client')
                        ->icon('heroicon-o-user-plus')
                        ->color('primary')
                        ->modalHeading('Create New Client')
                        ->form(ClientForm::makeClientForOrderPage())
                        ->action(function (array $data, callable $set) {
                            $user = User::create([
                                'name' => $data['name'],
                                'last_name' => $data['last_name'],
                                'email' => $data['email'],
                                'phone' => $data['phone'],
                                'password' => bcrypt($data['password']),
                            ]);

                            $user->assignRole('client');

                            // Automatically select the newly created user
                            $set('user_id', $user->id);
                        }),
                ])
                ->columnSpan(2)
            ])
            ;
    }
}
