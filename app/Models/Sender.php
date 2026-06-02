<?php

declare(strict_types=1);

namespace App\Models;

use App\Repositories\OwnerScope;
use Database\Factories\SenderFactory;
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
    'smtp_host',
    'smtp_port',
    'smtp_username',
    'smtp_password',
])]
final class Sender extends Model
{
    /** @use HasFactory<SenderFactory> */
    use HasFactory;

    public function hasSmtpSettings(): bool
    {
        return filled($this->smtp_host) && filled($this->smtp_username) && filled($this->smtp_password);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'smtp_password' => 'encrypted',
            'smtp_port' => 'integer',
        ];
    }
}
