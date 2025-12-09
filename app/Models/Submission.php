<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['assignment_id', 'student_name', 'file_path', 'extracted_text'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function result()
    {
        return $this->hasOne(Result::class);
    }
}
