<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['submission_id', 'grade', 'breakdown', 'reasoning', 'feedback', 'notable_points', 'is_verified'];

    protected $casts = [
        'breakdown' => 'array',
        'is_verified' => 'boolean',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
