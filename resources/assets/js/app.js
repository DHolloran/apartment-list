( function() {
    'use strict';

    var _ = require('lodash');

    // Setup Vue configuration.
    var Vue = require( 'vue' );
    var data = {
        messages : []
    };
    var methods = {};
    var components = {
        apartmentList : require( './components/apartments/list/list.vue' ),
        alert         : require( './components/alert/alert.vue' ),
    };

    // Setup Vue Resource.
    Vue.use( require( 'vue-resource' ) );
    var token = document.getElementById( 'csrf_token' ).content;
    Vue.http.headers.common[ 'X-CSRF-TOKEN' ] = token;

    /**
     * Adds an alert message.
     *
     * @param  {Object}  message  The message to add.
     */
    methods.addAlertMessage = function( message ) {
        var messages = this.messages;
        messages.push( message );
        messages = messages.reverse();
        messages = _.uniq( messages, function( m ) {
            return m.value;
        } );
        this.messages = messages.reverse();
    };

    // Initialize Vue.
    new Vue( {
        el         : '#app',
        data       : data,
        methods    : methods,
        components : components,
        events     : {
            'add-alert-message' : methods.addAlertMessage
        }
    } );
} )();
