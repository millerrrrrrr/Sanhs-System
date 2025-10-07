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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('lrn');
            $table->foreign('lrn')
                  ->references('lrn')
                  ->on('students')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->date('date')->index();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
