@extends('app')

@section('title', 'Results')

@section('content')

    <h1>Results</h1>

    @forelse($results as $item)

        <p><a href="/items/{{ $item->id }}">{{ $item->title }}</a></p>

    @empty

        <p>No items to display.</p>

    @endforelse

@endsection