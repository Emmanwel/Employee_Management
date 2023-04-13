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
        Schema::create('c2_b_mpesa_requests', function (Blueprint $table) {
            $table->id();

            $table->string('TransactionType');

            $table->string('TransID');
            $table->string('TransTime');
            $table->decimal('TransAmount', 12, 2);
            $table->string('BusinessShortCode');
            $table->string('BillRefNumber');
            $table->string('InvoiceNumber')->nullable();
            $table->decimal('OrgAccountBalance', 12, 2)->nullable();
            $table->string('ThirdPartyTransID')->nullable();
            $table->string('MSISDN');
            $table->string('FirstName');
            $table->string('MiddleName')->nulable();
            $table->string('LastName')->nulable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c2_b_mpesa_requests');
    }
};
