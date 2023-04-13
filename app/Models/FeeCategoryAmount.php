<?php

namespace App\Models;

use App\Models\FeeCategory;
use App\Models\StudentClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeCategoryAmount extends Model
{
    //use HasFactory;
    public function fee_category()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id', 'id');
    }

    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'class_id', 'id');
    }


    //relationship between the FeeCategoryAmount model and the FeeCategory model
    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class);
    }
}
