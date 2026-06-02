<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\RecipientStatus;
use App\Mail\NewsletterMail;
use App\Models\Email;
use App\Models\EmailRecipient;
use App\Models\Sender;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class SendEmailJob implements ShouldQueue
{
    use Batchable, Queueable;

    public function __construct(
        public Email $email,
        public EmailRecipient $recipient,
    ) {}

    public function handle(): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        try {
            $this->resolveMailer()
                ->to($this->recipient->email_address)
                ->send(new NewsletterMail($this->email, $this->recipient));

            $this->recipient->update([
                'status' => RecipientStatus::Sent,
                'sent_at' => now(),
            ]);

            $this->email->increment('sent_count');
        } catch (Throwable $e) {
            $this->recipient->update([
                'status' => RecipientStatus::Failed,
                'error' => mb_substr($e->getMessage(), 0, 500),
            ]);

            throw $e;
        }
    }

    private function resolveMailer(): Mailer
    {
        $sender = $this->email->sender ?? $this->email->load('sender')->sender;

        if ($sender instanceof Sender && $sender->hasSmtpSettings()) {
            $mailerName = 'sender_'.$sender->id;

            config([
                "mail.mailers.{$mailerName}" => [
                    'transport' => 'smtp',
                    'host' => $sender->smtp_host,
                    'port' => $sender->smtp_port ?? 587,
                    'username' => $sender->smtp_username,
                    'password' => $sender->smtp_password,
                    'encryption' => 'tls',
                ],
            ]);

            return Mail::mailer($mailerName);
        }

        return Mail::mailer(config('mail.default'));
    }
}
