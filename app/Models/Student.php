<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class, 'student_id', 'id');
    }
}
