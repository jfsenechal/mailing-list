<?php

declare(strict_types=1);

use App\Filament\Resources\Emails\Pages\ViewEmail;
use App\Mail\NewsletterMail;
use App\Models\Email;
use App\Models\EmailRecipient;
use App\Models\Sender;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Mail;

use function Pest\Livewire\livewire;

it('sends a preview email to the given address', function (): void {
    Mail::fake();

    $sender = Sender::factory()->create(['username' => auth()->user()->username]);
    $email = Email::factory()->create([
        'username' => auth()->user()->username,
        'sender_id' => $sender->id,
    ]);

    livewire(ViewEmail::class, ['record' => $email->id])
        ->callAction(TestAction::make('preview'), [
            'email' => 'preview@example.com',
        ])
        ->assertHasNoActionErrors()
        ->assertNotified();

    Mail::assertSent(NewsletterMail::class, function (NewsletterMail $mail): bool {
        return $mail->hasTo('preview@example.com')
            && $mail->recipient->name === 'Apercu'
            && ! $mail->recipient->exists;
    });
});

it('renders the preview without an unsubscribe link for a transient recipient', function (): void {
    $sender = Sender::factory()->create(['username' => auth()->user()->username]);
    $email = Email::factory()->create([
        'username' => auth()->user()->username,
        'sender_id' => $sender->id,
        'unsubscribe_enabled' => true,
    ]);
    $email->load('sender');

    $recipient = new EmailRecipient([
        'email_address' => 'preview@example.com',
        'name' => 'Apercu',
    ]);

    $mailable = new NewsletterMail($email, $recipient);

    expect($mailable->content()->with['unsubscribeUrl'])->toBeNull();
    expect($mailable->headers()->text)->toBe([]);
});
