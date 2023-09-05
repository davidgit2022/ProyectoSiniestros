@extends('layouts.app')

@section('title', 'Respuestas talleres')

@section('vendor-style')
    <link href="{{ asset('datatables/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Siniestros Cargados</span>
    </h4>

    <div class="card">
        <div class="card-body">

            <div class="row mb-2">
                <div class="col-lg-3">
                    <label>Taller:</label>
                    <select class="form-control" name="taller" id="taller">
                        <option value="">Seleccionar</option>
                        @foreach ($workshops as $workshop)
                            <option value="{{ $workshop->name }}">{{ $workshop->name }}</option>
                        @endforeach
                    </select>
                </div>
                @role('Admin')
                    <div class="col-lg-3">
                        <label>Perito:</label>
                        <select class="form-control" name="perito" id="perito">
                            <option value="">Seleccionar</option>
                            @foreach ($peritos as $perito)
                                <option value="{{ $perito->full_name }}">{{ $perito->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endrole
                <div class="col-lg-2">
                    <label>Siniestro:</label>
                    <input type="text" class="form-control" name="siniestro" id="siniestro">
                </div>
                <div class="col-lg-2">
                    <label>Placa:</label>
                    <input type="text" class="form-control" name="placa" id="placa">
                </div>
                <div class="col-lg-2">
                    <label>Fecha Entrega:</label>
                    <input type="date" class="form-control" name="fec_entresga_est" id="fec_entresga_est">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-3">
                    <a href="{{ route('admin.respuestas.export') }}" class="btn btn-success">Descargar</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-3">
                    <table class="table" id="tabla-siniestros">
                        <thead>
                            <tr>
                                <th>fEC CARGA</th>
                                <th>Siniestro</th>
                                <th>Placa</th>
                                <th>Perito</th>
                                <th>Taller</th>
                                <th>Fecha entrega estimada</th>
                                <th>CLIENTE</th>
                                <th class="no-export">Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.siniestros.modals.updateDate')
    @include('admin.siniestros.modals.show')
@endsection

@section('page-script')
    <script src="{{ asset('datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#taller').select2({
                placeholder: "Seleccionar taller",
                allowClear: true
            });


            $('#perito').select2({
                placeholder: "Seleccionar perito",
                allowClear: true
            });

            var tabla = $('#tabla-siniestros').DataTable({
                processing: false,
                serverSide: false,
                language: {
                    url: "{{ asset('datatables/Spanish.json') }}"
                },
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Reporte de Ordenes de Compra',
                }, ],
                ajax: "{{ route('siniestros.data') }}",
                columns: [{
                        data: "created_at"
                    },
                    {
                        data: "NUM_SINI"
                    },
                    {
                        data: "MATRICULA"
                    },
                    {
                        data: "NOM_PERITO_ASIG"
                    },
                    {
                        data: "DSC_TERCERO"
                    },
                    {
                        data: "FEC_ENTREGA_EST"
                    },
                    {
                        data: "NOMBRE"
                    },
                    {
                        data: "id",
                        render: function(data, type, row) {
                            var buttonsHtml = '';

                            buttonsHtml +=
                                '<div class="btn-group">' +
                                '<button data-id="' + data +
                                '" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
                                'Action' +
                                '</button>' +
                                '<ul class="dropdown-menu">' +
                                '<li><a class="dropdown-item" onClick="showModal(' + data +
                                ')" href="javascript:void(0)">Actualizar fecha</a></li>' +
                                '<li><a class="dropdown-item" onClick="showModal2(' + data +
                                ')" href="javascript:void(0)">Ver cambios</a></li>' +
                                '</ul>' +
                                '</div>';

                            return buttonsHtml;
                        }
                    }
                ],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10
            });


            $('input[name="filtro"], #placa, #siniestro,#taller,#perito,#fec_entresga_est').on('change keyup',
                function() {
                    var filtro = $('input[name="filtro"]:checked').val();
                    var placa = $('#placa').val();
                    var fec_entresga_est = $('#fec_entresga_est').val();
                    var siniestro = $('#siniestro').val();
                    var taller = $('#taller').val();
                    var perito = $('#perito').val();
                    var url = "{{ route('siniestros.data') }}?filtro=" + filtro + "&placa=" + placa +
                        "&fec_entresga_est=" + fec_entresga_est +
                        "&siniestro=" + siniestro + "&taller=" + taller + "&perito=" + perito;
                    tabla.ajax.url(url).load();
                });


            $('#tabla-siniestros').on('click', '.btn-recordar', function() {
                var id = $(this).data('id');
                recordarRegistro(id);
            });


            function recordarRegistro(id) {

                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: "{{ route('respuestas.recordar') }}",
                    data: {
                        id: id,
                        _token: token
                    },
                    dataType: "json",
                    success: function(response) {
                        toastr.success('El registro ha sido recordado correctamente.', 'Éxito');
                        tabla.ajax.reload();
                    },
                    error: function(error) {
                        alert('Hubo un error al intentar recordar el registro.');
                    }
                });
            }

            $('#cancelButton').on('click', function(event) {
                event.preventDefault();
                cancel();
            });

            $('#btnGuardar').on('click', function() {
                guardarDatos();
            });



        });

        function showModal(siniestroId) {
            $('#siniestroId').val(siniestroId);
            $('#theModal').modal('show');
            $('#taller_modal').select2({
                placeholder: "Seleccionar taller",
                allowClear: true
            });
        }

        function guardarDatos() {
            let formData = new FormData($('#formUpdateDate')[0]);
            let tallerId = $('#taller_modal').val();


            formData.append('taller', tallerId)
            $.ajax({
                type: 'POST',
                url: "{{ route('siniestros.crearBitacoraFecha') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#formUpdateDate')[0].reset();
                    $('.error-message').hide();
                    let oTable = $('#tabla-siniestros').DataTable();
                    oTable.ajax.reload();
                    $("#btnActualizar").attr("disabled", false);
                    $('#theModal').modal('hide');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        showErrors(errors);
                    }
                }
            });
        }



        function showModal2(siniestroId) {
            $.ajax({
                url: '/obtener-datos-bitacora/' + siniestroId,
                method: 'GET',
                success: function(data) {
                    mostrarDatos(data);
                    $('#theModal2').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }

        function mostrarDatos(data) {

            let tabla = $('#theModal2').find('table tbody');

            tabla.empty();

            data.forEach(function(bitacora) {
                let fila = '<tr>';
                fila += '<td>' + bitacora.fecha_anterior + '</td>';
                fila += '<td>' + bitacora.fecha_nueva + '</td>';
                fila += '<td>' + bitacora.fecha_confirmacion + '</td>';
                fila += '</tr>';
                tabla.append(fila);
            });

            // Abre el modal
            $('#theModal2').modal('show');
        }



        function cancel() 
        {
            $('#formUpdateDate')[0].reset();
            $('#theModal').modal('hide');
            return false;
        }
    </script>
@endsection
