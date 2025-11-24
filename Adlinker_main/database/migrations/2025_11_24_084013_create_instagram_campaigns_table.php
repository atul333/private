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
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('media_file');
            $table->text('caption')->nullable();
            $table->boolean('mention_required')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
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
