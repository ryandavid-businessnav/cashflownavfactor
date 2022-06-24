<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Carbon\Carbon;

class BusinessesController extends Controller
{
    public function index()
    {
        return Inertia::render('Businesses/Index', [
            'filters' => Request::all('search', 'trashed'),
            'organizations' => Auth::user()->businesses()
                ->orderBy('company_name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($organization) => [
                    'id' => $organization->id,
                    'company_name' => $organization->company_name
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Businesses/Create');
    }

    public function store()
    {
        Auth::user()->businesses()->create(
            Request::validate([
                'company_name' => ['required', 'max:100'],
                //'email' => ['nullable', 'max:50', 'email'],
                'mobile_number' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'anzic_division' => ['nullable'],
                'anzic_subdivision' => ['nullable'],
                'abn' => ['nullable'],
                'currency' => ['nullable'],
                'no_of_employees' => ['nullable'],
                'trading_name' => ['nullable'],
                'brand_name' => ['nullable'],
            ])
        );

        return Redirect::route('businesses')->with('success', 'Business created.');
    }

    public function edit(BusinessSetting $business)
    {
        return Inertia::render('Businesses/Edit', [
            'business' => [
                'id' => $business->id,
                'company_name' => $business->company_name,
                'address' => $business->address,
                'mobile_number' => $business->mobile_number,
                'no_of_employees' => $business->no_of_employees,
                'anzic_division' => $business->anzic_division,
                'anzic_subdivision' => $business->anzic_subdivision,
                'currency' => $business->currency,
                'deleted_at' => Carbon::parse($business->deleted_at)->toDateString()
            ],
        ]);
    }

    public function update(BusinessSetting $business)
    {
        $business->update(
            Request::validate([
                'company_name' => ['required', 'max:50'],
                'mobile_number' => ['required', 'max:15'],
                'address' => ['required', 'max:100'],
                'no_of_employees' => ['required'],
                'currency' => ['required'],
                'anzic_division' => ['required'],
                'anzic_subdivision' => ['required'],
            ])
        );

        return Redirect::back()->with('success', 'Business updated.');
    }
}
