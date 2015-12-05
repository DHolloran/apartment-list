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
@include('apartments.partials._list')
@else
<h2>Create Your First Apartment</h2>
{!! Form::open(['url' => action('ApartmentController@store')]) !!}
    @include('apartments.partials._form')
{!! Form::close() !!}
@endif

@endsection
