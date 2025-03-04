<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class School extends Model
{

    /**
     * @var list<string>
     */
    public $attributes = [
        'name',
        'address',
        'city'
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
