<?php

namespace App\Models;

use App\Models\Record;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = ['term_id','name','description'];

    public function term()
    {
        return $this->hasOne(Term::class);
    }
    public function record()
    {
        return $this->hasMany(Record::class);
    }
}
