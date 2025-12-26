<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubric extends Model
{
    protected $fillable = ['assignment_id', 'subject_name', 'criteria'];

    protected $casts = [
        'criteria' => 'array',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
