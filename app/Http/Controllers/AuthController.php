<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => 'required|string',
        ]);

        $secretKey = config('services.recaptcha.secret_key');

        if (empty($secretKey)) {
            return back()
                ->withErrors([
                    'recaptcha' => 'CAPTCHA is not configured correctly. Please contact the administrator.',
                ])
                ->withInput($request->except([
                    'password',
                    'password_confirmation',
                    'g-recaptcha-response',
                ]));
        }

        // Verify CAPTCHA with Google
        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secretKey,
                    'response' => $validated['g-recaptcha-response'],
                    'remoteip' => $request->ip(),
                ]);

            if (
                !$response->successful() ||
                !$response->json('success', false)
            ) {
                return back()
                    ->withErrors([
                        'recaptcha' => 'Please complete the CAPTCHA verification correctly.',
                    ])
                    ->withInput($request->except([
                        'password',
                        'password_confirmation',
                        'g-recaptcha-response',
                    ]));
            }

        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors([
                    'recaptcha' => 'CAPTCHA verification is temporarily unavailable. Please try again.',
                ])
                ->withInput($request->except([
                    'password',
                    'password_confirmation',
                    'g-recaptcha-response',
                ]));
        }

        // Create customer account
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        // Automatically log in the new customer
        Auth::login($user);

        // Regenerate session after authentication
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Your GownEase account has been created successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors([
                'email' => 'The email or password is incorrect.',
            ])
            ->onlyInput('email');
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
