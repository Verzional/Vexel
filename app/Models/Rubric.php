<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    protected $fillable = ['title', 'content'];
    
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
