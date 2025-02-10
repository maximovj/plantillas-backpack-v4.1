@php
    /**
     * @author Victor J. 
     * @desc This template no include CRUD for BackPack
     * @return void
     */
@endphp
@extends(backpack_view('template.setup.setup_styles_js'))

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
    <div class="col-md-8">
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
        <form 
            onsubmit="fnOnSubmit(event, this)" 
            id="formulario-general" 
            data-route="{{ route('api.templates.plain.form.content') }}">
            <div class="card my-2">
                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-sm-12 mb-3 required">
                            <label for="field_1_val"><strong>Lorem ipsum dolor sit amet.</strong></label>
                            <input type="text" class="form-control" name="field_1_val" placeholder="Lorem ipsum dolor sit amet." required />
                        </div>
                        @include('crud::fields.select2_from_array', [ 'field' => [
                            'name' => 'field_2_val',
                            'label' => 'Lorem ipsum dolor sit amet',
                            'type' => 'select2_from_array',
                            'options' => [
                                1 => 'Lorem ipsum dolor sit amet',
                                2 => 'Lorem ipsum dolor sit amet',
                                3 => 'Lorem ipsum dolor sit amet',
                            ],
                            'allows_null' => false,
                        ]])
                        <div class="form-group col-sm-12 mb-3 required">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="field_3_val" id="columnIndiceCheck">
                                <label class="form-check-label" for="columnIndiceCheck">Lorem ipsum dolor sit amet, consectetur adipisicing elit</label>
                                <div id="passwordHelpBlock" style="color:#999;font-size:12px" class="form-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia repudiandae cumque error ea repellendus <b>doloribus excepturi</b>?
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 mb-3 required">
                            <label for="field_4_val"><strong>Lorem ipsum dolor sit amet.</strong></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="field_4_val" id="anualRadio" value="anual" checked>
                                <label class="form-check-label" for="anualRadio">
                                    <b>Lorem, ipsum.</b> Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illum dolor maiores sequi quas recusandae temporibus.
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="field_4_val" id="mensualRadio" value="mensual">
                                <label class="form-check-label" for="mensualRadio">
                                    <b>Lorem, ipsum.</b> Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quo vel laboriosam, obcaecati culpa minus dicta!
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="field_4_val" id="periodoEspecificoRadio" value="periodo_especifico">
                                <label class="form-check-label" for="periodoEspecificoRadio">
                                    <b>Lorem, ipsum.</b> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam architecto aliquid dicta magni dolor necessitatibus.
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-sm-12 mb-3 required">
                            <label><strong>Lorem ipsum dolor sit amet.</strong></label>
                            <select name="field_5_val" class="form-control">
                                <option value="0">Lorem, ipsum.</option>
                                <option value="1">Lorem, ipsum.</option>
                                <option value="2">Lorem, ipsum.</option>
                                <option value="3">Lorem, ipsum.</option>
                            </select>
                        </div>

                        <div class="col-sm-12 mb-3 p-3 required">
                            <label><strong>Seleccione una balanza de comprobación <span class="cbox-req-css"></span></strong></label>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" name="file_excel" class="custom-file-input is-invalid" accept=".xlsx, .xls" required>
                                    <label class="custom-file-label" for="customFileLang">Seleccione un archivo excel .xlsx o .xls...</label>
                                    <div class="invalid-feedback">Este archivo no tiene extensión .xlsx o .xls</div>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Balanza de comprobación</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button class="btn btn-success"><i class="la la-check-circle"></i>Guardar</button>
                <button class="btn btn-warning txt-white"><i class="la la-check-circle"></i>Actualizar</button>
                <button class="btn btn-danger"><i class="la la-check-circle"></i>Eliminar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push("audfk_before_scripts")
@endpush

@push("audfk_after_scripts")
<script>
    async function api_fetch(data_route) { 
        // Selecciona el formulario
        const form = document.querySelector('#formulario-general');

        // Crea el FormData a partir del formulario
        const formData = new FormData(form);

        // Si necesitas algún valor adicional o transformar algún dato:
        formData.set('field_3_val', form.field_3_val.checked);

        // FormData ahora contiene todos los datos del formulario automáticamente
        const formFields = [...formData.entries()];

        const fields = {};
        formData.forEach((value, key) => {
            fields[key] = value;
        });

        console.log('Mostrar los datos del formulario:',{
            form,
            formFields,
            fields,
        });

        $.ajax({
            url: data_route,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            processData: false,
            contentType: false,
            data: formData,
            success: function(res) {
                Swal.close();
                console.log(res);

                // ?? Show a success notification bubble
                new Noty({
                    type: `${res.type}`,
                    title: 'Petición',
                    text: `<strong>${res.title}</strong><br>${res.message}`
                }).show();
            },
            error: function(err) {
                Swal.close();
                //console.log({ err }, err.state());

                // ?? Show a error notification bubble
                new Noty({
                    type: 'error',
                    title: 'Petición',
                    text: `<strong>Error ${err.status}</strong><br>${err.responseJSON.message}`
                }).show();
            },
        });
    }

    async function fnOnSubmit(event, form)
    {
        event.preventDefault();
        const descripcion = "Enviando petición, por favor, espere....";
        const data_route = $(form).data('route');

        if(!data_route) {
            return;
        }

        // Show a success notification bubble
        new Noty({
            type: "success",
            title: "Petición",
            text: `<strong>Enviando petición</strong><br>${descripcion}`
        }).show();

        Swal.fire({
            title: "Petición",
            text: `${descripcion}`,
            icon: "success",
            allowOutsideClick: false,
            showConfirmButton: false,
            showCancelButton: false,
            showCloseButton: false,
            didOpen: async () => {
                /* Code here */
                Swal.showLoading();
                
                setTimeout(()=>{ Swal.close(); }, 3000);

                api_fetch(data_route);

            },
            willClose: () => {
                Swal.close();
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('.custom-file-input').on('change', function()
        {
            // Obtiene el elemento 'label' adyacente al input
            var label = $(this).next('.custom-file-label');

            try {
                // Obtiene el nombre del archivo seleccionado
                var fileName = $(this).prop('files')[0].name;
                // Obtiene la extensión del archivo
                var fileExtension = fileName.split('.').pop().toLowerCase();
                label.text(fileName);
            } catch(err) {
                // Actualiza el texto del label con el nombre del archivo seleccionado
                label.text("Seleccione un archivo excel...");
            }

            // Remover todas las clases
            $(this).removeClass('is-valid');
            $(this).removeClass('is-invalid');

            // Verifica si la extensión del archivo es .xlsx o .xls
            if (fileExtension === 'xlsx' || fileExtension === 'xls') {
                // Agrega la clase 'is-valid' al campo para aplicar estilos de validación exitosa
                $(this).addClass('is-valid');
            } else {
                // Si la extensión no es .xlsx o .xls, agrega la clase 'is-invalid' para indicar un error de validación
                $(this).addClass('is-invalid');
            }
        });
    });
</script>
@endpush
