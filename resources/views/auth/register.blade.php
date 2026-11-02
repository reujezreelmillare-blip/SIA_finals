
@extends('layouts.app')

@section('title', 'Register | GownEase')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6 col-lg-5">
        <div class="content-card p-4 p-md-5">

            <h2 class="brand mb-2">Create an account</h2>

            <p class="text-secondary">
                Join GownEase to rent your favorite gowns.
            </p>

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control"
                           maxlength="100"
                           required>

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control"
                           required>

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           minlength="8"
                           required>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm password</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           minlength="8"
                           required>
                </div>

                <!-- Google reCAPTCHA -->
                <div class="mb-3">
                    <div class="g-recaptcha"
                         data-sitekey="{{ config('services.recaptcha.site_key') }}">
                    </div>

                    @error('g-recaptcha-response')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror

                    @error('recaptcha')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Create Account
                </button>
            </form>

            <p class="mt-3 mb-0 text-center">
                Already registered?
                <a href="{{ route('login') }}">Login here</a>
            </p>

        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
