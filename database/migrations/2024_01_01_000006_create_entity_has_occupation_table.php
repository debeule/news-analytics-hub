<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entity_has_occupations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('entity_id')->constrained('entities');
            $table->foreignId('occupation_id')->constrained('occupations');
            
            $table->timestamp('created_at')->useCurrent();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('entity_has_occupation');
    }
};
