<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_articles', function (Blueprint $table) {
            $table->id();

            $table->string('main_title');
            $table->string('category')->nullable();
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
