<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'section_id',
    'name',
    'description',
    'is_subscribed',
    'expired_at',
    'is_free',
    'path'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
