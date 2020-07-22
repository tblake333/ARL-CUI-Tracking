@extends('app')

@section('title', 'Add Item')

@section('content')

    <h1>Add new item</h1>

    <form action="/items" method="POST">

        @include('item.form')

        <button>Add item</button>

    </form>

@endsection