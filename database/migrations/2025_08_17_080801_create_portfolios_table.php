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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('images')->nullable(); // untuk multiple images
            $table->string('client_name')->nullable();
            $table->string('project_url')->nullable();
            $table->string('github_url')->nullable();
            $table->json('technologies')->nullable(); // array of technologies used
            $table->date('project_date')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('order')->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();

            // indexes
            $table->index(['title', 'slug', 'status', 'user_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
