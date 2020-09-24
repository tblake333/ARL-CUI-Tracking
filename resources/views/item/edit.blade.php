@extends('app')

@section('title', 'Edit Item')

@section('scripts')
<script src="/js/app.js"></script>
@endsection

@section('content')

<h1>Edit Item Details</h1>

<form action="/items/{{ $item->id }}" method="POST" class="create-item-form">

    @method('PATCH')

    <div class="input-item @error('title') invalid @enderror @if( old('title') ?? $item->title ) filled  @endif">
        <div class="i">
            <i class="fas fa-cube"></i>
        </div>
        <div>
            <h5>Title</h5>
            <input name="title" value="{{ old('title') ?? $item->title }}" type="text"
                maxlength="30" required>
            @error('title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="input-item @error('type') invalid @enderror @if( old('type') ?? $item->type ) filled  @endif">
        <div class="i">
            <i class="fas fa-tag"></i>
        </div>
        <div>
            <h5>Type</h5>
            <input name="type" value="{{ old('type') ?? $item->type }}" type="text"
                maxlength="30" required>
            @error('type')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div
        class="input-item @error('owner.badge_number') invalid @enderror @if( old('owner.badge_number') ?? $item->owner_badge_number ) filled  @endif">
        <div class="i">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <h5>Owner</h5>
            <input name="owner[badge_number]"
                value="{{ old('owner.badge_number') ?? $item->owner_badge_number }}"
                id="badge_number" type="text" maxlength="6" pattern="\d+" required>
            @error('owner.badge_number')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="owner-container" id="owner-container">

    </div>

    <div class="input-item @error('source') invalid @enderror @if( old('source') ?? $item->source ) filled  @endif">
        <div class="i">
            <i class="fas fa-search-location"></i>
        </div>
        <div>
            <h5>Source</h5>
            <input name="source" value="{{ old('source') ?? $item->source }}" type="text"
                maxlength="30">
            @error('source')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="input-item filled @error('source_date') invalid @enderror">
        <div class="i">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div>
            <h5>Source Date</h5>
            <input name="source_date"
                value="{{ old('source_date') ?? $item->source_date }}" type="date">
            @error('source_date')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div
        class="input-item @error('location') invalid @enderror @if( old('location') ?? $item->location ) filled  @endif">
        <div class="i">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <div>
            <h5>Location</h5>
            <input name="location" value="{{ old('location') ?? $item->location }}"
                type="text" required>
            @error('location')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div
        class="input-item @error('description') invalid @enderror @if( old('description') ?? $item->description ) filled  @endif">
        <div class="i">
            <i class="fas fa-info-circle"></i>
        </div>
        <div>
            <h5>Description</h5>
            <input name="description"
                value="{{ old('description') ?? $item->description }}" type="text"
                maxlength="250">
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div
        class="input-item @error('keywords') invalid @enderror @if( old('keywords') ?? $item->keywords ) filled  @endif">
        <div class="i">
            <i class="fas fa-hashtag"></i>
        </div>
        <div>
            <h5>Keywords</h5>
            <input name="keywords" value="{{ old('keywords') ?? $item->keywords }}"
                type="text" maxlength="40">
            @error('keywords')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="input-item @error('barcode') invalid @enderror @if( old('barcode') ?? $item->barcode ) filled  @endif">
        <div class="i">
            <i class="fas fa-barcode"></i>
        </div>
        <div>
            <h5>Barcode</h5>
            <input name="barcode" value="{{ old('barcode') ?? $item->barcode }}"
                type="text" maxlength="10" required>
            @error('barcode')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="input-item @error('edited_by.badge_number') invalid @enderror @if( old('edited_by.badge_number') ) filled  @endif">
        <div class="i">
            <i class="fas fa-id-badge"></i>
        </div>
        <div>
            <h5>Badge Number</h5>
            <input name="edited_by[badge_number]" value="{{ old('edited_by.badge_number') }}" autocomplete="off" pattern="\d+"
                type="text" maxlength="6" id="edited_badge_number" required>
            @error('edited_by.badge_number')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="owner-container" id="edited-container">

    </div>

    @csrf

    <div class="button">
        <button>Save item</button>
    </div>

</form>

@endsection
