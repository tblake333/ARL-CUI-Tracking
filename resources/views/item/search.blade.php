@extends('app')

@section('title', 'Edit Item')

@section('content')

    <h1>Edit Item Details</h1>

    <form action="/items/{{ $item->id }}" method="POST">

        @method('PATCH')
        
        @include('item.form')

        <div>
            <label for="keywords">Badge Number</label>
            <input type="text" name="edited_by[badge_number]" autocomplete="off" value="{{ old('badge_number') }}">
            @error('edited_by.badge_number') <p>{{ $message }}</p> @enderror
        </div>

        <button>Save item</button>

    </form>

@endsection