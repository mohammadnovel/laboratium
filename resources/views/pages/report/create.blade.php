@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title">{{ module_title($module) }}</h4>
                                <h6 class="card-subtitle">Manage {{ module_title($module) }}</h6>
                            </div>
                            <div class="col-md-4" align="right">
                                <a href="{{ route($route . '.index') }}" class="btn btn-danger btn-lg"><i
                                        class="m-r-10 mdi mdi-backspace"></i>Back</a>
                            </div>
                        </div>
                        <hr>
                        <div class="form">
                            {!! form_start($form, ['id' => 'check-rate-form', 'class' => 'm-t-40']) !!}
                            {!! form_row($form->from_date) !!}
                            {!! form_row($form->to_date) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- service --}}
                                    <div class="form-group">
                                        <table class="table table-bordered" id="datatable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="47%">Pelayanan Lab (Service)</th>
                                                    <th width="47%">Qty</th>
                                                    <th width="6%">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="dynamic_field">
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @if (!empty($data) && count(data_get($data, 'services')) > 0)
                                                    @foreach ($data->services as $item)
                                                        <tr class="rowComponent">
                                                            <td>
                                                                <select name="service_id[]"
                                                                    class="form-control kt-input select2"
                                                                    id="service_id{{ $no }}">
                                                                    <option selected disabled>Pilih Pelayanan</option>
                                                                    @foreach ($services as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ isset($isEdit) && $item->service_id == $key ? 'selected' : '' }}>
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="qty_service[]" class="form-control"
                                                                    placeholder="jumlah pelayanan" value="{{ $item->qty_service }}">
                                                            </td>
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn_remove">X</button></td>
                                                        </tr>
                                                        @php
                                                            $no++;
                                                        @endphp
                                                    @endforeach
                                                @else
                                                    <tr class="rowComponent">
                                                        <td>
                                                            <select name="service_id[]" class="form-control select2"
                                                                id="service_id">
                                                                <option selected disabled>Pilih Pelayanan</option>
                                                                @foreach ($services as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="qty_service[]" class="form-control"
                                                                placeholder="jumlah pelayanan">
                                                        </td>
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn_remove">X</button></td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-right">
                                                        <button type="button" name="add" id="add"
                                                            class="btn btn-success btn-sm add-ingredient">
                                                            Tambah
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div id="result"></div>
                                    </div>

                                    {{-- parameter --}}
                                    <div class="form-group">
                                        <table class="table table-bordered" id="datatable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="47%">Pelayanan Lab Berdasarkan Parameter</th>
                                                    <th width="47%">Qty</th>
                                                    <th width="6%">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="dynamic_field_parameter">
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @if (!empty($data) && count(data_get($data, 'parameters')) > 0)
                                                    @foreach ($data->parameters as $item)
                                                        <tr class="rowComponentParameter">
                                                            <td>
                                                                <select name="parameter_id[]"
                                                                    class="form-control kt-input select2"
                                                                    id="parameter_id{{ $no }}">
                                                                    <option selected disabled>Pilih Parameter</option>
                                                                    @foreach ($parameters as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ isset($isEdit) && $item->parameter_id == $key ? 'selected' : '' }}>
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="qty_parameter[]" class="form-control"
                                                                    placeholder="jumlah pelayanan" value="{{ $item->qty_parameter }}">
                                                            </td>
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn_remove">X</button></td>
                                                        </tr>
                                                        @php
                                                            $no++;
                                                        @endphp
                                                    @endforeach
                                                @else
                                                    <tr class="rowComponentParameter">
                                                        <td>
                                                            <select name="parameter_id[]" class="form-control select2"
                                                                id="parameter_id">
                                                                <option selected disabled>Pilih Parameter</option>
                                                                @foreach ($parameters as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="qty_parameter[]" class="form-control"
                                                                placeholder="jumlah pelayanan">
                                                        </td>
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn_remove">X</button></td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-right">
                                                        <button type="button" name="add-parameter" id="add-parameter"
                                                            class="btn btn-success btn-sm add-ingredient-parameter">
                                                            Tambah
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div id="result-parameter"></div>
                                    </div>

                                    {{-- Compotition --}}
                                    <div class="form-group">
                                        <table class="table table-bordered" id="datatable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="47%">Komposisi Pasien</th>
                                                    <th width="47%">Qty</th>
                                                    <th width="6%">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="dynamic_field_compotition">
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @if (!empty($data) && count(data_get($data, 'compotitions')) > 0)
                                                    @foreach ($data->compotitions as $item)
                                                        <tr class="rowComponentCompotition">
                                                            <td>
                                                                <select name="compotition_id[]"
                                                                    class="form-control kt-input select2"
                                                                    id="compotition_id{{ $no }}">
                                                                    <option selected disabled>Pilih Komposisi Pasien</option>
                                                                    @foreach ($compotitions as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ isset($isEdit) && $item->compotition_id == $key ? 'selected' : '' }}>
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="qty_compotition[]" class="form-control"
                                                                    placeholder="jumlah komposisi" value="{{ $item->qty_compotition }}">
                                                            </td>
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn_remove">X</button></td>
                                                        </tr>
                                                        @php
                                                            $no++;
                                                        @endphp
                                                    @endforeach
                                                @else
                                                    <tr class="rowComponentCompotition">
                                                        <td>
                                                            <select name="compotition_id[]" class="form-control select2"
                                                                id="compotition_id">
                                                                <option selected disabled>Pilih Komposisi</option>
                                                                @foreach ($compotitions as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="qty_compotition[]" class="form-control"
                                                                placeholder="jumlah komposisi">
                                                        </td>
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn_remove">X</button></td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-right">
                                                        <button type="button" name="add-compotition" id="add-compotition"
                                                            class="btn btn-success btn-sm add-ingredient-compotition">
                                                            Tambah
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div id="result-compotition"></div>
                                    </div>

                                    {{-- Patient Indification --}}
                                    <div class="form-group">
                                        <table class="table table-bordered" id="datatable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="47%">Identifikasi Pasien</th>
                                                    <th width="47%">Qty</th>
                                                    <th width="6%">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="dynamic_field_patient_indification">
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @if (!empty($data) && count(data_get($data, 'patient_indifications')) > 0)
                                                    @foreach ($data->patient_indifications as $item)
                                                        <tr class="rowComponentPatientIndification">
                                                            <td>
                                                                <select name="patient_indification_id[]"
                                                                    class="form-control kt-input select2"
                                                                    id="patient_indification_id{{ $no }}">
                                                                    <option selected disabled>Pilih Indifikasi Pasien</option>
                                                                    @foreach ($patient_indifications as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            {{ isset($isEdit) && $item->patient_indification_id == $key ? 'selected' : '' }}>
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="qty_patient_indification[]" class="form-control"
                                                                    placeholder="jumlah identifikasi pasien" value="{{ $item->qty_patient_indification }}">
                                                            </td>
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn_remove">X</button></td>
                                                        </tr>
                                                        @php
                                                            $no++;
                                                        @endphp
                                                    @endforeach
                                                @else
                                                    <tr class="rowComponentPatientIndification">
                                                        <td>
                                                            <select name="patient_indification_id[]" class="form-control select2"
                                                                id="patient_indification_id">
                                                                <option selected disabled>Pilih Indifikasi Pasien</option>
                                                                @foreach ($patient_indifications as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="qty_patient_indification[]" class="form-control"
                                                                placeholder="jumlah identifikasi pasien">
                                                        </td>
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn_remove">X</button></td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-right">
                                                        <button type="button" name="add-patient_indification" id="add-patient_indification"
                                                            class="btn btn-success btn-sm add-ingredient-patient_indification">
                                                            Tambah
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div id="result-patient_indification"></div>
                                    </div>
                                </div>
                            </div>
                            {!! form_end($form) !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script>
        $(document).ready(function() {
            var postURL = "<?php echo url('addmore'); ?>";
            var i = {{ !empty($data->id) ? $no : 0 }};

            $('#add').click(function() {
                i++;
                $('#dynamic_field').append(
                    `<tr class="rowComponent">
                <td>
                    <select name="service_id[]" class="form-control kt-input select2" id="service_id${i}">
                        <option selected disabled>Pilih Service</option>
                        @foreach ($services as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="qty_service[]" class="form-control" placeholder="jumlah pelayanan">
                </td>
                <td><button type="button" name="remove" class="btn btn-danger btn_remove">X</button></td>
            </tr>`
                );
                $('.select2').select2();
            });


            $(document).on('click', '.btn_remove', function() {
                $('.btn_remove').eq($('.btn_remove').index(this)).parent().parent().remove();
            });

            // add parameter
            var postURL = "<?php echo url('addmore-parameter'); ?>";
            var i = {{ !empty($data->id) ? $no : 0 }};

            $('#add-parameter').click(function() {
                i++;
                $('#dynamic_field_parameter').append(
                    `<tr class="rowComponent">
                <td>
                    <select name="parameter_id[]" class="form-control kt-input select2" id="parameter_id${i}">
                        <option selected disabled>Pilih Parameter</option>
                        @foreach ($parameters as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="qty_parameter[]" class="form-control" placeholder="jumlah pelayanan">
                </td>
                <td><button type="button" name="remove" class="btn btn-danger btn_remove">X</button></td>
            </tr>`
                );
                $('.select2').select2();
            });


            $(document).on('click', '.btn_remove_parameter', function() {
                $('.btn_remove_parameter').eq($('.btn_remove_parameter').index(this)).parent().parent().remove();
            });
            // end parameter

            // add compotition
            var postURL = "<?php echo url('addmore-compotition'); ?>";
            var i = {{ !empty($data->id) ? $no : 0 }};

            $('#add-compotition').click(function() {
                i++;
                $('#dynamic_field_compotition').append(
                    `<tr class="rowComponent">
                <td>
                    <select name="compotition_id[]" class="form-control kt-input select2" id="compotition_id${i}">
                        <option selected disabled>Pilih Komposisi Pasien</option>
                        @foreach ($compotitions as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="qty_compotition[]" class="form-control" placeholder="jumlah komposisi">
                </td>
                <td><button type="button" name="remove" class="btn btn-danger btn_remove">X</button></td>
            </tr>`
                );
                $('.select2').select2();
            });


            $(document).on('click', '.btn_remove_compotition', function() {
                $('.btn_remove_compotition').eq($('.btn_remove_compotition').index(this)).parent().parent().remove();
            });
            // end compotition

            // add patient_indification
            var postURL = "<?php echo url('addmore-patient_indification'); ?>";
            var i = {{ !empty($data->id) ? $no : 0 }};

            $('#add-patient_indification').click(function() {
                i++;
                $('#dynamic_field_patient_indification').append(
                    `<tr class="rowComponent">
                <td>
                    <select name="patient_indification_id[]" class="form-control kt-input select2" id="patient_indification_id${i}">
                        <option selected disabled>Pilih Indetifikasi Pasien</option>
                        @foreach ($patient_indifications as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="qty_patient_indification[]" class="form-control" placeholder="jumlah indifikasi pasien">
                </td>
                <td><button type="button" name="remove" class="btn btn-danger btn_remove">X</button></td>
            </tr>`
                );
                $('.select2').select2();
            });


            $(document).on('click', '.btn_remove_patient_indification', function() {
                $('.btn_remove_patient_indification').eq($('.btn_remove_patient_indification').index(this)).parent().parent().remove();
            });
            // end patient_indification

            var postURLOverview = "<?php echo url('addmore-overview'); ?>";
            var iOverview = {{ !empty($data->id) ? $no : 0 }};

            $('#add-overview').click(function() {
                iOverview++;
                $('#dynamic_field_overview').append(
                    `<tr class="rowComponentOverview">
                <td>
                    <input type="text" name="title_overview[]" class="form-control" placeholder="Title" id="">
                </td>
                <td>
                    <textarea name="description_overview[]" class="form-control" placeholder="Description" cols="30" rows="3"></textarea>
                </td>
              <td><button type="button" name="remove" class="btn btn-danger btn_remove_overview">X</button></td>
            </tr>`
                );
            });


            $(document).on('click', '.btn_remove_overview', function() {
                $('.btn_remove_overview').eq($('.btn_remove_overview').index(this)).parent().parent()
                    .remove();
            });
        });
    </script>
@endpush
