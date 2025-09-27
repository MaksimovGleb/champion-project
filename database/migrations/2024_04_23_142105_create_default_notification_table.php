<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('default_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('notification_type'); // имя класса уведомления
            $table->text('type_text')->nullable();
            $table->boolean('send_sms')->default(false);
            $table->boolean('edit_sms')->default(false);
            $table->text('sms_text')->nullable();
            $table->boolean('send_email')->default(false);
            $table->boolean('edit_email')->default(false);
            $table->text('email_header')->nullable();
            $table->text('email_text')->nullable();
            $table->string('reader');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('default_notifications');
    }
};
