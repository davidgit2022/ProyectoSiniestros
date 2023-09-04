@extends('layouts.app')

@section('vendor-style')
    <link href="{{ asset('datatables/datatables.min.css') }}" rel="stylesheet" />
	
	<link href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}"  />
	<link href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}"  />
	<link href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}"   />
	<link href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}"   />
	<link href="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}"   />
	<link href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}"   />
	 
	
    <style>
        .table {
            font-size: 12px;
        }

        .table tbody td {
            font-size: 12px;
        }

        #sinSalida thead th {
            font-size: 12px;
        }

        #sinSalida_filter input {
            font-size: 12px;
        }

        #sinSalida_paginate .paginate_button {
            font-size: 12px;
        }
    </style>
@endsection

@section('content')
 

    <div class="row" style="font-size: 14px">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5>Entrega de Vehiculos</h5>
                        </div>
                        <div class="row">
							<!-- Range Picker-->
							<div class="col-md-6 col-12 mb-4">
							  <label for="flatpickr-range" class="form-label">Range Picker</label>
							  <input
								type="text"
								class="form-control"
								placeholder="YYYY-MM-DD to YYYY-MM-DD"
								id="flatpickr-range"
							  />
							</div>
							<!-- /Range Picker-->
						 
						</div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table" id="sinSalida">
                                    <thead>
                                        <tr>
                                            <th>Perito Asignado</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Revision Cambios de fechas de talleres</h5>
							 Cantidad de aplazamientos realizados por los talleres a lo largo del tiempo
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table" id="cambioFechas">
                                    <thead>
                                        <tr>
                                            <th>Taller</th>
                                            <th>Cantidad cambios F/E</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-3" style="font-size: 14px">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Revision respuesta de correos enviados</h5>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table" id="respuestas">
                                    <thead>
                                        <tr>
                                            <th>Taller</th>
                                            <th>Cant Enviados</th>
                                            <th>Cant C/R</th>
                                            <th>Cant S/R</th>
                                            <th>Avance</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>Trabajos asignados por taller - 2023</h5>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table" id="top10">
                                    <thead>
                                        <tr>
                                            <th>Taller</th>
                                            <th>Total S/.</th>
                                            <th>Cant asignados</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="{{ asset('datatables/datatables.min.js') }}"></script>
	
	<script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
	  
	
    <script>
        $(document).ready(function() {
            var tabla1 = $('#sinSalida').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: "{{ asset('datatables/Spanish.json') }}"
                },
                ajax: "{{ route('dashboard.sinSalida') }}",
                columns: [
                    {
                        data: "NOM_PERITO_ASIG"
                    },{
                        data: "cantidad"
                    }
                ],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                order: [
                    [0, 'desc']
                ]
            });

            var tabla2 = $('#cambioFechas').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: "{{ asset('datatables/Spanish.json') }}"
                },
                ajax: "{{ route('dashboard.cambiosFechas') }}",
                columns: [{
                        data: "taller"
                    },
                    {
                        data: "cantidad"
                    }
                ],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                order: [
                    [1, 'desc']
                ]
            });

            var tabla3 = $('#top10').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: "{{ asset('datatables/Spanish.json') }}"
                },
                ajax: "{{ route('dashboard.top10') }}",
                columns: [{
                    data: "taller"
                },
                {
                    data: "total"
                },
                {
                    data: "cantidad"
                }],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                paging: false, // Esta opción quita la paginación
                order: [
                    [2, 'desc']
                ]
            });

            var tabla4 = $('#respuestas').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: "{{ asset('datatables/Spanish.json') }}"
                },
                ajax: "{{ route('dashboard.avanceRespuesta') }}",
                columns: [
                    { data: "taller" },
                    { data: "cantidad_enviados" },
                    { data: "cantidad_respondidos" },
                    { data: "cantidad_sin_responder" },
                    {
                        data: "avance",
                        render: function(data) {
                            var porcentaje = parseFloat(data);
                            var color = getColorPorcentaje(porcentaje);
                            var textColor = porcentaje === 0 ? 'white' : 'white';
                            return '<div style="background: ' + color + '; color: ' + textColor + ';">' + data + '%</div>';
                        }
                    }
                ],
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                order: [
                    [1, 'desc']
                ]
            });
        });

        function getColorPorcentaje(porcentaje) {
            var rojo = 255;
            var verde = 255;
            var rojoFinal = Math.round(rojo * (100 - porcentaje) / 100);
            var verdeFinal = Math.round(verde * porcentaje / 100);
            if (porcentaje === 0) {
                return 'green';
            } else {
                return 'rgba(' + rojoFinal + ',' + verdeFinal + ',0,1)';
            }
        }
    </script>
@endsection
