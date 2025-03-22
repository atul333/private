<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['publisher', 'advertiser'])->after('email');
        });

        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('website_url')->nullable();
            $table->string('website_category')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('advertisers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('industry')->nullable();
            $table->text('company_description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('advertisers');
        Schema::dropIfExists('publishers');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}