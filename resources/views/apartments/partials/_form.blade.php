
{{-- Errors --}}
@include('common._errors')
<?php $apt = isset( $apartment ) ? $apartment : []; ?>

{{-- {!! Form::state('state') !!} --}}

{{-- Name --}}
<div class="form-group">
    {!! Form::label(
        'name',
        'Apartment Name:'
    ) !!}
    <div class="input-group col-xs-12">
        {!! Form::text(
            'name',
            isset( $apt['name'] ) ? $apt['name'] : '',
            ['class' => 'form-control ', 'required' => 'required']
        ) !!}
    </div> {{-- /.input-group --}}
</div> {{-- /.form-group --}}

{{-- Sort Order --}}
{!! Form::hidden('order',1) !!}

<div class="row">
    {{-- Address Line 1 --}}
    <div class="form-group col-sm-6 col-xs-12">
        {!! Form::label(
            'addressLine1',
            'Address Line 1:'
        ) !!}
        <div class="input-group col-xs-12">
            {!! Form::text(
                'addressLine1',
                isset( $apt['addressLine1'] ) ? $apt['addressLine1'] : '',
                ['class' => 'form-control', 'required' => 'required']
            ) !!}
        </div> {{-- /.input-group --}}
    </div> {{-- /.form-group --}}

    {{-- Address Line 2 --}}
    <div class="form-group col-sm-6 col-xs-12">
        {!! Form::label(
            'addressLine2',
            'Address Line 2:'
        ) !!}
        <div class="input-group col-xs-12">
            {!! Form::text(
                'addressLine2',
                isset( $apt['addressLine2'] ) ? $apt['addressLine2'] : '',
                ['class' => 'form-control']
            ) !!}
        </div> {{-- /.input-group --}}
    </div> {{-- /.form-group --}}

    {{-- City --}}
    <div class="form-group col-sm-4">
        {!! Form::label(
            'city',
            'City:'
        ) !!}
        <div class="input-group col-xs-12">
            {!! Form::text(
                'city',
                isset( $apt['city'] ) ? $apt['city'] : 'Saint Louis',
                ['class' => 'form-control', 'required' => 'required']
            ) !!}
        </div> {{-- /.input-group --}}
    </div> {{-- /.form-group --}}

    {{-- State --}}
    <div class="form-group col-sm-4">
        {!! Form::label(
            'state',
            'State:'
        ) !!}
        <div class="input-group col-xs-12">
            {!! Form::select(
                'state',
                ['' => 'Select A State', 'MO' => 'Missouri', 'IL' => 'Illinois'],
                isset( $apt['state'] ) ? $apt['state'] : 'MO',
                ['class' => 'form-control', 'required' => 'required']
            ) !!}
        </div> {{-- /.input-group --}}
    </div> {{-- /.form-group --}}

    {{-- Zip Code --}}
    <div class="form-group col-sm-4">
        {!! Form::label(
            'zip',
            'Zip Code:'
        ) !!}
        <div class="input-group col-xs-12">
            {!! Form::text(
                'zip',
                isset( $apt['zip'] ) ? $apt['zip'] : '',
                ['class' => 'form-control', 'required' => 'required']
            ) !!}
        </div> {{-- /.input-group --}}
    </div> {{-- /.form-group --}}
</div> {{-- /.row --}}

{{-- Notes --}}
<div Class="form-group">
    {!! Form::label(
        'notes',
        'Notes:'
    ) !!}
    <div class="input-group col-xs-12">
        {!! Form::textarea(
            'notes',
            isset( $apt['notes'] ) ? $apt['notes'] : '',
            ['class' => 'form-control', 'rows' => '10']
        ) !!}
        <p class="help-block">Github Flavored Markdown is supported.</p>
    </div> {{-- /.input-group --}}
</div> {{-- /.form-group --}}

<div class="row">

    {{-- Price --}}
    <div class="form-group col-sm-4">
        {!! Form::label(
            'price',
            'Price:'
        ) !!}
        <div class="input-group">
            <span class="input-group-addon">$</span>
            {!! Form::input(
                'number',
                'price',
                isset( $apt['price'] ) ? $apt['price'] : '0',
                ['class' => 'form-control', 'min' => 0, 'required' => 'required']
            ) !!}
            <span class="input-group-addon">/mo</span>
        </div> {{-- /.input-group --}}
    </div> {{-- /.form-group --}}

    {{-- Parking Price --}}
    <div class="form-group col-sm-4">
        {!! Form::label(
            'parkingPrice',
            'Parking Price:'
        ) !!}
        <div class="input-group">
            <span class="input-group-addon">$</span>
            {!! Form::input(
                'number',
                'parkingPrice',
                isset( $apt['parkingPrice'] ) ? $apt['parkingPrice'] : '0',
                ['class' => 'form-control', 'min' => 0, 'required' => 'required']
            ) !!}
            <span class="input-group-addon">/mo</span>
        </div> {{-- /.input-group --}}
    </div> {{-- /.form-group --}}

    {{-- Deposit --}}
    <div class="form-group col-sm-4">
        {!! Form::label(
            'deposit',
            'Deposit:'
        ) !!}
        <div class="input-group">
            <span class="input-group-addon">$</span>
            {!! Form::input(
                'number',
                'deposit',
                isset( $apt['deposit'] ) ? $apt['deposit'] : '0',
                ['class' => 'form-control', 'min' => 0, 'required' => 'required']
            ) !!}
            <span class="input-group-addon">/mo</span>
        </div> {{-- /.input-group --}}
    </div> {{-- /.form-group --}}
</div> {{-- /.row --}}

{{-- Submit --}}
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        {!! Form::submit('Submit', ['class' => 'btn btn-primary btn-lg col-xs-12']) !!}
    </div> {{-- /.col-sm-8 --}}
</div> {{-- /.row --}}
