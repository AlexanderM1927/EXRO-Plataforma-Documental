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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->string('subject')->nullable();
            $table->string('recipient')->nullable();
            $table->integer('custom_id');
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
