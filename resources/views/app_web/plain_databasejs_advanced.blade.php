@php
    /**
     * @author Victor J. 
     * @desc This template include CRUD for BackPack
     * @return void
     */
@endphp
@extends(backpack_view('template.setup.setup_datatablejs'))

@php
$defaultBreadcrumbs = [
trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
$crud->entity_name_plural => url($crud->route),
$title ?? 'Base CRUD' => false, // <===== Custom
];

// if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
$breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@push("audfk_before_styles")
@endpush

@push("audfk_after_styles")
<style>
.card-header-css {
    padding: 1rem;
    margin-bottom: 0;
    background-color: rgba(0, 0, 0, .03);
    border-bottom: 1px solid rgba(0, 0, 0, .125);
}

.span-title-helper {
    font-size: 0.8rem;
    margin: 0.2rem;
    color: grey;
}

.span-button-helper {
    color: tomato;
    text-decoration-line: underline;
    cursor: pointer;
}

.select-option-disabled {
    background-color: #eee;
    color: #aaa;
    border-bottom: 2px solid #000;
}

.table-responsive-css {
    -webkit-overflow-scrolling: touch;
    overflow-x: auto;
    width: 100%;
}

@media only screen and (max-width: 780px) {
    .table-responsive-css {
        -webkit-overflow-scrolling: touch;
        overflow-x: auto;
        width: 100%;
        display: block;
    }
}

.form-check-input-css {
    width: 1.4rem;
    height: 1.4rem;
    align-items: center;
    vertical-align: middle;
}

.textarea-wrapper {
    display: block;
    min-width: 200px;
    max-width: 300px;
    white-space: pre-wrap; /* Ajusta el texto dentro del área visible */
    word-wrap: break-word; /* Permite el ajuste de palabras largas */
}

.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeeba;
}

.sticky {
    position: fixed;
    top: 0;
    left: 50%;
    width: 80%;
    transform: translateX(-50%);
    z-index: 69;
}

.sticky + .content {
    padding-top: 60px;
}
</style>
@endpush

@section('header')
<section class="container-fluid">
    <h2>
        <span>{!! ucfirst($title ?? 'Titulo') !!}</span>
        <small>{!! ucfirst($subtitle ?? 'Subtitulo') !!}</small>
        <a href="javascript:void(0);" onclick="fnReloadPage()" style="font-size:16px" >Reiniciar</a>

        @if ($crud->hasAccess('list'))
        <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
    </h2>
</section>
@endsection

