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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // 'string', 'number', 'boolean', 'json'
            $table->string('group')->default('general'); // 'general', 'ai', 'email', 'security', etc.
            $table->string('label');
            $table->text('description')->nullable();
            $table->boolean('is_editable')->default(true);
            $table->boolean('is_sensitive')->default(false); // Hide value in UI
            $table->timestamps();
            
            $table->index('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};

