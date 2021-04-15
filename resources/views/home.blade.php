@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Welcome to the Dashboard

                        @auth
                            <div>
                                <a href="{{ url('/create') }}" class="text-sm text-gray-700 underline">Log in</a>

                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
