<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DashboardController extends Controller
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
}
