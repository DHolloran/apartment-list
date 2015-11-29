
@extends('layouts.app')


@section('content')
<h1>Edit An Apartment</h1>

<a class="btn btn-primary" href="{{ url('/apartments') }}">&lt; Your Apartments</a>
{!! Form::open(['url' => action('ApartmentController@update', ['id' => $apartment['id']])]) !!}
    {!! Form::hidden('_method', 'PATCH') !!}

    @include('apartments.partials._form')
{!! Form::close() !!}

@endsection
