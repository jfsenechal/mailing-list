<?php

declare(strict_types=1);

namespace App\Filament\Resources\Senders\Pages;

use App\Filament\Resources\Senders\SenderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Override;

final class EditSender extends EditRecord
{
    #[Override]
    protected static string $resource = SenderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Supprimer')
                ->icon(Heroicon::Trash),
        ];
    }
}
