<?php

namespace App\Models;

use App\Enums\ProfileTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\Relation;

class Profile extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'phone',
        'dob',
        'state',
        'lga',
        'gender',
        'type'
    ];

    protected $casts = [
        'type' => ProfileTypeEnum::class
    ];

    public function user(): Relation
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
