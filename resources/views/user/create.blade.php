@extends('app')

@section('title', 'Add User')

@section('content')

    <h1>Create new user</h1>

    <form action="/users" method="POST">

        <div>
            <label for="badge_number">Badge Number</label>
            <input type="text" name="badge_number" autocomplete="off" value="{{ old('badge_number') }}">
            @error('badge_number') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" autocomplete="off" value="{{ old('first_name') }}">
            @error('first_name') <p>{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" autocomplete="off" value="{{ old('last_name') }}">
            @error('last_name') <p>{{ $message }}</p> @enderror
        </div>

        <button>Create user</button>

        @csrf

    </form>

@endsection