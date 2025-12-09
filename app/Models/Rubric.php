<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    protected $fillable = ['title'];

    protected $casts = [
        'criteria' => 'array',
    ];
    
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
