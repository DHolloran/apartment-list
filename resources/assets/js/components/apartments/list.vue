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
<ul id="apartment_list" class="list-group">
    <li
        class="list-group-item"
        v-for="apartment in apartments"
    >
        <h4
            class="apartment-list"
            @click="toggleShowDetails($index)"
        >
            {{ apartment.name }}
        </h4>
        {{ apartment.id }}
        <input type="hidden" class="js-dragula-order" value="{{ apartment.order }}">
        <input type="hidden" class="js-dragula-id" value="{{ apartment.id }}">
        <a href="/apartments/{{ apartment.id }}/edit" class="btn btn-link">Edit</a>
        <form
            method="POST"
            action="/apartments/{{ apartment.id }}"
            accept-charset="UTF-8"
            @submit.prevent='deleteApartment($index)'
        >
            <input name="_method" type="hidden" value="DELETE">
            <input name="_token" type="hidden" value="{{ token }}">
            <button type="submit" class="btn btn-danger btn-link">Delete</button>
        </form>
        <span class="btn btn-list js-dragula-handle">Handle</span>
        <ul class="list-unstyled" v-show="apartment.showDetails">
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
    </li>
</ul>

</template>

<script>
module.exports = require('./list.js');
</script>
