<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SenderFactory;
use App\Repositories\OwnerScope;
use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UseFactory(SenderFactory::class)]
#[ScopedBy(OwnerScope::class)]

#[Fillable([
    'username',
    'name',
    'email',
    'footer',
    'logo',
])]
final class Sender extends Model
{
    /** @use HasFactory<SenderFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
