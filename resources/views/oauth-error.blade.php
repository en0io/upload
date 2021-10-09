@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>There was an error.</h1>
        <p>
            The login method you tried to use encountered an error. It's possible that there is already an account that
            conflicts with yours.
            @if(env('AUTH_LOCAL'))
                Since local authentication is enabled, try signing in with it instead.
            @endif


        </p>
        <p> <span class="text-sm text-secondary">400 Bad Request</span></p>

    </div>

@endsection
