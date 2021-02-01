@extends('app')

@section('title', 'View Item')

@section('content')

<div class="title-container">
    <h2 class="item-title item-data">{{ $item->title }}<a href="/items/{{ $item->id }}/edit" class="edit-button"><i
                class="fas fa-pen"></i><span>Edit</span></a></h2>


</div>

<h2 class="item-data"><i class="fas fa-barcode"></i> {{ $item->barcode }}</h2>

<div class="item-info">

    <div class="item-details">

        <div>
            <span class="attribute-name">Type</span>
            <span class="attribute-value">{{ $item->type }}</span>
        </div>

        @if($item->source)

            <div>
                <span class="attribute-name">Source</span>
                <span class="attribute-value">{{ $item->source }}</span>
            </div>

        @endif

        @if($item->source_date)

            <div>
                <span class="attribute-name">Source Date</span>
                <span class="attribute-value">2015-06-21</span>
            </div>

        @endif

        <div>
            <span class="attribute-name">Location</span>
            
            <span class="attribute-value">{{ $item->location }}</span>
        </div>

        @if($item->getCurrentLocation() !== $item->location)

        <div>
            <span class="attribute-name">Current location (checked-out)</span>
            
            <span class="attribute-value">{{ $item->getCurrentLocation() }}</span>
        </div>

        @endif

        <div>
            <span class="attribute-name">Description</span>
            <span class="attribute-value">{{ $item->description }}</span>
        </div>

        <div>
            <span class="attribute-name">Date Entered</span>
            <span class="attribute-value">{{ $item->created_at }}</span>
        </div>

        <div>
            <span class="attribute-name">Last Modified</span>
            <span class="attribute-value">{{ $item->updated_at }}</span>
        </div>

        <div>
            <span class="attribute-name">ID</span>
            <span class="attribute-value">{{ $item->id }}</span>
        </div>

    </div>

    <div class="item-owner">
        <h3>Owner</h3>
        <a href="/users/{{ $item->owner_badge_number }}" class="card user-card">
            <span
                class="user-name">{{ $item->owner->first_name . ' ' . $item->owner->last_name }}</span>
            <div class="user-badge-number">
                <i class="fas fa-id-badge"></i>
                <span>{{ $item->owner_badge_number }}</span>
            </div>
        </a>
    </div>

    <div class="item-status">

        @if($item->getStatus() === 'in')
            <h3 class="checked-in">Checked-In</h3>
        @else
            <h3 class="checked-out">Checked-Out</h3>
        @endif


        @php

            $latestUser = $item->getLatestUser();

        @endphp

        @if($latestUser)
            <h4>Last User:</h4>
            <a href="/users/{{ $latestUser->badge_number }}" class="card user-card">
                <span
                    class="user-name">{{ $latestUser->first_name . ' ' . $latestUser->last_name }}</span>
                <div class="user-badge-number">
                    <i class="fas fa-id-badge"></i>
                    <span>{{ $latestUser->badge_number }}</span>
                </div>
            </a>
        @else
            <h4>Not Checked-Out Yet</h4>
        @endif

    </div>

    <div class="item-movements">

        @if(count($item->movements) === 0)
            <h3>No Movements</h3>
        @else
            <h3>Movements</h3>
        @endif

        @foreach($item->movements as $movement)
            <div class="movement-card">
                <a href="/users/{{ $movement->badge_number }}" class="card user-card">
                    <span
                        class="user-name">{{ $movement->user->first_name . ' ' . $movement->user->last_name }}</span>
                    <div class="user-badge-number">
                        <i class="fas fa-id-badge"></i>
                        <span>{{ $movement->badge_number }}</span>
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

    <div class="item-changes">

        @if(count($item->getGroupedModifications()) == 0)
            <h3>No Changes</h3>
        @else
            <h3>Changes</h3>
        @endif

        @foreach($item->getGroupedModifications() as $key => $modificationList)

            @php

                $timestamp_badge_number = explode('_', $key);

                $timestamp = $timestamp_badge_number[0];
                $badge_number = $timestamp_badge_number[1];

                $datetime = explode(' ', $timestamp);
                $date = $datetime[0];
                $time = $datetime[1];

                $user = $modificationList[0]->user;

            @endphp

            <div class="change-card">

                <a href="/users/{{ $badge_number }}" class="card user-card">
                    <span
                        class="user-name">{{ $user->first_name . ' ' . $user->last_name }}</span>
                    <div class="user-badge-number">
                        <i class="fas fa-id-badge"></i>
                        <span>{{ $badge_number }}</span>
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
