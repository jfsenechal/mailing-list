<?php

declare(strict_types=1);

namespace App\Filament\Resources\Senders\Pages;

use App\Filament\Resources\Senders\SenderResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateSender extends CreateRecord
{
    #[Override]
    protected static string $resource = SenderResource::class;

    #[Override]
    protected static ?string $title = 'Nouvel expéditeur';
}
