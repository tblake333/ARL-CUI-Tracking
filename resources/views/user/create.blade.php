@extends('app')

@section('title', 'Add User')

@section('scripts')
<script src="/js/app.js"></script>
@endsection

@section('content')

    <h1>Create new user</h1>

    <form action="/users" method="POST">

        <label for="badge_number">Badge Number</label>

        <input type="text" id="badge_number" name="badge_number" autocomplete="off" value="{{ old('badge_number') }}" maxlength="6" pattern="\d+" required>
        @error('badge_number') <p>{{ $message }}</p> @enderror

        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" autocomplete="off" value="{{ old('first_name') }}" required>
        @error('first_name') <p>{{ $message }}</p> @enderror

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" autocomplete="off" value="{{ old('last_name') }}" required>
        @error('last_name') <p>{{ $message }}</p> @enderror

        <div class="center">
            <button>Create user</button>
        </div>

        @csrf

    </form>

@endsection