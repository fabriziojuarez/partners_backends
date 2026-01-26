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
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('manager_id')->nullable()->after('is_active');
            $table->foreign('manager_id')
                ->references('id')->on('partners')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->text('description')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn('manager_id');
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
