<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\StudySpecializationEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Answer extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    public $fillable = [
        'overall_rating',
        'teacher_approach_rating',
        'expectation_fulfillment_rating',
        'specialization'
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'specialization' => StudySpecializationEnum::class,
        'created_at' => 'datetime',
    ];

}
