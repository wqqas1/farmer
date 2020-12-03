<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeTag extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'color'];

    // Relations
    public function incomes()
    {
        return $this->hasMany(Income::class);
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
    //rules
    public static function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'color' => 'required|max:7'
        ];
    }

    public function setColorAttribute($color){
        $this->attributes['color'] = str_replace('#','',$color);
    }

    public function getColorAttribute($color){
        return '#' . $color;
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
