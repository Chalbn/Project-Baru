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
        Schema::table('consultation_messages', function (Blueprint $table) {
            $table->foreignId('counseling_program_id')->nullable()->constrained()->onDelete('cascade')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation_messages', function (Blueprint $table) {
            $table->dropForeign(['counseling_program_id']);
            $table->dropColumn('counseling_program_id');
        });
    }
};
