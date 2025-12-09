<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['submission_id', 'grade', 'reasoning', 'feedback', 'notable_points', 'is_verified'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
