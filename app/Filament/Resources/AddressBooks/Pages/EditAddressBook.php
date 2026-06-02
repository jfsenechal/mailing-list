<?php

declare(strict_types=1);

namespace App\Filament\Resources\AddressBooks\Pages;

use App\Filament\Resources\AddressBooks\AddressBookResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Override;

final class EditAddressBook extends EditRecord
{
    #[Override]
    protected static string $resource = AddressBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Voir')
                ->icon(Heroicon::Eye),
        ];
    }
}
