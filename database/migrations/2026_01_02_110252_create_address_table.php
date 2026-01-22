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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['Home', 'Office', 'Other'])->default('Home');
            $table->text('address')->nullable();
            $table->string('street', 200)->nullable();

            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();

            $table->string('zip', 50)->nullable();

            // `default` is a reserved keyword, so we rename it safely
            $table->enum('is_default', ['Yes', 'No'])->default('No');
            $table->string('longitude', 200)->nullable();
            $table->string('latitude', 200)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Optional indexes
            $table->index('user_id');
            $table->index('city_id');
            $table->index('state_id');
            $table->index('country_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
