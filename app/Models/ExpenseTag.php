<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseTag extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'color'];

    // Relations
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Custom
    private static function randomColorPart()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public static function randomColor()
    {
        return self::randomColorPart() . self::randomColorPart() . self::randomColorPart();
    }
}
