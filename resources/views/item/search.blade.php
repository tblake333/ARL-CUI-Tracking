@extends('app')

@section('title', 'Search')

@section('content')

<h1>Search</h1>

<form action="/items/search" method="POST" class="create-item-form">

    <div class="input-item">
        <div class="i">
            <i class="fas fa-search"></i>
        </div>
        <div>
            <h5>Search</h5>
            <input name="query" type="text" required>
        </div>
    </div>

    @csrf

    <div class="button">
        <button>Search</button>
    </div>

</form>

@endsection
