<?php

namespace App\Http\Controllers;

use App\Models\Scenario;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Carbon\Carbon;

class ScenariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
	public function list($id)
    {
        return Inertia::render('Scenarios/Index', [
            'filters' => Request::all('search', 'trashed'),
            'businessId' => $id,
            'scenarios' => Scenario::where('business_id', $id)
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($scenario) => [
                    'id' => $scenario->id,
                    'name' => $scenario->name
                ]),
        ]);
    }

    public function draft($id)
    {
    	Request::session()->forget('businessData','data');
    	$businessData = BusinessSetting::where('id',$id)->first();
        return Inertia::render('Scenarios/Draft',[
        	'businessId' => $id,
        	'businessData' => $businessData
        ]);
    }

    public function proceed(Request $request, $id){
    	$businessData = BusinessSetting::where('id',$id)->first();
    	Request::session()->put('businessData', $businessData);
    	Request::session()->put('data', Request::all());
        return redirect('scenarios');
    }

    public function create(){
    	if (Request::session()->exists('businessData')) {
	    	return Inertia::render('Scenarios/Create',[
	        	'businessId' => Request::session()->get('businessData')->id,
	        	'businessData' => Request::session()->get('businessData'),
	        	'data' => Request::session()->get('data')
	        ]);
    	}else{
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

    public function store(Request $request)
    {	
    	dd(Request::all());
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
}