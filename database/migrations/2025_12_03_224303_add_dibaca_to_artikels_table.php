<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            if (!Schema::hasColumn('artikels', 'dibaca')) {
                $table->unsignedInteger('dibaca')->default(0)->after('is_featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            if (Schema::hasColumn('artikels', 'dibaca')) {
                $table->dropColumn('dibaca');
            }
        });
    }
};