@section('content')
<!-- Default box -->
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <!-- NOTA: Modifica el tamaño de la columna según sea necesario: col-md-8, col-md-12 -->
    <div class="col-md-12">
        <div class="row mb-0">
            <div class="col-sm-6">
                <div class="d-print-none with-border">
                    <!-- insert bottom using elemnt a -->
                </div>
            </div>
            <div class="col-sm-6">
                <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none"></div>
            </div>
        </div>
        <form action="#" method="_">
        <div class="card my-2 mx-3" id="header-opt-advance">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span><b>Acciones avanzadas</b></span>
                    <button type="button" role="button" id="toggleButton" class="btn btn-warning btn-sm" data-toggle="collapse" data-target="#card-acciones-avanzadas" href="#card-acciones-avanzadas" aria-expanded="false" aria-controls="card-acciones-avanzadas">
                        <li class="la la-angle-double-down"></li>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="collapse show row" id="card-acciones-avanzadas">
                    <div class="mb-3 col-12 form-group">
                        <div class="alert alert-warning" role="alert">
                            Marca por lo menos una casilla para filtrar registros o modificar los registros en la tabla.
                        </div>
                        <div class="row" id="lstCbxFiltro">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><input type="checkbox" class="form-check-input-css" name="slt-cbx-col-3" id="slt-cbx-col-3">&nbsp;<b>Sexo</b></label>
                                    <select class="form-control" id="slt-values-col-3">
                                        <option value="hombre">Hombre</option>
                                        <option value="mujer">Mujer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><input type="checkbox" class="form-check-input-css" name="slt-cbx-col-4" id="slt-cbx-col-4">&nbsp;<b>Profesión</b></label>
                                    <select class="form-control" id="slt-values-col-4">
                                        <option value="ninguno">Ninguno</option>
                                        <option value="frontend">Desarrollador FrontEnd</option>
                                        <option value="backend">Desarrollador BackEnd</option>
                                        <option value="fullstack">Desarrollador Full-Stack</option>
                                        <option value="pm">Project Manager</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><input type="checkbox" class="form-check-input-css" name="slt-cbx-col-5" id="slt-cbx-col-5">&nbsp;<b>Hobbie</b></label>
                                    <select class="form-control" id="slt-values-col-5">
                                        <option value="ninguno">Ninguno</option>
                                        <option value="codear">Programar código</option>
                                        <option value="videojuegos">Jugar videojuegos</option>
                                        <option value="peliculas">Ver películas</option>
                                        <option value="futbol">Jugar futbol</option>
                                        <option value="ejercicio">Jugar ejercicio</option>
                                        <option value="lectura">Hacer lectura</option>
                                        <option value="musica">Escuchar música</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    @include('crud::fields.slt_from_array', [ 'field' => [
                                        'type' => 'slt_from_array',
                                        'name' => 'slt-values-col-6',
                                        'label' => [
                                            'text' => 'País',
                                            'name' => 'slt-cbx-col-6',
                                        ],
                                        'options' => [
                                            'ninguno' => 'Ninguno',
                                            'andorra' => 'Andorra',
                                            'brasil' => 'Brasil',
                                            'canada' => 'Canadá',
                                            'dinamarca' => 'Dinamarca',
                                            'egipto' => 'Egipto',
                                            'francia' => 'Francia',
                                            'grecia' => 'Grecia',
                                            'haiti' => 'Haití',
                                            'india' => 'India',
                                            'japon' => 'Japón',
                                            'kenia' => 'Kenia',
                                            'luxemburgo' => 'Luxemburgo',
                                            'mexico' => 'México',
                                            'nigeria' => 'Nigeria',
                                            'oman' => 'Omán',
                                            'portugal' => 'Portugal',
                                            'qatar' => 'Qatar',
                                            'rusia' => 'Rusia',
                                            'suecia' => 'Suecia',
                                            'turquia' => 'Turquía',
                                            'uganda' => 'Uganda',
                                            'vietnam' => 'Vietnam',
                                            'yemen' => 'Yemen',
                                            'zambia' => 'Zambia',
                                        ],
                                        'allows_null' => false,
                                    ]])
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="button" role="button" class="btn btn-sm btn-secondary" id="btnAccionSeleccionarTodos">Seleccionar todos</button>
                                <button type="button" role="button" class="btn btn-sm btn-secondary" id="btnAccionAplicar">Aplicar</button>
                                <button type="button" role="button" class="btn btn-sm btn-secondary" id="btnAccionFiltrar">Filtrar</button>
                                <button type="button" role="button" class="btn btn-sm btn-secondary" id="btnAccionMostrarTodos">Mostrar todos</button>
                            </div>
                            <div>
                                <button 
                                    type="button" 
                                    role="button"
                                    id="btnGuardar" 
                                    class="btn btn-sm btn-success" 
                                    data-route="{{ route('api.templates.plain.database.advanced') }}">
                                    <span class="la la-check-circle"></span> &nbsp;Guardar
                                </button>
                                <a href="{{ url($crud->route) }}" class="btn btn-sm btn-default">
                                    <span class="la la-ban"></span> &nbsp;Cancelar
                                </a>
                            </div>
                       </div>
                        <p class="span-title-helper">
                            <span id="numeroElementoSeleccionados">0</span> elementos seleccionados.
                            <span id="btnAccionDeseleccionarTodos" class="span-button-helper" hidden>Deshacer</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <div class="my-2 mx-3">
            <table id="crudTable" ref="crudTable"
            class="bg-white table table-striped table-hover rounded shadow-xs wrap border-xs mt-2" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fil.</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th><span data-toggle="tooltip" title="Seleccione tu sexo">Sexo</span></th>
                            <th><span data-toggle="tooltip" title="Seleccione tu profesión">Profesión</span></th>
                            <th><span data-toggle="tooltip" title="Seleccione tu hobbie">Hobbie</span></th>
                            <th><span data-toggle="tooltip" title="Seleccione tu país">País</span></th>
                            <th><span data-toggle="tooltip" title="Acciones">Acciones</span></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th data-skip="on">Fil.</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Sexo</th>
                            <th>Profesión</th>
                            <th>Hobbie</th>
                            <th>País</th>
                            <th data-skip="on"></td>
                        </tr>
                        <tr>
                            <th data-skip="on">Fil.</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Sexo</th>
                            <th>Profesión</th>
                            <th>Hobbie</th>
                            <th>País</th>
                            <th>Acciones</td>
                        </tr>
                    </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('init_datatable')
