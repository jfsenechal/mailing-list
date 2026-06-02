<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AddressBook;
use App\Models\AddressBookShare;

final class AddressBookRepository
{
    public static function getSharingAddressBookByAddressBook(AddressBook $record)
    {
        return AddressBookShare::query()
            ->where('address_book_id', $record->id)
            ->pluck('username')
            ->all();
    }
}
