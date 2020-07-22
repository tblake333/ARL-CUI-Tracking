@extends('app')

@section('title', 'Items')

@section('content')

    <h1>Items</h1>

    @forelse($items as $item)

        <p><a href="/items/{{ $item->id }}">{{ $item->title }}</a></p>

    @empty

        <p>No items to display.</p>

    @endforelse

@endsection