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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('user_type', ['Admin', 'Employee', 'User']);
            $table->enum('type', ['Insert', 'Update', 'Delete', 'Restore']);
            $table->string('route_name');
            $table->string('title');
            $table->text('message');
            $table->enum('notification_show', ['Yes', 'No'])->default('No');
            $table->json('old_data')->nullable();
            $table->json('form_data')->nullable();
            $table->integer('reference_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};


