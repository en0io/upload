@extends('layouts/app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register</div>

                <div class="card-body">

                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')"/>

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                    <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                        <div>
                            <x-label for="email" :value="__('Email')"/>

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                     :value="old('email')" required autofocus/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="btn-dark">
                                {{ __('Email Password Reset Link') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
