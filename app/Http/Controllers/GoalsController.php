<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class GoalsController extends Controller
{
    public function index()
    {
        return Inertia::render('Goals/Index', [
            'filters' => Request::all('search', 'trashed'),
            'goals' => Auth::user()->account->goals()
                ->orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($goal) {
                    return [
                        'id' => $goal->id,
                        'name' => $goal->name,
                        'period' => $goal->period,
                        'amount' => $goal->amount,
                        'type' => $goal->type,
                        'starts_on' => $goal->starts_on,
                        'ends_on' => $goal->ends_on,
                        'deleted_at' => $goal->deleted_at
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Goals/Create', [
            'periods' => Goal::getSupportedPeriods(),
            'types' => Goal::types(),
            'income_tags' => Auth::user()->account
                ->income_tags()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'expense_tags' => Auth::user()->account
                ->expense_tags()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->goals()->create(
            Request::validate(Goal::rules())
        );

        return Redirect::route('goals')->with('success', 'Goal created.');
    }

    public function edit(Goal $goal)
    {
        return Inertia::render('Goals/Edit', [
            'goal' => [
                'id' => $goal->id,
                'name' => $goal->name,
                'period' => $goal->period,
                'amount' => $goal->amount,
                'type' => $goal->type,
                'starts_on' => $goal->starts_on,
                'ends_on' => $goal->ends_on,
                'deleted_at' => $goal->deleted_at
            ],
            'periods' => Goal::getSupportedPeriods(),
            'types' => Goal::types(),
            'income_tags' => Auth::user()->account
                ->income_tags()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'expense_tags' => Auth::user()->account
                ->expense_tags()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Goal $goal)
    {
        $goal->update(
            Request::validate(Goal::rules())
        );

        return Redirect::back()->with('success', 'Goal updated.');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();

        return Redirect::back()->with('success', 'Goal deleted.');
    }

    public function restore(Goal $goal)
    {
        $goal->restore();

        return Redirect::back()->with('success', 'Goal restored.');
    }
}
