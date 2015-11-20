(function() {
    'use strict';

    // Require helpers.
    require( './helpers.js' );

    // Require view.
    var Vue = require( 'vue' );
    Vue.use( require( 'vue-resource' ) );

    // Setup list item values.
    var newListItem = {
      name         : 'Apartment Name',
      addressLine1 : '123 Some Rd.',
      addressLine2 : 'Apt 12',
      city         : 'Saint Louis',
      state        : 'Missouri',
      zip          : '63103',
      notes        : 'Some notes',
      price        : '0.00',
      parkingPrice : '0.00',
      deposit      : '500.00',
    };

    // Setup Vue values.
    var methods = {};
    var computed = {};
    var data = {
      submitLabel       : 'Submit',
      validation        : { error : false, },
      errors            : {
        messages : { validation : [], request : [], },
      },
      editListItemIndex : -1,
      newListItem       : newListItem,
      apartmentsList    : [],
      baseURL           : 'apartments',
    };

    /**
     * Retrieves all list items.
     *
     * @return  {Boolean}  False
     */
    methods.getListItems = function() {
        this.$http.get( this.baseURL, function( data, status, request ) {
            // Make sure nothing went wrong
            if ( 200 !== status || !request.ok ) {
                return false;
            }

            // Load the apartments list.
            this.apartmentsList = data.reverse();
        } );
        return false;
    };

    /**
     * Computes all error messages for display.
     *
     * @return  {Array}  The computes error messages.
     */
    computed.errorMessages = function() {
      var messages = [];
      for ( var index in this.errors.messages ) {
        messages = messages.concat( this.errors.messages[ index ] );
      }

     // for()

      return messages;
    };

    /**
     * Edit list item via API.
     *
     * @param   {Object}  instance  Current Vue instance.
     *
     * @return  {Boolean}            False
     */
    methods.apiEditListItem = function( instance ) {
        // Set the create data for list item.
        var editData = instance.newListItem;
        editData._token = instance.apiGetCSRFToken();
        var apiURL = instance.baseURL + '/' + editData.id;

        instance.$http.patch( apiURL, editData, function( data, status, request ) {
            // Make sure nothing went wrong
            if ( 200 !== status || !request.ok || typeof data.id === 'undefined' ) {
                return false;
            }

            // Add the list item.
            instance.apartmentsList.unshift( data );
        } );

        return false;
    };

    /**
     * Edits an apartment list item.
     *
     * @param  {Object}  instance  The Vue instance.
     *
     * @return  {Boolean}           True if list item is edited successfully and false on error.
     */
    methods.editListItem = function( instance ) {
        // Update the apartments list.
        var index = instance.editListItemIndex;
        instance.apartmentsList[ index ] = instance.newListItem;
        instance.editListItemIndex = -1;

        // Update the DB.
        instance.apiEditListItem( instance );

        // Reset the list item.
        instance.newListItem = newListItem;

        // Reset the submit label.
        instance.submitLabel = 'Submit';

        return true;
    };

    /**
     * Retrieves the API CSRF token.
     *
     * @return  {String}  The API CSRF token.
     */
    methods.apiGetCSRFToken = function() {
        var token = document.getElementsByName( '_token' )[ 0 ].value;

        return token;
    };

    /**
     * Create list item via API.
     *
     * @param   {Object}  instance  Current Vue instance.
     *
     * @return  {Boolean}            False
     */
    methods.apiCreateListItem = function( instance ) {
        // Set the create data for list item.
        var createData = instance.newListItem;
        createData._token = instance.apiGetCSRFToken();

        instance.$http.post( instance.baseURL, createData, function( data, status, request ) {
            // Make sure nothing went wrong
            if ( 200 !== status || !request.ok || typeof data.id === 'undefined' ) {
                return false;
            }

            // Add the list item.
            instance.apartmentsList.unshift( data );
        } );

        return false;
    };

    /**
     * Creates an apartment list item.
     *
     * @return  {Boolean} True if list item is created successfully and false on error.
     */
    methods.createListItem = function() {
        // Update the list item if needed.
        if ( -1 !== this.editListItemIndex ) {
            return methods.editListItem( this );
        }

        // Reset the list item.
        this.newListItem = newListItem;

        // Update the DB.
        methods.apiCreateListItem( this );

        return true;
    };

    /**
     * Deletes an apartment list item.
     *
     * @param   {Integer}  index  The current list index to delete.
     *
     * @return  {Boolean}          True if list item is deleted successfully and false on error.
     */
    methods.deleteListItem = function( index ) {
        var apartment = this.apartmentsList[ index ];
        var name = apartment.name.replace( /(<([^>]+)>)/ig, '' );
        var confirmation = confirm( 'Are you sure you want to delete ' + name + '?' );
        if ( !confirmation ) {
            return false;
        }

        var deleteData = {};
        deleteData._token = this.apiGetCSRFToken();
        var apiURL = this.baseURL + '/' + apartment.id;
        this.$http.delete( apiURL, deleteData, function( data, status, request ) {
            // Make sure nothing went wrong
            if ( 200 !== status || !request.ok || data !== 1 ) {
                return false;
            }

            // Remove the list item.
            this.apartmentsList.splice( index, 1 );
        } );

        return true;
    };

    /**
     * Edits an apartment list item.
     *
     * @param   {Integer}  index  The current list index to edit.
     *
     * @return  {Boolean}          True if list item is edited successfully and false on error.
     */
    methods.updateListItem = function( index ) {
      this.newListItem = this.apartmentsList[ index ];
      this.editListItemIndex = index;
      this.submitLabel = 'Update';

      return true;
    };

    new Vue ( {
      el       : '#app',
      data     : data,
      methods  : methods,
      computed : computed,
      ready    : function() {
        this.getListItems();
      },
    } );
})();
