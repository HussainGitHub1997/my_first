<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'code',
        'note',
        'expire_duration',
        'model_type',
        'model_id',
        'started_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function model()
    {
        return $this->morphTo();
    }
}