<script>
    const configDataTable = {
        id: 'crudTable',
        data: @json($dataRecords),
        searching: true,
        columnDefs: [{
                targets: [0, 1],
                width: '20px'
            },
            {
                targets: [2, 3, 6],
                width: '120px'
            },
            {
                targets: [4, 5],
                width: '120px'
            },
            {
                targets: [7],
                width: '260px'
            },
        ],
        scrollX: true,
        autoWidth: false,
        columns:
        [
            {
                targets: 0,
                data: null,
                searchable: false,
                render: function(data, type, row) {
                    return `<div>
                        <input type="checkbox" style="width:15px;height:15px;" />
                    </div>`;
                }
            },
            { data: 'id', searchable: true },
            { data: 'nombre', searchable: true },
            { data: 'sexo', searchable: true },
            { data: 'profesion', searchable: true },
            { data: 'hobbie', searchable: true },
            { data: 'pais', searchable: true },
            {
                targets: -1,
                data: null,
                searchable: false,
                render: function (data, type, row) {
                    return `<div>
                        <button class="btn btn-sm btn-primary txt-white">View</button>
                        <button class="btn btn-sm btn-warning txt-white">Edit</button>
                        <button class="btn btn-sm btn-danger txt-white">Delete</button>
                    </div>`;
                    return `<select class="form-control">
                        <option disabled selected>Actions</option>
                        <option>View</option>
                        <option>Edit</option>
                        <option>Delete</option>
                    </select>`;
                }
            },
        ],
        // Configure Ajax
        /*
        processing: true,
        serverSide: true,
        ajax: {
            "url": "https://",
            "type": "POST"
        },
        */
    };

    function  myCallbackFunction(updatedCell, updatedRow, oldValue) {
        Swal.fire({
            icon: 'info',
            title: 'CellEdit DatatableJs',
            html: `¿Seguro que deseas modificar la celda?`,
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            //console.log({ updatedCell, updatedRow, oldValue, result });
            if(!result.isConfirmed){
                updatedCell.data(oldValue);
            }
        });
    }

    const configCellEdit = {
        enableCellEdit: true,
        columns: [2, 3, 4, 5, 6],
        eventClick: 'dblclick',
        onUpdate: myCallbackFunction,
        inputTypes: [
        {
            column:2,
            type: 'text',
            options: null
        },
        {
            column:3,
            type: 'list',
            options: Array.from(document.getElementById("slt-values-col-3").options).map(option => ({
                value: option.value,
                display: option.text
            })),
        },
        {
            column:4,
            type: 'list',
            options: Array.from(document.getElementById("slt-values-col-4").options).map(option => ({
                value: option.value,
                display: option.text
            })),
        },
        {
            column:5,
            type: 'list',
            options: Array.from(document.getElementById("slt-values-col-5").options).map(option => ({
                value: option.value,
                display: option.text
            })),
        },
        {
            column:6,
            type: 'list',
            options: Array.from(document.getElementById("slt-values-col-6").options).map(option => ({
                value: option.value,
                display: option.text
            })),
        },
    ]};

    audfk.crud.initDataTable(configDataTable, configCellEdit);
</script>
@endsection

@push("audfk_before_scripts")
<script>

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!   Este script es disponible antes y durante la carga de la página     !!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    function numeroDeElementosSeleccionados() {
        var cantidadCasillasMarcadas = $('#crudTable input[type="checkbox"]:checked').length;
        $('#numeroElementoSeleccionados').text(cantidadCasillasMarcadas);
        if (cantidadCasillasMarcadas > 0) {
            $('#btnAccionDeseleccionarTodos').prop('hidden', false);
        } else {
            $('#btnAccionDeseleccionarTodos').prop('hidden', true);
        }
    }

    function controlarMultiSeleccion(elemento) {
        const valor = $(elemento).prop('checked');
        if (valor) {
            $(elemento).attr('data-switch-value', 'on');
            $(elemento).prop('checked', true);
        }

        if (!valor) {
            $(elemento).attr('data-switch-value', 'off');
            $(elemento).prop('checked', false);
        }
    }

    function changeIndexes(query) {
        window.location.replace(query);
    }

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!   Este script es disponible después de carga completamente la página  !!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

