<style>
  .red {
    color: #f00;
  }
</style>

<template>
<ul class="list-unstyled" v-for="message in messages">
    <li class="alert alert-{{ message.status }}">
        <button
            type="button"
            class="close"
            data-dismiss="alert"
            aria-label="Close"
            @click.prevent.stop="removeAlertMessage"
        >
            <span aria-hidden="true">&times;</span>
        </button>
        {{{ message.value }}}
    </li>
</ul>
<ul class="list-group">
    <li class="list-group-item" v-for="apartment in apartments">
        <h4>{{ apartment.name }}</h4>
        <ul class="list-unstyled">
            <li>
                <strong>Location</strong>
                <address>
                    {{ apartment.addressLine1 }}<br>
                    {{ apartment.addressLine2 }}<br>
                    {{ apartment.city }}, {{ apartment.state }} {{ apartment.zip }}
                </address>
            </li>
            <li>
                <strong>Notes:</strong><br>
                {{ apartment.notes }}
            </li>
            <li>
                <strong>Price:</strong> ${{ apartment.price }}
            </li>
            <li>
                <strong>Parking Price:</strong> ${{ apartment.parkingPrice }}
            </li>
            <li>
                <strong>Deposit:</strong> ${{ apartment.deposit }}
            </li>
        </ul>
        <a href="/apartments/{{ apartment.id }}/edit" class="btn btn-default">Edit</a>
        <form
            method="POST"
            action="/apartments/{{ apartment.id }}"
            accept-charset="UTF-8"
            @submit.prevent='deleteApartment($index)'
        >
            <input name="_method" type="hidden" value="DELETE">
            <input name="_token" type="hidden" value="{{ token }}">
            <button type="submit" class="btn btn-danger btn-mini">Delete</button>
        </form>
    </li>
</ul>

</template>

<script>
module.exports = require('./list.js');
</script>
