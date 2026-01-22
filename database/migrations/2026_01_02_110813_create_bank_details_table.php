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
        Schema::create('bank_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bank_id')->nullable();

            $table->text('user_name_at_bank')->nullable();
            $table->string('account_number', 100)->nullable();
            $table->text('branch')->nullable();
            $table->string('ifscode', 100)->nullable();
            $table->text('cancelled_cheque')->nullable();
            $table->string('upi_id', 191)->nullable();

            $table->enum('status', ['Pending','Verified','Submitted','Reject'])
                  ->default('Pending');

            $table->text('admin_reply')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('bank_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_details');
    }
};
