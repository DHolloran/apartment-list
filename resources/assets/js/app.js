( function() {
    'use strict';

    // Setup Vue configuration.
    var Vue = require( 'vue' );
    var data = {};
    var methods = {};
    var components = {
        'apartment-list' : require( './components/apartments/list.vue' ),
    };

    // Setup Vue Resource.
    Vue.use( require( 'vue-resource' ) );
    var token = document.getElementById( 'csrf_token' ).content;
    Vue.http.headers.common[ 'X-CSRF-TOKEN' ] = token;

    // Initialize Vue.
    new Vue( {
        el         : '#app',
        data       : data,
        methods    : methods,
        components : components,
    } );
} )();
