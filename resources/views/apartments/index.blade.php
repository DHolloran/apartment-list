@extends('layouts.app')


@section('content')
<h1>Your Apartments</h1>

@if($apartments)
<a
    href="{{ action('ApartmentController@create') }}"
    class="btn btn-primary add-new-btn"
>
    Add New
</a>
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#list" aria-controls="list" role="tab" data-toggle="tab">List</a>
    </li>
    <li role="presentation">
        <a href="#map" aria-controls="map" role="tab" data-toggle="tab">Map</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="list">
        @include('apartments.partials._list')
    </div>
    <div role="tabpanel" class="tab-pane" id="map">
        @include('apartments.partials._map')
    </div>
  </div>
</div>
@else
<h2>Create Your First Apartment</h2>
{!! Form::open(['url' => action('ApartmentController@store')]) !!}
    @include('apartments.partials._form')
{!! Form::close() !!}
@endif

@endsection
