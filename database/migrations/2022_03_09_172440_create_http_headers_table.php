<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHttpHeadersTable extends Migration
{
    public function up(): void
    {
        Schema::create('http_headers', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 20)->nullabe();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('headers')->nullabe();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('http_headers');
    }
}
