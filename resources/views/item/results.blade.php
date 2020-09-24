@extends('app')

@section('title', 'Results')

@section('scripts')
<script src="/js/app.js"></script>
@endsection

@section('content')


<h1>Results</h1>

<div class="items-container">

    @forelse($results as $item)

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

    @empty

        <p>No items to display.</p>

    @endforelse

</div>

@endsection
