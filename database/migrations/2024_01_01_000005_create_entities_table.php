<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entities', function (Blueprint $table): void {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');

            $table->timestamp('created_at')->useCurrent();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
