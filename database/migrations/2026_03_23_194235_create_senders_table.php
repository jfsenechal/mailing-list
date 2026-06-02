<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('senders')) {
            return;
        }
        Schema::dropIfExists('senders');
        Schema::create('senders', function (Blueprint $table): void {
            $table->id();
            $table->string('username')->index();
            $table->string('name');
            $table->string('email');
            $table->text('footer')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }
};
