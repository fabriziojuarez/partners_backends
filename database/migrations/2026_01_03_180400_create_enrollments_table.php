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
        /* NO SE USARA COMO TABLA PIVOT YA QUE SE REQUIERE UN RANGO DE TIEMPO 
        EN EL MOMENTO DE SU CREACION */
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('partner_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unsignedTinyInteger('period_month');
            $table->unsignedSmallInteger('period_year');
            $table->timestamps();

            $table->unique(
                ['course_id', 'partner_id', 'period_month', 'period_year'], 
                'unique_course_partner_period');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
