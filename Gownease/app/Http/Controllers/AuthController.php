<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate registration fields and CAPTCHA response
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => 'required|string',
        ]);

        // Verify CAPTCHA with Google
        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $validated['g-recaptcha-response'],
                    'remoteip' => $request->ip(),
                ]);

            if (!$response->successful() ||
                !$response->json('success')) {

                return back()
                    ->withErrors([
                        'recaptcha' => 'Please complete the CAPTCHA verification correctly.'
                    ])
                    ->withInput($request->except([
                        'password',
                        'password_confirmation',
                        'g-recaptcha-response'
                    ]));
            }

        } catch (\Throwable $e) {

            return back()
                ->withErrors([
                    'recaptcha' => 'CAPTCHA verification is temporarily unavailable. Please try again.'
                ])
                ->withInput($request->except([
                    'password',
                    'password_confirmation',
                    'g-recaptcha-response'
                ]));
        }

        // Create customer account only after successful verification
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

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
                'email' => 'The email or password is incorrect.'
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
