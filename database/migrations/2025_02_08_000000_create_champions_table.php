<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('champions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->string('coach');
            $table->integer('category');
            $table->decimal('weight', 8, 2); // Два знака после запятой
            $table->date('birth_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('champions');
    }
};
