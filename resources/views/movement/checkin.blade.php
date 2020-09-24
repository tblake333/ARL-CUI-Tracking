@extends('app')

@section('title', 'Check-In')

@section('content')

<h1>Check-In Confirmation</h1>

<form action="/check-in/{{ $item->id }}" class="create-item-form" method="POST">

    <div class="item-container">

        <a href="/items/{{ $item->id }}" class="card item-card">
            <div class="card-top">
                <span>{{ $item->title }}</span>
                <div class="barcode-info">
                    <div>
                        <i class="fas fa-barcode"></i>
                        <div class="laser"></div>
                    </div>
                    <span>{{ $item->barcode }}</span>
                </div>
            </div>
            <div class="card-middle">
                <span>{{ $item->description }}</span>
            </div>
            <div class="card-bottom">
                <div>
                    <div class="icon-container grow">
                        <i class="fas fa-tag"></i>
                    </div>
                    <span>{{ $item->type }}</span>
                </div>
                <div>
                    <div class="icon-container wiggle">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <span>{{ $item->location }}</span>
                </div>
            </div>
        </a>

    </div>

    <div class="owner-container">
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
    </div>

    @csrf

    <div class="button">
        <button>Check-In</button>
    </div>
</form>


@endsection
