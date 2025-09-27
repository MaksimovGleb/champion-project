<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('default_notifications', function (Blueprint $table) {
            $table->string('type_name')->nullable()->after('notification_type');
        });
    }

    public function down(): void
    {
        Schema::table('default_notifications', function (Blueprint $table) {
            $table->dropColumn('type_name');
        });
    }
};
