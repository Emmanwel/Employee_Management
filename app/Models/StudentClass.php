<?php

namespace App\Models;

use App\Models\FeeCategoryAmount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentClass extends Model
{
    use HasFactory;

    //relationship between the Grade model and the FeeCategoryAmount model.

    public function feeCategoryAmounts()
    {
        return $this->hasMany(FeeCategoryAmount::class);
    }
}
