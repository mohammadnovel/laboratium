@extends('layouts.app')
@section('js')
    {!! JsValidator::formRequest($formRequest) !!}
@stop
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title">{{ ucfirst($module) }}</h4>
                                <h6 class="card-subtitle">Manage {{ $module }}</h6>
                            </div>
                            <div class="col-md-4" align="right">
                                <a href="{{ route($route . '.index') }}" class="btn btn-danger btn-lg"><i
                                        class="m-r-10 mdi mdi-backspace"></i>Back</a>
                            </div>
                        </div>
                        <hr>
                        <div class="form">
                            {!! form_start($form, ['id' => 'test']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    {!! form_row($form->name) !!}
                                </div>
                                <div class="col-md-6">
                                    <h4>Permission</h4>
                                    @foreach ($permissions as $item)
                                        {{ Form::checkbox('permissions[]', $item->id, @$data && $data->hasPermissionTo($item->name) ? true : false) }}
                                        {{ Form::label($item->name, $item->name) }}<br>
                                    @endforeach
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
