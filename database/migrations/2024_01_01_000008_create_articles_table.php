<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table): void {
            $table->id();

            $table->string('title');
            $table->text('full_content');
            $table->text('url');

            $table->string('category');
            $table->integer('word_count');
            $table->timestamp('article_created_at')->nullable();

            $table->foreignId('author_id')->constrained('entities');
            $table->foreignId('organization_id')->constrained('organizations');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
