<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Filament\Imports\ContactImporter;
use Filament\Actions\ImportAction;
use Filament\Support\Icons\Heroicon;

final class ImportContactAction
{
    public static function make(): ImportAction
    {
        return
            ImportAction::make()
                ->importer(ContactImporter::class)
                ->label('Importer des contacts')
                ->modalDescription('Le séparateur de champ est la virgule (",").')
                ->icon(Heroicon::ArrowUpTray)
                ->csvDelimiter(',');
    }
}
