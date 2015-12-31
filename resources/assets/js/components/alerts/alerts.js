var alerts = {};
alerts.data = {};
alerts.methods = {};
alerts.props = ['messages'];
alerts.computed = {
    alertMessages : {
        get() {
            return this.messages;
        },
        set() {
            this.setAlertMessagesTimeout( this );
            this.alertMessages = this.messages;
        }
    }
};

/**
 * Removes an alerts message.
 *
 * @param   {Integer}  index  The index of the message to remove.
 *
 * @return  {Boolean}         false
 */
alerts.methods.removeAlertMessage = function( index ) {
    if ( typeof this.messages[ index ] !== 'undefined' ) {
        clearTimeout( this.messages[ index ].timeoutRef );
    }

    this.messages.splice( index, 1 );

    return false;
};

/**
 * Set an alerts message.
 *
 * @param  {Object} vm The current Vue model instance.
 *
 * @return             false
 */
alerts.methods.setAlertMessagesTimeout = function(vm) {
    vm.messages.forEach( function( element, index ) {
        var message = vm.messages[ index ];
        var timeout = typeof message.timeout === 'undefined' ? 4000 : message.timeout;
        if (  timeout <= 0 || typeof message.timeoutRef !== 'undefined' ) {
            return;
        }

        // We need to reference the timeout later to remove it.
        vm.messages[ index ].timeoutRef = setTimeout( function() {
            vm.removeAlertMessage( index );
        }, timeout );
    });

    return false;
};

module.exports = {
    data() { return alerts.data; },
    methods : alerts.methods,
    props   : alerts.props,
    computed : alerts.computed
};
