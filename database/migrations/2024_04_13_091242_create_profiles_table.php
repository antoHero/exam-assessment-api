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
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignIdFor(User::class)->onDelete('cascade');
            $table->string('phone')->nullable(false);
            $table->string('dob')->nullable(false);
            $table->string('state')->nullable(false);
            $table->string('gender')->nullable(false);
            $table->string('type')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
