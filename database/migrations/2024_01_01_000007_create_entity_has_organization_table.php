<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entity_has_organizations', function (Blueprint $table): void {
            $table->id();
            
            $table->foreignId('organization_id')->constrained('organizations');
            $table->foreignId('author_id')->constrained('entities');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_has_organization');
    }
};
