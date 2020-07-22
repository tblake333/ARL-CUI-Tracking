@extends('app')

@section('title', 'View Item')

@section('content')

    <h1>Item Details</h1>

    <div>
        <a href="/items">Back</a>
    </div>

    <strong>Title</strong>
    <p>{{ $item->title }}</p>

    <strong>Type</strong>
    <p>{{ $item->type }}</p>

    <strong>Source</strong>
    <p>{{ $item->source }}</p>

    <strong>Source Date</strong>
    <p>{{ $item->source_date }}</p>

    <strong>Location</strong>
    <p>{{ $item->location }}</p>

    <strong>Description</strong>
    <p>{{ $item->description }}</p>

    <div>
        <a href="/items/{{ $item->id }}/edit">Edit</a>
    </div>

@endsection