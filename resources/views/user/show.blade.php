@extends('app')

@section('title', 'View User')

@section('content')

    <h1>User Details</h1>

    <div>
        <a href="/users">Back</a>
    </div>

    <strong>First Name</strong>
    <p>{{ $user->first_name }}</p>

    <strong>Last Name</strong>
    <p>{{ $user->last_name }}</p>

    <strong>Badge Number</strong>
    <p>{{ $user->badge_number }}</p>

@endsection