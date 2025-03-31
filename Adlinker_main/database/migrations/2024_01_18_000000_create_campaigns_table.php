<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publisher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('advertiser_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('channel_id')->constrained()->onDelete('cascade');
            $table->string('channel_name');
            $table->integer('subscribers');
            $table->string('channel_link');
            $table->integer('duration');
            $table->decimal('price', 10, 2);
            $table->string('advertisement_image');
            $table->text('advertisement_content');
            $table->enum('status', ['pending', 'active', 'completed', 'rejected']);
            $table->timestamp('submission_timestamp')->nullable();
            $table->timestamp('post_submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
};