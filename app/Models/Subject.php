<?php

namespace App\Models;

use App\Models\Record;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = ['unit_id',
    'name',
    'description'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function section()
    {
        return $this->hasMany(Section::class);
    }
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
