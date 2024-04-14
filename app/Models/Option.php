<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'question_id',
        'content',
        'isAnswer',
    ];

    public function question(): Relation
    {
        return $this->belongsTo(Question::class);
    }

    public function answers(): Relation
    {
        return $this->hasMany(Answer::class);
    }
}
