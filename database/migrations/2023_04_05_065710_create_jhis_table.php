<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('jhis', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('institution_name');
        //     $table->string('institution_email');
        //     $table->string('password');
        //     $table->timestamps();
        // });

        Schema::create('jhis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('issues_per_year');
            $table->integer('publications_per_year');
            $table->string('location');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jhis');
    }
};
