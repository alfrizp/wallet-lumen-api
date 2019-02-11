<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date', 'amount', 'in_out', 'description',
        'category_id', 'user_id',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getTypeAttribute()
    {
        return $this->in_out ? 'income' : 'outcome';
    }

    public function getDateOnlyAttribute()
    {
        return substr($this->date, -2);
    }

    public function getMonthAttribute()
    {
        return Carbon::parse($this->date)->format('m');
    }

    public function getYearAttribute()
    {
        return Carbon::parse($this->date)->format('Y');
    }

    public function getAmountStringAttribute()
    {
        $amountString = number_format($this->amount, 2);

        if ($this->in_out == 0) {
            $amountString = '- '.$amountString;
        }

        return $amountString;
    }
}
