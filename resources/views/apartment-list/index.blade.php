@extends('layouts.app')

@section('content')
<div id="app">
    <h1>Apartments</h1>

    @include('apartment-list._form')

    <ul class="list-group">
        <li  class="list-group-item" v-for="apartment in apartmentsList" track-by="$index">
            <span v-on:click="deleteListItem($index)">Delete</span>
            <span v-on:click="updateListItem($index)">Update</span>
            <h3>@{{ apartment.name }}</h3>
            <address>
                @{{ apartment.addressLine1 }}<br>
                @{{ apartment.addressLine2 }}<br>
                @{{ apartment.city }}<br>
                @{{ apartment.state }}<br>
                @{{ apartment.zip }}<br>
            </address>
            <p>
                @{{ apartment.notes }}
            </p>
            <ul class="list-unstyled">
                <li>Price $@{{ apartment.price }}/mo</li>
                <li>Parking Price $@{{ apartment.parkingPrice }}/mo</li>
                <li>Deposit $@{{ apartment.deposit }}/mo</li>
            </ul>
        </li>
    </ul>
</div>
@endsection
