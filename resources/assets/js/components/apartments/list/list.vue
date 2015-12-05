<style lang="sass">
@import 'resources/assets/sass/common';
@import 'resources/assets/js/components/apartments/list/list';
</style>

<template>
<ul id="apartment_list" class="apartment-list">
    <li v-for="apartment in apartments">
        <h4
            class="apartment-list-title"
            @click="toggleShowDetails($index)"
        >
            {{ apartment.name }}
        </h4>
        <ul class="apartment-list-menu">
            <li>
                <a
                    href="/apartments/{{ apartment.id }}/edit"
                    class="apartment-edit-btn icon-pencil"
                    title="Edit {{ apartment.name }}"
                >
                    Edit
                </a>
            </li>
            <li>
                <form
                    method="POST"
                    action="/apartments/{{ apartment.id }}"
                    accept-charset="UTF-8"
                    @submit.prevent='deleteApartment($index)'
                    class="apartment-list-delete-form"
                >
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="{{ token }}">
                    <button
                        type="submit"
                        class="apartment-delete-btn icon-bin2"
                        title="Edit {{ apartment.name }}"
                    >
                        Delete
                    </button>
                </form>
            </li>
            <li>
                <span class="js-dragula-handle icon-menu2 sort-handle"></span>
                <input type="hidden" class="js-dragula-order" value="{{ apartment.order }}">
                <input type="hidden" class="js-dragula-id" value="{{ apartment.id }}">
            </li>
        </ul>
        <ul class="apartment-details" v-show="apartment.showDetails">
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
                {{{ apartment.notes }}}
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
