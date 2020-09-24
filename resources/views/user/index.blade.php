@extends('app')

@section('title', 'Users')

@section('content')

<h1>Users</h1>


<div class="results-container">

    @forelse($users as $user)

        <a href="/users/{{ $user->badge_number }}" class="card user-card">
            <div class="user-name card-section">
                <span>{{ $user->first_name . ' ' . $user->last_name }}</span>
            </div>
            <div class="badge-info card-section">
                <div>
                    <i class="fas fa-id-badge"></i>
                </div>
                <span>{{ $user->badge_number }}</span>
            </div>
        </a>


    @empty

        <p>No users to display.</p>

    @endforelse

</div>

@endsection
