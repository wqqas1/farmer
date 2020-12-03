<?php

namespace App\Models;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function income_tags()
    {
        return $this->hasMany(IncomeTag::class);
    }

    public function expense_tags()
    {
        return $this->hasMany(ExpenseTag::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
