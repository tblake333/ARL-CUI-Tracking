@extends('app')

@section('title', 'Check-In')

@section('scripts')
<script src="/js/app.js"></script>
@endsection

@section('content')

<h1>Please scan the barcode, or enter the barcode below</h1>

<form
    action="/check-in/barcode"
    class="create-item-form" method="POST">

    <div class="input-item">
        <div class="i">
            <i class="fas fa-barcode"></i>
        </div>
        <div>
            <h5>Barcode</h5>
            <input name="barcode" id="barcode-input" type="text" maxlength="10" required>
        </div>
    </div>

    @csrf

    <div class="button">
        <button>Check-In</button>
    </div>
</form>


@endsection
