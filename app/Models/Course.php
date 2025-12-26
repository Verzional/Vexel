<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'year'];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
