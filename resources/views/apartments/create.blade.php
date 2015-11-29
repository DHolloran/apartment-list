@extends('layouts.app')


@section('content')
<h1>Add a New Apartment</h1>

<a class="btn btn-primary" href="{{ url('/apartments') }}">&lt; Your Apartments</a>

{!! Form::open(['url' => action('ApartmentController@store')]) !!}
    @include('apartments.partials._form')
{!! Form::close() !!}

@endsection
