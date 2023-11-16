<?php

namespace App\Models;

use App\Models\Model_id;
use App\Models\Model_type;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    protected $fillable = ['unit_id','name','description'] ;

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
    public function unit()
    {
        return $this->hasOne(Unit::class);
    }
    public function subject()
    {
        return $this->hasMany(Subject::class);
    }
 
   
}
