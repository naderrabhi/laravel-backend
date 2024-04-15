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
        Schema::create('technician_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_technician');
            $table->unsignedBigInteger('id_peripheral');
            $table->boolean('confirmed');
            $table->boolean('fixed');
            $table->string('confirmed_at');
            $table->string('fixed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('technician_assignments');
    }
};
