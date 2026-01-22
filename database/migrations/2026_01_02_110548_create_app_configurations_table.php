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
        Schema::create('app_configurations', function (Blueprint $table) {
            $table->id();
            $table->enum('for', ['Admin Panel','Website','Android','Both'])->default('Both');
            $table->string('title')->unique();
            $table->string('name')->unique();
            $table->string('value')->nullable();
            $table->enum('value_type', [
                'text','password','checkbox','date','email','file','range',
                'url','time','month','hidden','textarea','color','dropdown','number'
            ])->default('text');
            $table->json('json_data')->nullable();
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name', 'title']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_configurations');
    }
};
