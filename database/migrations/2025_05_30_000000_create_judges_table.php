<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('judges', function (Blueprint $table) {
            $table->id();
            $table->string('position');         // Должность
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->string('country');          // Страна
            $table->string('city');             // Город
            $table->string('category');         // Категория
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('judges');
    }
};
