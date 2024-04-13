<?php

use App\Models\User;
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
        Schema::create('assessments', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->string('title')->nullable(false);
            $table->longText('instructions')->nullable(false);
            $table->string('date')->nullable(false);
            $table->string('duration')->nullable(false);
            $table->integer('expected_score')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
