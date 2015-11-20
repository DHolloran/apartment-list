<div id="app">
    @include('apartment-list._errors')

    {!! Form::open(['v-on:submit.prevent'=>'createListItem']) !!}
        {{-- Name --}}
        <div class="form-group">
            {!! Form::label('name') !!}
            {!! Form::text('name', null, [
                'value'   => '',
                'class'   => 'form-control',
                'v-model' => 'newListItem.name',
            ]) !!}
        </div>

        {{-- Address Line 1 --}}
        <div class="form-group">
            {!! Form::label('address_line_1') !!}
            {!! Form::text('address_line_1', null, [
                'value'   => '@{{ newListItem.addressLine1 }}',
                'class'   => 'form-control',
                'v-model' => 'newListItem.addressLine1',
            ]) !!}
        </div>

        {{-- Address Line 2 --}}
        <div class="form-group">
            {!! Form::label('address_line_2') !!}
            {!! Form::text('address_line_2', null, [
                'value'   => '@{{ newListItem.addressLine2 }}',
                'class'   => 'form-control',
                'v-model' => 'newListItem.addressLine2',
            ]) !!}
        </div>

        {{-- City --}}
        <div class="form-group">
        {!! Form::label('city') !!}
        {!! Form::text('city', null, [
            'value'   => '@{{ newListItem.city }}',
            'class'   => 'form-control',
            'v-model' => 'newListItem.city',
        ]) !!}
        </div>

        {{-- State --}}
        <div class="form-group">
        {!! Form::label('state') !!}
        {!! Form::text('state', null, [
            'value'   => '@{{ newListItem.state }}',
            'class'   => 'form-control',
            'v-model' => 'newListItem.state',
        ]) !!}
        </div>

        {{-- Zip Code --}}
        <div class="form-group">
        {!! Form::label('zip', 'Zip Code') !!}
        {!! Form::text('zip', null, [
            'value'   => '@{{ newListItem.zip }}',
            'class'   => 'form-control',
            'v-model' => 'newListItem.zip',
        ]) !!}
        </div>

        {{-- Price --}}
        <div class="form-group">
        {!! Form::label('price') !!}
        <div class="input-group">
            <div class="input-group-addon">$</div>
            {!! Form::input('number', 'price', null, array(
                'min'    => '0',
                'step'   => '.01',
                'value'  => '@{{ newListItem.price }}',
                'class'  => 'form-control',
                'v-model' => 'newListItem.price',
            )) !!}
            <div class="input-group-addon">/mo</div>
        </div>
        </div>

        {{-- Parking Price --}}
        <div class="form-group">
        {!! Form::label('parking_price') !!}
        <div class="input-group">
            <div class="input-group-addon">$</div>
            {!! Form::input('number', 'parking_price', null, array(
                'min'    => '0',
                'step'   => '.01',
                'value'  => '@{{ newListItem.parkingPrice }}',
                'class'  => 'form-control',
                'v-model' => 'newListItem.parkingPrice',
            )) !!}
            <div class="input-group-addon">/mo</div>
        </div>
        </div>

        {{-- Deposit --}}
        <div class="form-group">
        {!! Form::label('deposit') !!}
        <div class="input-group">
            <div class="input-group-addon">$</div>
            {!! Form::input('number', 'deposit', null, array(
                'min'    => '0',
                'step'   => '.01',
                'value'  => '@{{ newListItem.deposit }}',
                'class'  => 'form-control',
                'v-model' => 'newListItem.deposit',
            )) !!}
            <div class="input-group-addon">/mo</div>
        </div>
        </div>

        {{-- Notes --}}
        <div class="form-group">
        <label for="notes">Notes</label>
        <textarea
            name="notes"
            id="notes"
            value="@{{ newListItem.notes }}"
            class="form-control"
            rows="7"
            v-model="newListItem.notes"></textarea>
        </div>
        {!! Form::input('hidden', 'deposit', null, array(
            'value'  => '@{{ newListItem.id }}',
            'v-model' => 'newListItem.id',
        )) !!}
        <button type="submit" class="btn btn-primary btn-lg btn-block">@{{submitLabel}}</button>
    </form>
</div>
