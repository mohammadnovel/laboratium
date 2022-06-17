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
                                <a href="{{ route($module . '.index') }}" class="btn btn-danger btn-lg"><i
                                        class="m-r-10 mdi mdi-backspace"></i>Back</a>
                            </div>
                        </div>
                        <hr>
                        <div class="form">
                            {!! form_start($form, ['enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        Silahkan pilih salah satu daripada Group dan Number untuk No Whatsapp tujuan
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {!! form_row($form->session_id) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! form_row($form->group_id) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! form_row($form->text) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! form_row($form->phones) !!}
                                </div>
                                <div class="col-md-12">
                                    {!! form_row($form->file) !!}
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
