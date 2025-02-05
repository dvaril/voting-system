<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\StudySpecializationEnum;
use App\Models\FormInstance;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('overall_rating');
            $table->unsignedTinyInteger('teacher_approach_rating');
            $table->unsignedTinyInteger('expectation_fulfillment_rating');
            $table->enum('specialization', StudySpecializationEnum::getValues());
            // TODO: Add school attribute
            $table->foreignIdFor(FormInstance::class)->constrained('form_instances');
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
