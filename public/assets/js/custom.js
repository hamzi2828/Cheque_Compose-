let appPath = $ ( 'meta[name="app-path"]' ).attr ( 'content' );

$.ajaxSetup ( {
                  headers: {
                      'X-CSRF-TOKEN': $ ( 'meta[name="csrf-token"]' ).attr ( 'content' )
                  }
              } );

$ ( function () {
    $ ( '.flatpickr-basic' ).flatpickr ();

    if ( $.fn.select2 ) {
        $ ( '.select2' ).each ( function () {
            $ ( this ).select2 ( {
                                    dropdownParent: $ ( this ).parent (),
                                    width         : '100%'
                                } );
        } );
    }
} );

function init_datatable ( path ) {
    $ ( '#datatable' ).DataTable ( {
                                       order   : [ [ 0, 'asc' ] ],
                                       dom     :
                                           '<"row me-2"' +
                                           '<"col-md-2"<"me-3"l>>' +
                                           '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                                           '>t' +
                                           '<"row mx-2"' +
                                           '<"col-sm-12 col-md-6"i>' +
                                           '<"col-sm-12 col-md-6"p>' +
                                           '>',
                                       language: {
                                           sLengthMenu      : '_MENU_',
                                           search           : '',
                                           searchPlaceholder: 'Search..'
                                       },
                                       buttons : [
                                           {
                                               text     : '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-sm-inline-block text-white route" data-route="' + path + '">Add New</span>',
                                               className: 'add-new-redirect-link btn btn-primary text-white',
                                               action   : function () {
                                                   window.location.href = path;
                                               }
                                           }
                                       ]
                                   } );
}

function delete_confirmation ( id, formID = '' ) {
    Swal.fire ( {
                    title            : 'Are you sure?',
                    text             : "You won't be able to revert this!",
                    icon             : 'warning',
                    showCancelButton : true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass      : {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton : 'btn btn-label-secondary'
                    },
                    buttonsStyling   : false
                } ).then ( function ( result ) {
        if ( result.value ) {
            if ( formID.length > 0 )
                $ ( '#' + formID ).submit ();
            else
                $ ( '#delete-record-form-' + id ).submit ();
        }
    } );
}
