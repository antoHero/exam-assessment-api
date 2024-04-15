<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'selected_options',
        'user_id',
        'assessment_id',
        'question_id',
    ];

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function option(): Relation
    {
        return $this->belongsTo(Option::class);
    }

    public function selectedOptions(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value)
        );
    }
}
