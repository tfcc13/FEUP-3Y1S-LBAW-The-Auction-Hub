<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
  /**
   * Display a login form.
   */
  public function showLoginForm()
  {
    if (Auth::check()) {
      return redirect('/home');
    } else {
      return view('auth.login');
    }
  }

  /**
   * Handle an authentication attempt.
   */
  public function authenticate(Request $request): RedirectResponse
  {

    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
      $request->session()->regenerate();
      if (Auth::user()->state === 'Banned') {
        Auth::logout();
        return back()->withErrors([
          'email' => 'The provided credentials match a banned account.',
        ])->onlyInput('email');
      } else {
        return redirect()->intended('/home');
      }
    }

    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
  }

  /**
   * Log out the user from application.
   */
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login')->withSuccess('You have logged out successfully!');
  }

  public function redirectToGoogle()
  {
      return Socialite::driver('google')->redirect();
  }

  public function callbackGoogle() {

    $google_user = Socialite::driver('google')->stateless()->user();
    $user = User::where('google_id', $google_user->getId())->first();
    
    // If the user does not exist, create one
    if (!$user) {
        do {
            $username = 'googleUser_' . Str::random(6);
        } while (User::where('username', $username)->exists());

        // Store the provided name, email, and Google ID in the database
        $new_user = User::create([
            'name' => $google_user->getName(),
            'email' => $google_user->getEmail(),
            'google_id' => $google_user->getId(),
            'username' => $username,
            'birth_date' => '1985-02-5',
            
        ]);

        Auth::login($new_user);

    // Otherwise, simply log in with the existing user
    } else {
        if($user->state==='Banned') {
          return redirect()->route('login')->withErrors(['google' => 'Your account was banned.']);
        }
        if($user->state==='Deleted') {
          return redirect()->route('login')->withErrors(['google' => 'Your account was deleted.']);
        }

        Auth::login($user);
    }

    // After login, redirect to homepage
    return redirect()->intended('home');
  }


}
