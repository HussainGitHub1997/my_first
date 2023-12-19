<?php

namespace App\Models;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['subject_id',
    'name',
    'description' 
    ];

    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }
    public function record()
    {
        return $this->hasMany(Record::class);
    }

}
