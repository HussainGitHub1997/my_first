<?php

namespace App\Models;


use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;


class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
    
    public function subject()
    {
        return $this->hasMany(Subject::class);
    }
    public function subscription(): MorphOne
    {
        return $this->morphOne(Subscription::class, 'model');
    }
}
