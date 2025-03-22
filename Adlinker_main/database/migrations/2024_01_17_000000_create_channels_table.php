<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('publisher_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('link')->nullable();
            $table->text('description');
            $table->string('logo_path')->nullable();
            $table->integer('subscribers_count')->default(0);
            $table->decimal('price_1_day', 8, 2)->nullable();
            $table->decimal('price_2_days', 8, 2)->nullable();
            $table->decimal('price_3_days', 8, 2)->nullable();
            $table->decimal('price_7_days', 8, 2)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('channels');
    }
};