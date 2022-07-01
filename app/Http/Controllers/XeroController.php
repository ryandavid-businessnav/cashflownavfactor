<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Illuminate\Http\Request;
use LangleyFoxall\XeroLaravel\OAuth2;
use LangleyFoxall\XeroLaravel\XeroApp;
use League\OAuth2\Client\Token\AccessToken;
use App\Models\UserOrganization;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\BusinessSetting;
use App\Models\Organisation;
use App\Models\ChartOfAccount;

class XeroController extends Controller
{
    private function getOAuth2()
    {
        // This will use the 'default' app configuration found in your 'config/xero-laravel-lf.php` file.
        // If you wish to use an alternative app configuration you can specify its key (e.g. `new OAuth2('other_app')`).
        return new OAuth2();
    }

    public function redirectUserToXero()
    {
        // Step 1 - Redirect the user to the Xero authorization URL.

        $code_verifier = '--6t5HeyDNhPx8C9MYOEFWAgj9q9Ijhg7at-WtGGmrgIVB';
        $hash = hash('sha256', $code_verifier);
        $code_challenge = base64_encode(pack('H*', $hash));
        $codeChallenge = strtr(rtrim($code_challenge, '='), '+/', '-_');

        // return redirect('https://login.xero.com/identity/connect/authorize?response_type=code&code_challenge_method=S256&client_id=F6E5A2767452405A8C69BFC17DDE880D&scope=openid email profile accounting.settings offline_access accounting.contacts&redirect_uri=https://xero.cashflownavfactor.com/xero/callback&state=12345&code_challenge='.$codeChallenge);

        return redirect('https://login.xero.com/identity/connect/authorize?response_type=code&code_challenge_method=S256&client_id=F6E5A2767452405A8C69BFC17DDE880D&scope=openid email profile accounting.settings offline_access accounting.contacts&redirect_uri=http://localhost:8001/xero/callback&state=12345&code_challenge='.$codeChallenge);
    }

