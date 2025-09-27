<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserRefIdColumnToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('user_ref_id')
                ->nullable()
                ->after('id')
                ->comment('кто пригласил')
                ->constrained('users');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_user_ref_id_foreign');
            $table->dropColumn('user_ref_id');
        });
    }
}
