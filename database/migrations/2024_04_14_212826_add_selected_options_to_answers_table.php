<?php

use App\Models\Option;
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
        // Drop option_id column
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('option_id');
        });

        // Add selected_options column
        Schema::table('answers', function (Blueprint $table) {
            $table->json('selected_options')->after('id')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->foreignIdFor(Option::class)->after('id')->onDelete('cascade');
            $table->dropColumn('selected_options');
        });
    }
};
