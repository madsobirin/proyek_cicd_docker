<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            if (!Schema::hasColumn('artikels', 'penulis')) {
                $table->string('penulis')->nullable()->after('gambar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            if (Schema::hasColumn('artikels', 'penulis')) {
                $table->dropColumn('penulis');
            }
        });
    }
};
