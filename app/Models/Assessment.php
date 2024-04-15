<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\Relation;


class Assessment extends Model
{
    use HasFactory, HasUuids, SoftDeletes, \Staudenmeir\EloquentHasManyDeep\HasRelationships;

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
        return $this->hasMany(Answer::class);
    }

    public function usersAnswers()
    {
        return $this->answers()->whereUserId(auth()->user()->id)->get();
    }
}
