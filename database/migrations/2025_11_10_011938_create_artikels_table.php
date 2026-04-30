<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();     
            $table->string('kategori')->nullable(); 
            $table->string('penulis')->default('Admin');
            $table->text('isi');
            $table->string('gambar')->nullable();  
            $table->boolean('is_featured')->default(false); 
            $table->integer('dibaca')->default(0); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
