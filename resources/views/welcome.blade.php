@extends('layouts.app')


@section('content')
    @guest
    <div class="flex-center position-ref heightcontainer">
        <div class="content">
            <div class="title m-b-md">
                en0 Upload
            </div>
                <div class="links">
                    <a href="/login/gitlab">log in</a>
                </div>
        </div>
    </div>
    @endguest
@endsection
