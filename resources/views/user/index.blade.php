@extends('app')

@section('title', 'Users')

@section('content')

    <h1>Users</h1>
    
    @forelse($users as $user)

        <p><a href="/users/{{ $user->badge_number }}">{{ $user->first_name }}</a></p>

    @empty

        <p>No users to display.</p>

    @endforelse

@endsection