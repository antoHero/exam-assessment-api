<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\Relation;


class Assessment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'instructions',
        'date',
        'duration',
        'expected_score'
    ];

    public function user(): Relation
    {
        return $this->belongsToMany(User::class);
    }

    public function questions(): Relation
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasManyDeepFromRelations($this->options, (new Option())->answers());
    }

    public function options()
    {
        return $this->hasManyThrough(Options::class, Question::class);
    }
}
