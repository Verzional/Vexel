<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['rubric_id', 'title'];

    public function rubric()
    {
        return $this->belongsTo(Rubric::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
