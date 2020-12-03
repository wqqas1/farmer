<?php

namespace App\Http\Controllers;

use App\Models\IncomeTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class IncomeTagsController extends Controller
{
    public function index()
    {
        return Inertia::render('IncomeTags/Index', [
            'filters' => Request::all('search', 'trashed'),
            'income_tags' => Auth::user()->account->income_tags()
                ->orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($income_tag) {
                    return [
                        'id' => $income_tag->id,
                        'name' => $income_tag->name,
                        'color' => $income_tag->color,
                        'deleted_at' => $income_tag->deleted_at
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('IncomeTags/Create');
    }

    public function store()
    {
        Auth::user()->account->income_tags()->create(
            Request::validate(IncomeTag::rules())
        );

        return Redirect::route('income_tags')->with('success', 'Income Tag created.');
    }

    public function edit(IncomeTag $income_tag)
    {
        return Inertia::render('IncomeTags/Edit', [
            'income_tag' => [
                'id' => $income_tag->id,
                'name' => $income_tag->name,
                'color' => $income_tag->color,
                'deleted_at' => $income_tag->deleted_at
            ]
        ]);
    }

    public function update(IncomeTag $income_tag)
    {
        $income_tag->update(
            Request::validate(IncomeTag::rules())
        );

        return Redirect::back()->with('success', 'Income Tag updated.');
    }

    public function destroy(IncomeTag $income_tag)
    {
        $income_tag->delete();

        return Redirect::back()->with('success', 'Income Tag deleted.');
    }

    public function restore(IncomeTag $income_tag)
    {
        $income_tag->restore();

        return Redirect::back()->with('success', 'Income Tag restored.');
    }
}
