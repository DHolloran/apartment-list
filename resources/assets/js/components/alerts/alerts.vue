<style lang="sass">
@import 'resources/assets/sass/common';
@import 'resources/assets/js/components/alerts/alert';
</style>

<template>
    <ul class="list-unstyled" v-for="message in alertMessages">
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
</template>

<script>
module.exports = require('./alerts.js');
</script>
