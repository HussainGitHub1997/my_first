<?php

namespace App\Models;

use App\Models\Model_id;
use App\Models\Model_type;
use App\Models\Term;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','code','note','expiry','model_type','model_id' ] ;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function term()
    {
        return $this->hasOne(Term::class);

    }
    public function units()
    {
        return $this->hasOne(Unit::class);
    }
   
   
}
