<?php

namespace App\Models;

use App\Enums\QuestionTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'assessment_id',
        'question',
        'type',
        'marks'
    ];

    protected $casts = [
        'type' => QuestionTypeEnum::class
    ];

    public function assessment(): Relation
    {
        return $this->belongsTo(Assessment::class);
    }
}
