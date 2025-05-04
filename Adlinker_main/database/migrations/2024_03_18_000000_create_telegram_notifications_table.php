<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('telegram_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('chat_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'chat_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('telegram_notifications');
    }
};