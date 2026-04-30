<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('accounts', 'phone')) {
                $table->string('phone')->nullable();
            }

            if (!Schema::hasColumn('accounts', 'birthdate')) {
                $table->date('birthdate')->nullable();
            }

            if (!Schema::hasColumn('accounts', 'weight')) {
                $table->integer('weight')->nullable();
            }

            if (!Schema::hasColumn('accounts', 'height')) {
                $table->integer('height')->nullable();
            }

            if (Schema::hasColumn('accounts', 'photo')) {
                $table->string('photo')->nullable()->change();
            } else {
                $table->string('photo')->nullable();
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            foreach (['phone', 'birthdate', 'weight', 'height', 'photo'] as $column) {
                if (Schema::hasColumn('accounts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
