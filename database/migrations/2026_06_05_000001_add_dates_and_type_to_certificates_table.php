<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('completion_date');
            $table->date('end_date')->nullable()->after('start_date');
            $table->string('course_type')->nullable()->after('end_date'); // Physical or Online
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date', 'course_type']);
        });
    }
};
