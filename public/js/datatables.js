$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#mydatatable thead tr th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="'+title+'" />' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        });
    });

    var table = $('#mydatatable').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
        },
        lengthMenu: [[10,30,50,-1],[10,30,50,'tous les']],

    });

    // $('#mydatatable .tableHead').hide();

    $('tr[data-href]').on("click", function() {
        document.location = $(this).data('href');
    });
});
