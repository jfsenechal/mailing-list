<?php

declare(strict_types=1);

namespace App\Shares;

use App\Models\AddressBook;
use App\Models\AddressBookShare;

final class ShareHandler
{
    public static function syncSharing(AddressBook $record, ?array $state): void
    {
        $usernames = collect($state ?? []);

        AddressBookShare::query()
            ->where('address_book_id', $record->id)
            ->whereNotIn('username', $usernames)
            ->delete();

        $existing = AddressBookShare::query()
            ->where('address_book_id', $record->id)
            ->pluck('username');

        $usernames->diff($existing)->each(fn (string $username) => AddressBookShare::query()->create([
            'address_book_id' => $record->id,
            'username' => $username,
            'permission' => 'read',
        ]));
    }
}
