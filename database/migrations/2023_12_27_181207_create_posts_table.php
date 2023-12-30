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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_description');
            $table->text('long_description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->enum('status', ['draft', 'published','pending ','review'])->nullable();
            $table->text('tags')->nullable();
            $table->string('views_count')->nullable();
            $table->string('likes_count')->nullable();
            $table->string('comments_count')->nullable();
            $table->boolean('is_featured')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
