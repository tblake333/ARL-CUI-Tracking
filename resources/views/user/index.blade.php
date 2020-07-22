@extends('app')

@section('title', 'Users')

@section('content')

    <h1>Users</h1>
    
    @forelse($users as $user)

        <p>{{ $user->first_name }}</p>

    @empty

        <p>No users to display.</p>

    @endforelse

@endsection