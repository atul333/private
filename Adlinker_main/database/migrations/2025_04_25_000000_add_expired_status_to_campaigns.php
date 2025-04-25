<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First, modify the column to be a string temporarily
        DB::statement('ALTER TABLE campaigns MODIFY COLUMN status VARCHAR(255)');
        
        // Then update any existing 'expired' statuses to 'completed' to avoid data issues
        DB::table('campaigns')->where('status', 'expired')->update(['status' => 'completed']);
        
        // Finally, add the ENUM constraint with the new value
        DB::statement("ALTER TABLE campaigns MODIFY COLUMN status ENUM('pending', 'active', 'completed', 'rejected', 'expired') NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        // First, modify the column to be a string temporarily
        DB::statement('ALTER TABLE campaigns MODIFY COLUMN status VARCHAR(255)');
        
        // Then update any 'expired' statuses to 'completed' before removing the enum value
        DB::table('campaigns')->where('status', 'expired')->update(['status' => 'completed']);
        
        // Finally, restore the original ENUM constraint
        DB::statement("ALTER TABLE campaigns MODIFY COLUMN status ENUM('pending', 'active', 'completed', 'rejected') NOT NULL DEFAULT 'pending'");
    }
}; 