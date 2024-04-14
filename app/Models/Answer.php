<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'option_id',
        'user_id',
    ];

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function option(): Relation
    {
        return $this->belongsTo(Option::class);
    }
}
