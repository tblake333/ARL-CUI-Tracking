@extends('app')

@section('title', 'Check-Out')

@section('scripts')
<script src="/js/app.js"></script>
@endsection

@section('content')

<h1>Check-Out Confirmation</h1>

<form action="/check-out/{{ $item->id }}" class="create-item-form" method="POST">

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

    <div class="input-item">
        <div class="i">
            <i class="fas fa-id-badge"></i>
        </div>
        <div>
            <h5>Badge #</h5>
            <input name="badge_number" type="text" maxlength="6" id="checkout_badge_number" pattern="\d+" required>
        </div>
    </div>
    
    <div class="owner-container" id="checkout-container">

    </div>

    <div class="input-item">
        <div class="i">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <div>
            <h5>Location</h5>
            <input name="location" type="text" maxlength="30" id="checkout_badge_number" required>
        </div>
    </div>


    @csrf

    <div class="button">
        <button>Check-Out</button>
    </div>
</form>


@endsection
