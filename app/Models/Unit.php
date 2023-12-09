<?php

namespace App\Models;

use App\Models\Model_id;
use App\Models\Model_type;
use App\Models\Subscription;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['name', 
    'description'
    ];     
    
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
    public function subject()
    {
        return $this->hasMany(Subject::class);
    }
   
}
