<?php

namespace App\Models;

use App\Models\StudentClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignSubject extends Model
{
    //use HasFactory;

    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'class_id', 'id');
    }

    public function school_subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
