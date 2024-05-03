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

            $table->string('main_title');
            $table->integer('article_length')->nullable();
            $table->string('category')->nullable();

            $table->text('full_content')->nullable();
            $table->text('url');

            $table->boolean('is_processed')->default(false);

            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('author_id')->nullable()->constrained('entities');
            $table->foreignId('organization_id')->constrained('organizations');

            $table->timestamp('created_at')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
