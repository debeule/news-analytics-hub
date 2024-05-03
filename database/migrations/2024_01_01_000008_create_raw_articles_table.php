<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_articles', function (Blueprint $table): void {
            $table->id();

            $table->string('main_title');
            $table->text('full_content')->nullable();
            $table->text('url');
            $table->string('category');
            $table->string('author');
            $table->string('organization');

            $table->timestamp('created_at')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
