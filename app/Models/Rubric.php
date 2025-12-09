<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    protected $fillable = ['subject_name', 'criteria'];

    protected $casts = [
        'criteria' => 'array',
    ];
    
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
