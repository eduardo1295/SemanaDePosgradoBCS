var SITEURL = "{{URL::to('/')}}";
var checkCoord = 'activos';
var selectIDIns= "";
$(document).ready(function () {
    
    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "busqueda",
        "sLengthSelect": ""
    });


    var table = $('#alumnosdt').DataTable({
        pageLength: 5,
        lengthMenu: [[5, 10, 20, 100], [5, 10, 20, 100]],
        responsive: true,
        autoWidth: false,
        "language": {
            "url": turaIdioma
        },
        "processing": true,
        "serverSide": true,
        "search": true,
        "ajax": {
            "url": rutaListAlumnos,
            "data": function (d) {
                d.busqueda = checkCoord
            }
        },
        "columns": [
            { data: 'id', name: 'id', 'visible': false,searchable: false },
            {data: 'num_control', name: 'num_control', searchable: true, orderable: true},
            { data: 'nombre', searchable: true },
            { data: 'primer_apellido', searchable: true },
            { data: 'segundo_apellido', searchable: true },
            //{ data: 'email', searchable: true },
            {
                data: 'url',
                name: 'url',
                
                render: function (data, type, full, meta) {
                    
                    if (data == null)
                        return 'Sin entrega';
                    else
                        //return "<a style='cursor:pointer' target='_blank' href=/documentos/trabajos/"+data + "> Ver Trabajo <a/>";
                        return "<a style='cursor:pointer' class='btn btn-outline-info btn-sm'  href=" + rutaBase + "/" + full.id+"> Ver Trabajo <a/>";
                },
                orderable: false, searchable: false
            },
            {
                data: 'autorizado',
                name: 'autorizado',
                render: function (data, type, full, meta) {
                    if (data == 0)
                        return '<label class="btn btn-danger btn-sm w-100">No aprobado</label>';
                    else if( data == 1 )
                        return '<label class="btn btn-success btn-sm w-100">Aprobado</label>';
                    else
                        return '<label class="btn btn-warning btn-sm w-100">Sin entregar</label>';
                },
                searchable: true 
            },
            {
                data: 'revisado',
                name: 'revisado',
                render: function (data, type, full, meta) {
                    if (data == 0)
                        return '<label class="btn btn-danger btn-sm w-100">No Revisado</label>';
                    else if( data == 1 )
                        return '<label class="btn btn-success btn-sm w-100">Revisado</label>';
                    else
                        return '<label class="btn btn-warning btn-sm w-100">Sin entregar</label>';
                },
                searchable: true
            },
        ],
        columnDefs: [
            { responsivePriority: 1, targets: 2 },
            { className: "font-weight-bold text-info", targets: 1 },
            { responsivePriority: 2, targets: 7 },
        ]
    });






});