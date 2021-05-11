<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Models\Customization;
use App\Models\SocialMediaLink;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|alpha_dash',
            'password' => 'required',
        ]);
        $user = new User();
        $user->create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'is_admin' => $request->is_admin ?? false
        ])->save();
        // Get the newly created user
        $user = User::where('email', $request->email)->first();
        // Create this user as a stripe customer
        $user->createAsStripeCustomer();
        // Create an empty social media links row for this use so we can update it later
        SocialMediaLink::create(['user_id' => $user->id]);
        // Create a default colors customization
        Customization::create([
            'user_id' => $user->id,
            'fontSize' => '25',
            'fontWeight' => '900',
            'fontColor' => 'white',
            'fontColorHover' => 'grey',
            'pageBackground' => '{
                "name": "Mango Pulp",
                "colors": ["#F09819", "#EDDE5D"]
            }',
            'buttonBackground' => 'grey',
            'buttonBackgroundHover' => 'white',
            'buttonBorderSize' => '2',
            'buttonBorderSizeHover' => '3',
            'buttonBorder' => 'black',
            'buttonBorderHover' => '5',
            'borderRadius' => '12'
        ]);
        return back()->with(['response' => 'User added succesfully.']);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|alpha_dash'
        ]);
        $user->update($request->only('name', 'email', 'username'));
        return back()->with(['response' => 'User updated successfully.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with(['response' => 'User deleted successfully.']);
    }
}
