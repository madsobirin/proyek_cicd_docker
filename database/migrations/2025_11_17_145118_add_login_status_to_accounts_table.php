<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {

            // kalau kolom belum ada → tambahkan
            if (!Schema::hasColumn('accounts', 'is_active')) {
                $table->boolean('is_active')->default(false)->after('password');
            }

            if (!Schema::hasColumn('accounts', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            if (Schema::hasColumn('accounts', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('accounts', 'last_login_at')) {
                $table->dropColumn('last_login_at');
            }
        });
    }
};
