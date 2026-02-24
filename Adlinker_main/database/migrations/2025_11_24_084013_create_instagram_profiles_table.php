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
        Schema::create('instagram_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('instagram_id')->unique();
            $table->string('profile_photo')->nullable();
            $table->integer('followers')->default(0);
            $table->decimal('price_per_story', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            
            // Status field for moderation (active, inactive, moderation)
            // New profiles default to 'moderation' requiring admin approval
            $table->enum('status', ['active', 'inactive', 'moderation'])->default('moderation');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_profiles');
    }
};
