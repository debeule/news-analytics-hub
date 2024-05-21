<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentions', function (Blueprint $table): void {
            $table->id();

            $table->text('context');

            $table->integer('sentiment');
            $table->timestamp('mention_created_at');

            $table->foreignId('entity_id')->nullable()->constrained('entities');
            $table->foreignId('organization_id')->nullable()->constrained('organizations');
            $table->foreignId('article_id')->constrained('articles');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