    public function redirectToXero(Request $request){
        $input = $request->all();
        $client = new \GuzzleHttp\Client();
        if(isset($input['error']) && $input['error'] == "access_denied"){
            return redirect('/home');
        }

        $code_verifier = '--6t5HeyDNhPx8C9MYOEFWAgj9q9Ijhg7at-WtGGmrgIVB';

        $response = $client->post('https://identity.xero.com/connect/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => 'F6E5A2767452405A8C69BFC17DDE880D',
                'code' => $input['code'],
                //'redirect_uri' => 'https://xero.cashflownavfactor.com/xero/callback',
                'redirect_uri' => 'http://localhost:8001/xero/callback',
                //'code_verifier' => 'thisismycode123thisismycode123thisismycode123thisismycode1234',
                'code_verifier' => $code_verifier
            ]
        ]);

        $resp = $response->getBody();

        $result = json_decode($resp, true);

        $body = [
            'id_token' => $result['id_token'],
            'token_type' => 'Bearer',
            'scope' => 'openid email profile accounting.settings offline_access accounting.contacts',
            'access_token' => $result['access_token'],
            'refresh_token' => $result['refresh_token'],
            'expires' => $result['expires_in']
        ];

        $accessToken = new AccessToken(collect(json_decode( json_encode($body) ))->toArray());
        $tenants = $this->getOAuth2()->getTenants($accessToken);
        $selectedTenant = $tenants[0]; // For example purposes, we're pretending the user selected the first tenant.
        foreach($tenants as $key => $tenant){

            $xero = new XeroApp(
                new AccessToken(collect($accessToken)->toArray()),
                $tenant->tenantId
            );
            // $xeroCheck = DB::table('business_settings')->where(['xero_tenant_id' => $tenant->tenantId])->first();
            $org = $xero->organisations()->first();
            $user = $xero->users()->first();
            $request->session()->put('xeroOrg', collect($org)->toArray());
            $request->session()->put('tenantId', $tenant->tenantId);
            $request->session()->put('tenantInfo', collect($tenant)->toArray());
            $request->session()->put('userInfo', collect($user)->toArray());
            $request->session()->put('accessToken', collect($accessToken)->toArray());

            return redirect('/xero/signup')->with('status', 'Successfully Signed in via Xero! Fill out the form to register to CASHFLOWNAV!');
        }
    }

    public function refreshAccessTokenIfNecessary(Request $request)
    {
        // Step 5 - Before using the access token, check if it has expired and refresh it if necessary.
        $user = auth()->user();
        $accessToken = new AccessToken(collect(json_decode($request->session()->get('xeroOrg')->xero_access_token))->toArray());
        //dd($request->session()->get('xeroOrg')->tenant_id);
        if ($accessToken->hasExpired()) {
            $accessToken = $this->getOAuth2()->refreshAccessToken($accessToken);

            DB::table('user_organizations')->update([
                'xero_access_token' => json_encode($accessToken)
            ])->where('tenant_id', $request->session()->get('xeroOrg')->tenant_id);
        }
    }

    public function xeroSignup(Request $request){
        if($request->session()->get('accessToken.id_token')){
            $jsonToken = $request->session()->get('accessToken.id_token');
            $token = ($jsonToken);
            
            $tokenParts = explode(".", $token);  
            $tokenHeader = base64_decode($tokenParts[0]);
            $tokenPayload = base64_decode($tokenParts[1]);

            $jwtHeader = json_decode($tokenHeader);
            $jwtPayload = json_decode($tokenPayload);
            
            $phoneNumber = str_replace(' ', '', session('xeroOrg.Phones.0.PhoneNumber'));

            
            $request->session()->put('phoneNumber', $phoneNumber);
            $request->session()->put('jwtPayload', collect($jwtPayload)->toArray());
        }
        $user = User::where('email', $request->session()->get('jwtPayload.email'))->first();
        //dd($request->session()->get('jwtPayload.email'));
        if(collect($user)->isNotEmpty()){
            

            $xero = new XeroApp(
                new AccessToken($request->session()->get('accessToken')),
                $request->session()->get('tenantId')
            );

            ChartOfAccount::where('tenant_id', $request->session()->get('tenantId'))->delete();
            foreach($xero->accounts as $val){
                $chartOfAccount = new ChartOfAccount;
                $chartOfAccount->account_id = $val['AccountID'];
                $chartOfAccount->tenant_id = $request->session()->get('tenantId');
                $chartOfAccount->name = $val['Name'];    
                $chartOfAccount->code = $val['Code'];    
                $chartOfAccount->type = $val['Type'];    
                $chartOfAccount->save();
            }

            $user->xero_userid = $request->session()->get('jwtPayload.xero_userid');
            $user->save();

            Auth::loginUsingId($user->id);

            $request->session()->forget('xeroOrg');
            $request->session()->forget('tenantInfo');
            $request->session()->forget('tenantId');
            $request->session()->forget('userInfo');
            $request->session()->forget('accessToken');
            $request->session()->forget('access_token');
            $request->session()->forget('phoneNumber');
            $request->session()->forget('jwtPayload');

            return redirect('/');
        }else{
            

            return view('xero-signup');
        }
        //dd($user);
    }

    public function refreshXeroToken(Request $request){
        //dd($request->session()->get('access_token'));
        //refresh token if necessary
        $accessToken = new AccessToken(collect(json_decode( json_encode($request->session()->get('accessToken')) ))->toArray());
        //dd($accessToken->hasExpired());
        if ($accessToken->hasExpired()) {
            $accessTokens = $this->getOAuth2()->refreshAccessToken($accessToken);
            
            $request->session()->forget('access_token');
            $request->session()->put('access_token', json_encode($accessTokens));
            //dd($request->session()->get('access_token'));
            DB::table('user_organizations')->where('tenant_id', $request->session()->get('xeroOrg')->tenant_id)->update([
                'xero_access_token' => json_encode($accessTokens)
            ]);
        }
    }

    public function saveUser(Request $request){
        $input = $request->all();
        //dd($input);
        $request->session()->put('access_token', $request->session()->get('accessToken.access_token'));

        if(collect($request->session()->get('accessToken'))->isEmpty() ){
            return redirect('/home');
        }else{
            $this->refreshXeroToken($request);
        }

        $convertedUserPhone = '';
        $convertedPhone = '';

            //dd($input['phoneNumber']);
        if(collect($input['userPhoneNumber'])->isNotEmpty()){
            if($input['userPhoneNumber'][0] == "0"){
                $convertedUserPhone = substr_replace($input['userPhoneNumber'], '+61', 0, strlen("0"));
            }else{
                $convertedUserPhone = '+61'.$input['userPhoneNumber'];
            }
        }
        if(collect($input['phoneNumber'])->isNotEmpty()){
            if($input['phoneNumber'][0] == "0"){
                $convertedPhone = substr_replace($input['phoneNumber'], '+61', 0, strlen("0"));
                //$convertedPhone = substr($input['userPhoneNumber'],"+61",0);
            }else{
                $convertedPhone = '+61'.$input['phoneNumber'];
            }
        }

        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        //dd($convertedUserPhone);
        if(collect($input['userPhoneNumber'])->isNotEmpty()){
            $phoneCheck = DB::table('users')->where('mobile_number', $convertedUserPhone)->first();
            if(collect($phoneCheck)->isNotEmpty()){
                return redirect('/home')->with('error_status', 'Mobile number already exist!');
            }
        }
        $emailCheck = DB::table('users')->where('email', $input['email'])->first();
        if(collect($emailCheck)->isNotEmpty()){
            return redirect('/home')->with('error_status', 'Email already exist!');
        }
        $user = new User();
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->first_name = $input['firstName'];
        $user->last_name = $input['lastName'];
        $user->mobile_number = $convertedUserPhone;
        $user->is_active = 1;
        $user->is_verified = 0;
        $user->is_phone_verified = 0;
        $user->xero_userid = $request->session()->get('jwtPayload.xero_userid');
        $user->save();

        $xeroCheck = DB::table('business_settings')->where(['xero_tenant_id' => $request->session()->get('tenantId')])->first();
        //if(collect($xeroCheck)->isEmpty()){

        

            $businessSetting = new BusinessSetting();
            $businessSetting->user_id = $user->id;
            $businessSetting->company_name = $input['businessName'];
            $businessSetting->address = $input['address'];
            $businessSetting->no_of_employees = $input['numberOfEmployees'];
            $businessSetting->currency = $input['currency'];
            $businessSetting->anzic_division = $input['anzic_code'];
            $businessSetting->anzic_subdivision = $input['anzic_subdivision'];
            $businessSetting->mobile_number = $convertedPhone;
            $businessSetting->trading_name = $input['businessName'];
            $businessSetting->xero_access_token = $request->session()->get('accessToken.access_token');
            $businessSetting->xero_refresh_token = $request->session()->get('accessToken.refresh_token');
            $businessSetting->xero_tenant_name = $request->session()->get('tenantInfo.tenantName');
            $businessSetting->xero_tenant_id = $request->session()->get('tenantId');
            $businessSetting->save();

            $org = new Organisation();
            $org->business_form_id = $businessSetting->id;
            $org->user_id = $user->id;
            $org->role = 'owner';
            $org->read_access = 1;
            $org->write_access = 1;
            $org->is_admin = 1;
            $org->save();
        // }else{
        //     $org = new Organisation();
        //     $org->business_form_id = $xeroCheck->id;
        //     $org->user_id = $user->id;
        //     $org->role = 'member';
        //     $org->read_access = 1;
        //     $org->write_access = 1;
        //     $org->is_admin = 1;
        //     $org->save();
        // }

        $request->session()->forget('xeroOrg');
        $request->session()->forget('tenantInfo');
        $request->session()->forget('tenantId');
        $request->session()->forget('userInfo');
        $request->session()->forget('accessToken');
        $request->session()->forget('access_token');
        $request->session()->forget('phoneNumber');

        return redirect('/xero/signin');
    }

    public function xeroSignin(Request $request){
        $user = User::where('email', $request->session()->get('jwtPayload.email'))->first();
        //dd($user);
        Auth::loginUsingId($user->id);
        //$request->session()->forget('jwtPayload');
        // dd(Auth::user());
        // dd($request->session()->get('jwtPayload'));
        return redirect('/');

    }
}