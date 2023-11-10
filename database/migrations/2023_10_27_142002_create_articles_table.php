<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->text('full_content');
            $table->boolean('is_processed');

            $table->string('main_title');
            $table->string('article_length');
            $table->string('category');

            $table->unsignedBigInteger('entity_id');
            $table->foreign('entity_id')->references('id')->on('entities');

            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
