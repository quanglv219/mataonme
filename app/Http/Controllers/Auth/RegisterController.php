<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customization;
use App\Models\SocialMediaLink;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'unique:users', 'alpha_dash'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
        // Get the newly created user
        $user = User::where('email', $data['email'])->first();
        // Create this user as a stripe customer
        $user->createAsStripeCustomer();
        // Create an empty social media links row for this use so we can update it later
        SocialMediaLink::create(['user_id' => $user->id]);
        // Create a default colors customization
        Customization::create([
            'user_id' => $user->id,
            'fontSize' => '15',
            'fontWeight' => '500',
            'fontColor' => '#17D8E2',
            'fontColorHover' => 'white',
            'pageBackground' => '{
                "name": "Blue",
                "colors": ["#17D8E2", "#28abb2"]
            }',
            'buttonBackground' => 'white',
            'buttonBackgroundHover' => '#17D8E2',
            'buttonBorderSize' => '2',
            'buttonBorderSizeHover' => '2',
            'buttonBorder' => 'white',
            'buttonBorderHover' => 'white',
            'borderRadius' => '12',
            'iconColor' => 'white'
        ]);
        return $user;
    }
}
