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
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->comment('employee_id=user_id');
            $table->integer('leave_type_id');
            $table->integer('leave_purpose_id');
            $table->string('attachment');
            $table->string('leave_status');
            $table->string('remarks');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('number_of_days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_leaves');
    }
};