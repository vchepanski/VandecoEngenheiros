<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'description', 'value', 'date','income_category_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incomeCategory()  {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }
}
