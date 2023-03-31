<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\StudentYear;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use App\Models\DiscountStudent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\RegisterStudent as Authenticatable;


class RegisterStudent extends Model

{
    //use HasFactory;
    use Notifiable;

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
    public function discount()
    {
        return $this->belongsTo(DiscountStudent::class, 'id', 'register_student_id');
    }
    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'class_id', 'id');
    }
    public function student_year()
    {
        return $this->belongsTo(StudentYear::class, 'year_id', 'id');
    }
    public function group()
    {
        return $this->belongsTo(StudentGroup::class, 'group_id', 'id');
    }
    public function shift()
    {
        return $this->belongsTo(StudentShift::class, 'shift_id', 'id');
    }


}