$(document).ready(function () {

    var $navbar = $('#header-opt-advance');
    var sticky = $navbar.offset().top;

    $(window).scroll(function () {
        if ($(window).scrollTop() > sticky + 600) {
            $navbar.addClass('sticky');
        } else {
            $navbar.removeClass('sticky');
        }
    });

    // Add search fields in the table footer
    $('#crudTable tfoot tr td[id^="fil"]').each(function () {
        var title = $(this).text();
        $(this).html('<input type="search" class="form-control" placeholder="' + title + '" aria-controls="tableMapeo">');
    });

    // Search event by pressing the "Enter" key
    $('tfoot input').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            var indice = $(this).parent().index();
            var cadena = this.value;

            if (cadena.charAt(0) === '*' || cadena.charAt(0) === '.') {
                enterAdvancedSearch(indice, cadena);
            } else {
                resetAdvancedSearch(indice, cadena);
            }
        }
    });

    $('#crudTable tbody').on('change', 'input[type="checkbox"]', function () {
        // Get the number of selected items
        var numSeleccionados = $('#crudTable input[type="checkbox"]:checked').length;

        // Get the state of the checkbox
        const esMarcado = $(this).prop('checked');
        console.log('esMarcado', esMarcado);

        // Get the DataTable row that contains the clicked checkbox
        const fila = $(this).closest('tr');

        // Get the data from that specific row
        const datos = audfk.crud.table.row(fila).data();

        const valorMultiseleccion = $('#checkbox-switch-multiseleccion').is(':checked');
        
        numeroDeElementosSeleccionados();
    });

    $('#btnAccionAplicar').on('click', function () {
            var cantidadCasillasMarcadas = $('#crudTable input[type="checkbox"]:checked').length;
            var casillasMarcadas = $('#crudTable input[type="checkbox"]:checked');
            var filtroMarcadas = $('#lstCbxFiltro input[type="checkbox"]:checked').length;
            var lstCbxFiltro = {};

            $('#lstCbxFiltro input[type="checkbox"]').each(function () {
                lstCbxFiltro[this.id] = this.checked;
            });

            if (filtroMarcadas < 1) {
                Swal.fire({
                    title: "Plain Database Advanced",
                    text: "Marca por lo menos una casilla para modificar las columnas de la tabla. " + "\n"
                        + "Presiona el botón de aplicar para modificar cada columna de la tabla.",
                    icon: "info"
                });
                return;
            }

            casillasMarcadas.each(function () {
                // Get the row corresponding to the checkbox
                var fila_tabla = $(this).closest('tr');

                // change the level
                if (lstCbxFiltro['slt-cbx-col-3']) {
                    var nuevoNivel = $('#slt-values-col-3').val();
                    fila_tabla.find('td:eq(3)').text(nuevoNivel ? nuevoNivel : '1');
                }

                // change the nature
                if (lstCbxFiltro['slt-cbx-col-4']) {
                    var nuevoNaturaleza = $('#slt-values-col-4').val();
                    fila_tabla.find('td:eq(4)').text(nuevoNaturaleza ? nuevoNaturaleza : 'ninguno');
                }

                // Switch groups
                if (lstCbxFiltro['slt-cbx-col-5']) {
                    var nuevoGrupo = $('#slt-values-col-5').val();
                    fila_tabla.find('td:eq(5)').text(nuevoGrupo ? nuevoGrupo : 'ninguno');
                }

                // Add and select a new option in the index
                if (lstCbxFiltro['slt-cbx-col-6']) {
                    var nuevoIndice = $('#slt-values-col-6').val();
                    fila_tabla.find('td:eq(6)').text(nuevoIndice ? nuevoIndice : null);
                }
            });

            $('#reloadTableBtn').click();
            $('#btnAccionDeseleccionarTodos').click();

            Swal.fire({
                title: "Plain Database Advanced",
                html: "Se modifico " + cantidadCasillasMarcadas + " elementos en la tabla." + "<br/>"
                    + "Presiona el botón de guardar para confirmar cambios.",
                icon: "info"
            });
    });

    $('#btnAccionFiltrar').on('click', function () {
        // Get all selected checkboxes in the table
        var cantidadCasillasMarcadas = $('#lstCbxFiltro input[type="checkbox"]:checked').length;
        let lstCbxFiltro = {};

        $('#lstCbxFiltro input[type="checkbox"]').each(function () {
            lstCbxFiltro[this.id] = this.checked;
        });

        if (cantidadCasillasMarcadas < 1) {
            Swal.fire({
                title: "Plain Database Advanced",
                text: "Marca por lo menos una casilla para filtrar registros de la tabla. " + "\n"
                    + "Presiona el botón de filtrar para mostrar todos los registros nuevamente.",
                icon: "info"
            });

            // Clear all custom search functions
            $.fn.dataTable.ext.search.splice(0, $.fn.dataTable.ext.search.length);
            audfk.crud.table.draw();
            return;
        }

        // Define custom search function
        $.fn.dataTable.ext.search = [function (settings, data, dataIndex) {
            let columna_seleccionada_valor;
            let filtro_seleccionado_valor;

            if (lstCbxFiltro['slt-cbx-col-3']) {
                columna_seleccionada_valor = audfk.crud.table.cell(dataIndex, 3).nodes().to$().text();
                filtro_seleccionado_valor = $('#slt-values-col-3').val();
            } else if (lstCbxFiltro['slt-cbx-col-4']) {
                columna_seleccionada_valor = audfk.crud.table.cell(dataIndex, 4).nodes().to$().text();
                filtro_seleccionado_valor = $('#slt-values-col-4').val();
            } else if (lstCbxFiltro['slt-cbx-col-5']) {
                columna_seleccionada_valor = audfk.crud.table.cell(dataIndex, 5).nodes().to$().text();
                filtro_seleccionado_valor = $('#slt-values-col-5').val();
            } else if (lstCbxFiltro['slt-cbx-col-6']) {
                columna_seleccionada_valor = audfk.crud.table.cell(dataIndex, 6).nodes().to$().text();
                filtro_seleccionado_valor = $('#slt-values-col-6').val();
            } else {
                // Clear all custom search functions
                $.fn.dataTable.ext.search.splice(0, $.fn.dataTable.ext.search.length);
                audfk.crud.table.draw();
                return true; // Show all rows if no filters are selected
            }

            // Perform search based on selected and filter values
            let columna_seleccionada = String(columna_seleccionada_valor).trim();
            let filtro_seleccionado = String(filtro_seleccionado_valor).trim();
            
            return filtro_seleccionado.includes(columna_seleccionada);
        }];

        // Redraw the table to apply the search
        audfk.crud.table.draw();

        var cantidadElementosModificadas = audfk.crud.table.rows({ filter: 'applied' }).count();
        Swal.fire({
            title: "Plain Database Advanced",
            html: "Se filtro " + cantidadElementosModificadas + " elementos en la tabla." + "<br/>"
                + "Presiona el botón de mostrar todos para mostrar todos los registros de la tabla.",
            icon: "info"
        });
    });

    $('#btnAccionSeleccionarTodos').on('click', function () {
        // Select all checkboxes within the table
        $('#crudTable input[type="checkbox"]').prop('checked', true);
        numeroDeElementosSeleccionados();
    });

    $('#btnAccionMostrarTodos').on('click', function () {
        // Clear all custom search functions
        $.fn.dataTable.ext.search.splice(0, $.fn.dataTable.ext.search.length);
        audfk.crud.table.draw();
    });

    $('#btnGuardar').on('click', function () {
            // Show alert success
            Swal.fire({
                title: 'Guardando catálogo de cuentas',
                html: 'Por favor, espera...',
                timer: 0,
                timerProgressBar: false,
                didOpen: () => {
                    Swal.showLoading();
                    setTimeout(() => {
                        Swal.close();
                    }, 3000);
                },
                didClose: () => { },
                showConfirmButton: false,
                allowOutsideClick: false
            });

            var tableData = [];

            // Get row DataTables
            audfk.crud.table.rows().every(function (rowIdx, tableLoop, rowLoop) {
                var dato = this.data();
                var id_valor = dato.id;
                var sexo_valor = $(this.node()).find('td:eq(3)').text();
                var profesion_valor = $(this.node()).find('td:eq(4)').text();
                var hobbie_valor = $(this.node()).find('td:eq(5)').text();
                var pais_valor = $(this.node()).find('td:eq(6)').text();

                // Make sure the values are not undefined
                if (dato && sexo_valor && profesion_valor && hobbie_valor && pais_valor) {
                    dato.contable = dato.contable;
                    dato.id = id_valor;
                    dato.sexo = sexo_valor;
                    dato.profesion = profesion_valor;
                    dato.hobbie = hobbie_valor;
                    dato.pais = pais_valor;
                    tableData.push(dato);
                }
            });

            // TODO: Agregar lógica para guardado másivo
            $.ajax({
                url: $(this).data('route'),
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    '_token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                data: {
                    tableData: JSON.stringify(tableData)
                },
                success: function (response) {
                    Swal.close();
                    new Noty({
                        type: "success",
                        text: "<b>Plain Database Advanced</b><br/>Catálogo de cuentas se ha guardo correctamente."
                    }).show();
                },
                error: function (response) {
                    Swal.close();
                    new Noty({
                        type: "error",
                        text: "<b>Plain Database Advanced</b><br/>Lo siento, hubo un error al guardar el catálogo de cuentas."
                    }).show();
                }
            });
        });

    });

    $('#btnAccionDeseleccionarTodos').on('click', function () {
        // Deselects all checkboxes within the table
        $('#crudTable input[type="checkbox"]').prop('checked', false);
        numeroDeElementosSeleccionados();
    });
</script>
@endpush

@push("audfk_after_scripts")
@endpush
