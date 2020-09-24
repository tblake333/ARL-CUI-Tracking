@extends('app')

@section('title', 'View User')

@section('content')

<h2 class="user-data user-name">{{ $user->first_name . ' ' . $user->last_name }}
</h2>

<h2 class="user-data"><i class="fas fa-id-badge"></i> {{ $user->badge_number }}</h2>

<div class="user-info">

    <div class="owned item-list">


        @if(count($user->items) === 0)

            <h3>No Owned Items</h3>

        @else

            <h3>Owned Items</h3>

        @endif

        @foreach($user->items as $item)

            <a href="/items/{{ $item->id }}" class="card item-card">
                <span class="item-title">{{ $item->title }}</span>
                <div class="barcode-info">
                    <i class="fas fa-barcode"></i>
                    <span>{{ $item->barcode }}</span>
                </div>
            </a>

        @endforeach

    </div>


    <div class="checked-out item-list">

        @if(count($user->getCheckedOutItems()) === 0)

            <h3>No Items Checked-Out</h3>

        @else

            <h3>Checked-Out Items</h3>

        @endif

        @foreach($user->getCheckedOutItems() as $item)

            <a href="/items/{{ $item->id }}" class="card item-card">
                <span class="item-title">{{ $item->title }}</span>
                <div class="barcode-info">
                    <i class="fas fa-barcode"></i>
                    <span>{{ $item->barcode }}</span>
                </div>
            </a>

        @endforeach

    </div>

    <div class="movements movement-list">

        @if(count($user->movements) === 0)

            <h3>No Movements</h3>

        @else

            <h3>Movements</h3>

        @endif

        @foreach($user->movements as $movement)

            <div class="movement-card">
                <a href="/items/{{ $movement->item->id }}" class="card item-card">
                    <span class="item-title">{{ $movement->item->title }}</span>
                    <div class="barcode-info">
                        <i class="fas fa-barcode"></i>
                        <span>{{ $movement->barcode }}</span>
                    </div>
                </a>

                <div class="movement-info">

                    @if($movement->type === 'out')

                        <div class="check-out">
                            <div class="icon-container">
                                <i class="fas fa-dolly-flatbed"></i>
                            </div>
                            <span>Check-Out</span>
                        </div>

                    @else

                        <div class="check-in">
                            <div class="icon-container">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                            <span>Check-In</span>
                        </div>

                    @endif

                    @php

                        $datetime = explode(' ', $movement->time);

                        $date = $datetime[0];
                        $time = $datetime[1];

                    @endphp

                    <div>
                        <div class="icon-container">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <span>{{ $date }}</span>
                    </div>

                    <div>
                        <div class="icon-container">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span>{{ $time }}</span>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

    <div class="changes change-list">

        @if(count($user->getGroupedModifications()) == 0)
            <h3>No Changes</h3>
        @else
            <h3>Changes</h3>
        @endif

        @foreach($user->getGroupedModifications() as $key => $modificationList)

            @php

                $timestamp_item_id = explode('_', $key);

                $timestamp = $timestamp_item_id[0];
                $item_id = $timestamp_item_id[1];

                $datetime = explode(' ', $timestamp);
                $date = $datetime[0];
                $time = $datetime[1];

                $item = $modificationList[0]->item;

            @endphp

            <div class="change-card">

                <a href="/items/{{ $item_id }}" class="card item-card">
                    <span class="item-title">{{ $item->title }}</span>
                    <div class="barcode-info">
                        <i class="fas fa-barcode"></i>
                        <span>{{ $item->barcode }}</span>
                    </div>
                </a>

                <div class="change-info">

                    <div>
                        <div class="icon-container">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <span>{{ $date }}</span>
                    </div>

                    <div>
                        <div class="icon-container">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span>{{ $time }}</span>
                    </div>
                </div>

                <div class="modifications">

                    @foreach($modificationList as $modification)

                        <div class="card modification-card">

                            <div class="change-info">

                                <div>
                                    <div class="icon-container">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <span>{{ ucwords( str_replace('_', ' ', $modification->field) ) }}</span>
                                </div>

                                <div class="old">
                                    <div class="icon-container">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <span>{{ $modification->old }}</span>
                                </div>

                                <div class="new">
                                    <div class="icon-container">
                                        <i class="fas fa-sync"></i>
                                    </div>
                                    <span>{{ $modification->new }}</span>
                                </div>

                            </div>
                        </div>

                    @endforeach

                </div>

            </div>

        @endforeach


    </div>
</div>

@endsection
