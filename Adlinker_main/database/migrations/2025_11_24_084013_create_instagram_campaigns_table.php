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
        Schema::create('instagram_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertiser_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('publisher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instagram_profile_id')->constrained('instagram_profiles')->onDelete('cascade');
            
            // Media fields
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('media_file');
            
            // Link fields (replaced caption)
            $table->string('link_text')->nullable();
            $table->string('link_url', 500)->nullable();
            
            // Story link and timestamps
            $table->string('story_link')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            // Status with all possible values including 'published'
            $table->enum('status', ['pending', 'approved', 'rejected', 'published', 'completed'])->default('pending');
            
            // Payment
            $table->decimal('price', 10, 2);
            $table->boolean('paid')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_campaigns');
    }
};
