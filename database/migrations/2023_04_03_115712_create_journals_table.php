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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('jhi_id');
            $table->string('contributers');
            $table->string("journal_file")->nullable();
            $table->string("status");
            $table->string("journal_id")->nullable();
            $table->timestamps();
            $table->foreign('journal_id')->references('id')->on('departments')->onDelete("cascade");
            $table->foreign('jhi_id')->references('id')->on('jhis')->onDelete('cascade');
            


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
