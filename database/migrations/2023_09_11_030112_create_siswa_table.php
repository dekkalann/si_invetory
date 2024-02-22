<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->smallIncrements('id'); 
            $table->string('nama', 40)->nullable(); 
            $table->string('nis', 5)->nullable(); 
            $table->enum('gender',['M','F'])->default('M'); 
            $table->enum('kelas',['X','XI','XII'])->default('X'); 
            $table->enum('rombel',['A','B'])->default('A'); 
            $table->string('foto')->nullable(); 
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};