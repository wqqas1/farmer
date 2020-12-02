<?php

namespace App\Models;

use App\Support\HasAdvancedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;
use App\Helper;

class budget extends Model
{
    use HasAdvancedFilter, HasFactory;

    public $table = 'budgets';

    protected $dates = [
        'starts_on',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'expense_tag_id',
        'period',
        'amount',
        'type',
        'starts_on',
        'created_at',
        'updated_at',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'    => 'integer',
        'name'  => 'string',
        'amount' => 'double',
        'starts_on' => 'date',
    ];

    public $filterable = [
            'name'
        ];
    public function tag()
    {
        if($this->type == 'expense')
            return $this->belongsTo(ExpenseTag::class);
        elseif($this->type == 'income')
            return $this->belongsTo(IncomeTag::class);
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
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getSupportedPeriods(): array
    {
        return [
            'yearly',
            'monthly',
            'weekly',
            'daily'
        ];
    }

    public function getRulesAttribute(): array
    {
        return [
            'name'  => 'required|unique:budgets',
            'tag_id' => 'required|exists:tags,id',
            'period' => 'required|in:' . implode(',', $this->getSupportedPeriods()),
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/',
            'type'  => 'required',
            'starts_on'  => 'required|date'
        ];
    }

    public function getActive()
    {
        $today = date('Y-m-d');

        return Budget::whereRaw('starts_on <= ?', [$today])
            ->whereRaw('(ends_on >= ? OR ends_on IS NULL)', [$today])
            ->get();
    }

    public function getById(int $id): ?Budget
    {
        return Budget::find($id);
    }

    public function getSpentById(int $id): int
    {
        $budget = $this->getById($id);

        if (!$budget) {
            throw new Exception('Could not find budget (where ID is ' . $id . ')');
        }

        if ($budget->period === 'yearly') {
            return Expense::where('tag_id', $budget->tag->id)
                ->whereRaw('YEAR(happened_on) = ?', [date('Y')])
                ->sum('amount');
        }

        if ($budget->period === 'monthly') {
            return Expense::where('tag_id', $budget->tag->id)
                ->whereRaw('MONTH(happened_on) = ?', [date('n')])
                ->whereRaw('YEAR(happened_on) = ?', [date('Y')])
                ->sum('amount');
        }

        if ($budget->period === 'weekly') {
            return Expense::where('tag_id', $budget->tag->id)
                ->whereRaw('WEEK(happened_on) = WEEK(NOW())')
                ->sum('amount');
        }

        if ($budget->period === 'daily') {
            return Expense::where('tag_id', $budget->tag->id)
                ->whereRaw('happened_on = ?', [date('Y-m-d')])
                ->sum('amount');
        }

        throw new Exception('No clue what to do with period "' . $budget->period . '"');
    }
}
