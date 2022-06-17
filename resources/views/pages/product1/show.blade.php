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
                                <h6 class="card-subtitle">Detail {{ module_title($module) }}</h6>
                            </div>
                            <div class="col-md-4" align="right">
                                <a href="{{ route($route . '.index') }}" class="btn btn-danger btn-lg"><i
                                        class="m-r-10 mdi mdi-backspace"></i>Back</a>
                            </div>
                        </div>
                        <hr>
                        <div class="form form-horizontal">
                            @foreach ($shows as $item)
                                @if (in_array($item, ['image', 'thumbnail']))
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ ucfirst($item) }}</label>
                                        <div class="col-sm-10">
                                            <img src="{{ $detail->{$item} }}" width="50%">
                                        </div>
                                    </div>
                                @elseif(in_array($item, ['video']))
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ ucfirst($item) }}</label>
                                        <div class="col-sm-10">
                                            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element about-video elementor-element-6d3ab39c"
                                                data-id="6d3ab39c" data-element_type="column"
                                                data-settings='{"background_background":"classic"}'
                                                style="padding-top: 60px;padding-right: 20px;">
                                                <iframe width="560" height="315" src="{{ $detail->{$item} }}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Marketplace</th>
                                        <th>Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail->product_marketplaces as $item)
                                        <tr>
                                            <td>{{ data_get($item, 'marketplace.name') }}</td>
                                            <td>{{ $item->link }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
