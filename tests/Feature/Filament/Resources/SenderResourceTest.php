<?php

declare(strict_types=1);

use App\Filament\Resources\Senders\Pages\ViewSender;
use App\Models\Sender;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function Pest\Livewire\livewire;

it('can render the view page', function () {
    $sender = Sender::factory()->create([
        'username' => auth()->user()->username,
    ]);

    livewire(ViewSender::class, [
        'record' => $sender->id,
    ])
        ->assertOk()
        ->assertSee($sender->name)
        ->assertSee($sender->email);
});

it('hides senders owned by another user from the view page', function () {
    $sender = Sender::factory()->create([
        'username' => User::factory()->create()->username,
    ]);

    livewire(ViewSender::class, [
        'record' => $sender->id,
    ]);
})->throws(ModelNotFoundException::class);
