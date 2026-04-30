<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            if (!Schema::hasColumn('menus', 'kalori')) {
                $table->integer('kalori')->nullable()->after('deskripsi');
            }

            if (!Schema::hasColumn('menus', 'waktu_memasak')) {
                $table->integer('waktu_memasak')->nullable()->after('kalori');
            }
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            foreach (['kalori', 'waktu_memasak'] as $column) {
                if (Schema::hasColumn('menus', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
