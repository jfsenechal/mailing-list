<?php

declare(strict_types=1);

namespace App\Filament\Resources\Senders\Pages;

use App\Filament\Resources\Senders\SenderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Override;

final class ListSenders extends ListRecords
{
    #[Override]
    protected static string $resource = SenderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nouvel expediteur')
                ->icon(Heroicon::Plus),
        ];
    }
}
