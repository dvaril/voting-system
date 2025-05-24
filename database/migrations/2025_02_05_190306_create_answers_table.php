<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\School;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('access_token');
            $table->string('specialization', 255);
            $table->unsignedTinyInteger('overall_rating')->nullable()->default(null);
            $table->unsignedTinyInteger('teacher_approach_rating')->nullable()->default(null);
            $table->unsignedTinyInteger('expectation_fulfillment_rating')->nullable()->default(null);
            $table->dateTime('answered_at')->nullable()->default(null);
            $table->foreignIdFor(School::class)->nullable()->default(null)->constrained('schools');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
