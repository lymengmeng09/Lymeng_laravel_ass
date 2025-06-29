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
        $table->id();
        $table->string('title');
        $table->foreignId('authorId')->constrained('authors')->onDelete('cascade');
        $table->year('publicationYear');
        $table->string('isbn')->nullable();
        $table->string('genre')->nullable();
        $table->integer('availableCopies')->default(0);
        $table->timestamps();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};