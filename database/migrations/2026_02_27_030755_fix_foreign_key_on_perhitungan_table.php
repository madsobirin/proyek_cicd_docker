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
        Schema::table('perhitungan', function (Blueprint $table) {
            // Hapus foreign key lama yang salah
            $table->dropForeign(['user_id']);

            // Buat foreign key baru yang merujuk ke tabel 'accounts'
            $table->foreign('user_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
