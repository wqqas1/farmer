<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper;

class Goal extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'goals';

    protected $dates = [
        'starts_on',
        'ends_on',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'period',
        'amount',
        'type',
        'income_tag_id',
        'expense_tag_id',
        'starts_on',
        'ends_on',
    ];
    public function income_tag()
    {
        return $this->belongsTo(IncomeTag::class);
    }

    public function expense_tag()
    {
        return $this->belongsTo(ExpenseTag::class);
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        return Helper::formatNumber($this->amount / 100);
    }

    public function getSpentAttribute()
    {
        return $this->getSpentById($this->id);
    }

    public function getFormattedSpentAttribute()
    {
        return Helper::formatNumber($this->spent / 100);
    }

    public static function getSupportedPeriods(): array
    {
        return [
            'yearly' => 'yearly',
            'monthly' => 'monthly',
            'weekly' => 'weekly',
            'daily' => 'daily'
        ];
    }

    public static function types(): array{
        return [
            'income' => 'Income',
            'expense' => 'Expense',
        ];
    }

    public static function rules(): array
    {
        return [
            'name'  => 'required|unique:goals',
            'income_tag_id' => 'required|exists:income_tags,id',
            'expense_tag_id' => 'required|exists:expense_tags,id',
            'period' => 'required|in:' . implode(',', self::getSupportedPeriods()),
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/',
            'type'  => 'required',
            'starts_on'  => 'required|date',
            'ends_on'  => 'required|date'
        ];
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
