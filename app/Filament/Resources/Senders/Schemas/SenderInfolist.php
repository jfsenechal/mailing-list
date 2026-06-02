<?php

declare(strict_types=1);

namespace App\Filament\Resources\Senders\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class SenderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make('Informations')
                        ->schema([
                            TextEntry::make('name')
                                ->label('Nom'),
                            TextEntry::make('email')
                                ->label('E-mail'),
                            TextEntry::make('footer')
                                ->label('Pied de page')
                                ->html()
                                ->prose()
                                ->placeholder('Aucun pied de page')
                                ->columnSpanFull(),
                        ])
                        ->grow(),
                    Section::make('Logo')
                        ->schema([
                            ImageEntry::make('logo')
                                ->label('Logo')
                                ->disk('public')
                                ->placeholder('Aucun logo')
                                ->hiddenLabel(),
                        ])
                        ->grow(false),
                ])->from('md')
                    ->columnSpanFull(),
                Flex::make([
                    TextEntry::make('created_at')
                        ->label('Créé le')
                        ->dateTime(),
                    TextEntry::make('updated_at')
                        ->label('Modifié le')
                        ->dateTime(),
                ])->columnSpanFull(),
            ]);
    }
}
