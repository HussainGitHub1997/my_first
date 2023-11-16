<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    
    protected $fillable = ['subject_id','name','description','is_subscribed','expries_at','is_free']    ;
    public function subject()
    {
        return $this->hasOne(Subject::class);
    }
}
