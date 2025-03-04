<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\StudySpecializationEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

final class Answer extends Model
{
    use HasFactory,
        SoftDeletes;

    public const ACCESS_TOKEN_DURATION_MINUTES = 3600;

    /**
     * @var list<string>
     */
    public $fillable = [
        'overall_rating',
        'teacher_approach_rating',
        'expectation_fulfillment_rating',
        'specialization',
        'access_token',
        'school_id',
        'answered_at'
    ];

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'specialization' => StudySpecializationEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'answered_at' => 'datetime'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function refreshToken(): void
    {
        $this->update([
            'access_token' => Str::uuid()->toString(),
        ]);
    }

    public function isAnswered(): bool
    {
        return isset($this->answered_at);
    }

    public function isTokenValid(): bool
    {
        $tokenExpiresAt = $this->created_at->addMinutes(self::ACCESS_TOKEN_DURATION_MINUTES);

        return $tokenExpiresAt > now();
    }

    public static function boot(): void
    {
        parent::boot();

        self::creating(static function (self $record): void {
            $record->access_token = Str::uuid()->toString();
        });
    }
}
