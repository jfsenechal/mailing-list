<?php

namespace App\Providers;

use Filament\Forms\Components\RichEditor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! app()->environment('production') && config('mailing-list.mail.redirect_to')) {
            Mail::alwaysTo(config('mailing-list.mail.redirect_to'));
        }
        $this->configureRichEditor();
    }

    private function configureRichEditor(): void
    {
        RichEditor::configureUsing(function (RichEditor $richEditor): void {
            $richEditor->toolbarButtons([
                ['bold', 'italic', 'strike', 'textColor', 'link', 'h2', 'h3'],
                ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'],
                ['bulletList', 'orderedList', 'blockquote', 'horizontalRule'],
                ['table', 'grid', 'attachFiles'],
                ['clearFormatting', 'undo', 'redo'],
            ]);
        });
    }
}
