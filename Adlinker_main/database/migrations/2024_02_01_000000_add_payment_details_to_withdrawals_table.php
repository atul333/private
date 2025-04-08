<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            // Remove the existing payment_details column
            $table->dropColumn('payment_details');
            
            // Add new columns for UPI payment details
            $table->string('first_name')->nullable();
            $table->string('upi_id')->nullable();
            $table->string('mobile_number')->nullable();
            
            // Add new columns for bank transfer details
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            // Recreate the original payment_details column
            $table->string('payment_details');
            
            // Drop the new columns
            $table->dropColumn([
                'first_name',
                'upi_id',
                'mobile_number',
                'account_holder_name',
                'account_number',
                'ifsc_code',
                'bank_name'
            ]);
        });
    }
};