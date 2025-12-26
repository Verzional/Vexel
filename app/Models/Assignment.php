<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['course_id', 'title', 'description'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function rubric()
    {
        return $this->hasOne(Rubric::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
