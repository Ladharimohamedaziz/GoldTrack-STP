<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class CustomRegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.custom-register');
    }
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|max:20',
            'dob'        => 'required|date',
            'password'   => 'required|confirmed|min:6',
            'profile_image' => 'nullable|image|max:2048',
        ]);
        // Upload profile image if exists
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
        }
        // Create user
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'password' => Hash::make($request->password),
            'profile_image' => $profileImagePath,
        ]);
        // Login the user immediately
        Auth::login($user);
        // Redirect to dashboard or wherever you want
        return redirect()->route('register.form')->with('success', 'User registered successfully!');
    }
}
