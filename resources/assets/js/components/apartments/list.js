var aptList = {};
aptList.data = {
    apartments : [],
    api        : {
        index       : '/apartments',
        delete      : '',
        updateOrder : 'api/apartments/update-order',
    },
    order      : {
        update : {},
    },
    messages   : [],
};
aptList.methods = {};

/**
 * Sets the current apartment list order.
 *
 * @param  {Object}  vm  The Vue instance.
 *
 * @return                false
 */
aptList.methods.setCurrentApartmentOrder = function( vm ) {
    var listItems = document.querySelectorAll( '#apartment_list>li' );
    vm.order.update = {};

    for ( var i = 0; i < listItems.length; i++ ) {
        var listItem = listItems[ i ];
        var orderInput = listItem.getElementsByClassName( 'js-dragula-order' )[ 0 ];
        var value = parseInt( orderInput.value, 10 );
        if ( i === value ) {
            continue;
        }

        // Update the new order.
        var idInput = listItem.getElementsByClassName( 'js-dragula-id' )[ 0 ];
        vm.order.update[ idInput.value ] = i;
        orderInput.value = i;
    }

    return false;
};

/**
 * Updates the current apartment list order.
 *
 * @param  {Object}  vm  The Vue instance.
 *
 * @return                false
 */
aptList.methods.updateApartmentOrder = function( vm ) {
    aptList.methods.setCurrentApartmentOrder( vm );

    return false;
};

/**
 * Stores the current apartment list order.
 *
 * @param  {Object}  vm  The Vue instance.
 *
 * @return                false
 */
aptList.methods.storeApartmentOrder = function( vm ) {
    console.log( 'store order' );

    return false;
};

/**
 * Initializes Dragula.
 *
 * @see http://bevacqua.github.io/dragula/
 *
 * @param  {Object}  vm  The Vue instance.
 *
 * @return                false
 */
aptList.methods.initDragula = function( vm ) {
    // This is admittedly hacky, currently Vue does not have any way
    // for us to tell when the v-for has completed. For whatever
    // reason setting a zero second timeout is the solution.
    setTimeout( function() {
        var dragula = require( 'dragula' );
        dragula( [ document.getElementById( 'apartment_list' ) ], {
          moves : function( el, container, handle ) {
            var classCheck = handle.className.indexOf( 'js-dragula-handle' );
            return -1 !== classCheck;
          }
        } ).on( 'drop', function() {
            aptList.methods.updateApartmentOrder( vm );
        } );
    }, 0 );

    return false;
};

/**
 * Toggles the apartment details.
 *
 * @param   {Integer}  itemIndex  The apartment list item index to toggle on.
 *
 * @return  {Boolean}              false
 */
aptList.methods.toggleShowDetails = function( itemIndex ) {
    this.apartments.forEach( function( element, index ) {
        if ( itemIndex === index ) {
            element.showDetails = !element.showDetails;

            return;
        }

        element.showDetails = false;
    } );

    return false;
};

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
        var order = 0;

        apartments.forEach( function( element, index, array ) {
            // We need this for toggling the apartment details.
            element.showDetails = false;
        } );

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
        var vm = this;
        aptList.methods.getApartments( vm, function() {
            aptList.methods.initDragula( vm );
            done();
        } );
    }
};
