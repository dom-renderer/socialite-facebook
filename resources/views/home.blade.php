@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Instagram') }}</div>

                <div class="card-body">
                    <a href="{{ route('instagram.auth') }}" class="btn" style="background: pink;"> <i class="fa fa-instagram"></i> Authenticate </a>

                    <table class="table">
                        <thead>
                            <th>AVATAR</th>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>NICKNAME</th>
                            <th>EMAIL</th>
                            <th>PHONE NUMBER</th>
                        </thead>
                        <tbody>
                            @forelse (\App\Models\Facebook::get() as $user)
                                <tr>
                                    <th> <img src="{{ $user->avatar }}"> </th>
                                    <th>{{ $user->facebook_id }}</th>
                                    <th> {{ $user->full_name }} </th>
                                    <th>{{ $user->nickname ?? '-' }}</th>
                                    <th>{{ $user->email }}</th>
                                    <th>{{ $user->phone_number ?? '-' }}</th>
                                </tr>   
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-2">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Facebook') }}</div>

                <div class="card-body">
                    <a href="{{ route('facebook.auth') }}" class="btn btn-primary"> <i class="fa fa-facebook-f"></i> Authenticate </a>

                    <table class="table">
                        <thead>
                            <th>AVATAR</th>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>NICKNAME</th>
                            <th>EMAIL</th>
                            <th>PHONE NUMBER</th>
                        </thead>
                        <tbody>
                            @forelse (\App\Models\Facebook::get() as $user)
                                <tr>
                                    <th> <img src="{{ $user->avatar }}"> </th>
                                    <th>{{ $user->facebook_id }}</th>
                                    <th> {{ $user->full_name }} </th>
                                    <th>{{ $user->nickname ?? '-' }}</th>
                                    <th>{{ $user->email }}</th>
                                    <th>{{ $user->phone_number ?? '-' }}</th>
                                </tr>   
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


</div>
@endsection
