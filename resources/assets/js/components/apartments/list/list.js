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
aptList.methods.setCurrentApartmentOrder = ( vm, callback )=> {
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
        vm.order.update[ idInput.value ] = {
            order : i,
            id    : idInput.value
        };
        orderInput.value = i;
    }

    if ( typeof callback === 'function' ) {
        callback();
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
    aptList.methods.setCurrentApartmentOrder( vm, function() {
        aptList.methods.storeApartmentOrder( vm );
    } );

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
    vm.$http.put( vm.api.updateOrder, vm.order.update, function() {
    } ).error( function( data, status ) {
        var message = 'Something went wrong please try again. (Error: ' + status + ')';
        this.dispatchAlertMessage( message, 'danger' );
    } );

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
 * Set an alert message.
 *
 * @param  {String}  value    The message value to be set.
 * @param  {String}  status   Optional, alert status value. Possible values success, info, warning, or danger. Default info.
 * @param  {Integer} timeout  Optional, the timeout duration in milliseconds timeout <= 0 it will be disabled. Default 4000 (4 seconds).
 */
aptList.methods.dispatchAlertMessage = function( value, status, timeout ) {
    this.$dispatch('add-alert-message', { value, status, timeout });

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

        this.dispatchAlertMessage( name + ' has been permanently deleted!', 'success' );
    } ).error( function( data, status, request ) {
        var message = 'Something went wrong please try again. (Error: ' + status + ')';
        this.dispatchAlertMessage( message, 'danger', 0 );
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
        var message = 'You apartments could not be loaded please refresh the page. (Error: ' + status + ')';
        this.dispatchAlertMessage( message, 'danger', 0 );

        if ( typeof callback === 'function' ) {
            callback();
        }
    } );

    return false;
};

module.exports = {
    data() {
        var data = aptList.data;
        data.api.delete = this.$resource( data.api.index + '/:id' );
        data.token = this.$http.headers.common[ 'X-CSRF-TOKEN' ];

        return data;
    },
    methods  : aptList.methods,
    activate( done ) {
        var vm = this;
        aptList.methods.getApartments( vm, function() {
            aptList.methods.initDragula( vm );
            done();
        } );
    }
};
