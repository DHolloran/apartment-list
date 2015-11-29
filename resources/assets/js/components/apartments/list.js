var aptList = {};
aptList.data = {
    apartments : [],
    api        : {
        index  : '/apartments',
        delete : '',
    },
    messages   : [],
};
aptList.methods = {};

/**
 * Removes an alert message.
 *
 * @param   {Integer}  index  The index of the message to remove.
 *
 * @return  {Boolean}         false
 */
aptList.methods.removeAlertMessage = function( index ) {
    if ( typeof this.messages[ index ] !== 'undefined' ) {
        clearTimeout( this.messages[ index ] );
    }

    this.messages.splice( index, 1 );

    return false;
};

/**
 * Set an alert message.
 *
 * @param  {String}  value    The message value to be set.
 * @param  {String}  status   Optional, alert status value. Possible values success, info, warning, or danger. Default info.
 * @param  {Integer} timeout  Optional, the timeout duration in milliseconds timeout <= 0 it will be disabled. Default 4000 (4 seconds).
 */
aptList.methods.setAlertMessage = function( value, status, timeout ) {
    status = typeof status === 'undefined' ? 'info' : status;
    timeout = typeof timeout === 'undefined' ? 4000 : timeout;

    var messageIndex = this.messages.push( {
        status : status,
        value  : value,
    } );
    var index = messageIndex - 1;

    if (  timeout > 0 ) {
        var vm = this;
        this.messages[ index ].timeout = setTimeout( function() {
            vm.removeAlertMessage( index );
        }, timeout );
    }

    return false;
};

/**
 * Deletes an apartment.
 *
 * @param   {Integer}  index  The index of the apartment to delete.
 *
 * @return  {Boolean}          false
 */
aptList.methods.deleteApartment = function( index ) {
    var apartment = this.apartments[ index ];
    var name = apartment.name;
    var resource = this.api.delete;
    if ( !confirm( 'Are you sure you want to delete ' + name + '?' ) ) {
        return false;
    }

    // delete item
    resource.delete( { id : apartment.id }, function( data, status, request ) {
        this.apartments.splice( index, 1 );

        this.setAlertMessage( name + ' has been permanently deleted!', 'success' );
    } ).error( function( data, status, request ) {
        var errorMessage = 'Something went wrong please try again. (Error: ' + status + ')';
        this.setAlertMessage( errorMessage, 'danger', 0 );
    } );

    return false;
};

/**
 * Retrieve the apartments via API.
 *
 * @param   {Object}    vm        The Vue instance.
 * @param   {Function}  callback  Optional, function to execute upon completion.
 *
 * @return  {Boolean}              false
 */
aptList.methods.getApartments = function( vm, callback ) {
    vm.$http.get( vm.api.index, function( apartments, status, request ) {
        vm.$set( 'apartments', apartments );

        if ( typeof callback === 'function' ) {
            callback();
        }
    } ).error( function( data, status, request ) {
        var errorMessage = 'You apartments could not be loaded please refresh the page. (Error: ' + status + ')';
        this.setAlertMessage( errorMessage, 'danger', 0 );

        if ( typeof callback === 'function' ) {
            callback();
        }
    } );

    return false;
};

module.exports = {
    data     : function() {
        var data = aptList.data;
        data.api.delete = this.$resource( data.api.index + '/:id' );
        data.token = this.$http.headers.common[ 'X-CSRF-TOKEN' ];

        return data;
    },
    methods  : aptList.methods,
    activate : function( done ) {
        aptList.methods.getApartments( this, done );
    }
};
