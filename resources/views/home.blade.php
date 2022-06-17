@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-danger">
                                <i class="ti-clipboard text-white"></i>
                            </span>
                        </div>
                        <div>
                            Total Service
                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $service }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg btn-info">
                                <i class="ti-wallet text-white"></i>
                            </span>
                        </div>
                        <div>
                            Total Parameter

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $parameter }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-calendar text-white"></i>
                            </span>
                        </div>
                        <div>
                            Total Patient Indification

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $patientIndification }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-warning">
                                <i class="mdi mdi-map text-white"></i>
                            </span>
                        </div>
                        <div>
                            Total Compotition

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $compotition }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
