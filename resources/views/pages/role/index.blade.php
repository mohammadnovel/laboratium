@extends('layouts.app')
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
                            @can('role.create')
                                <div class="col-md-4" align="right">
                                    <a href="{{ route($route . '.create') }}" class="btn btn-success btn-lg"><i
                                            class="fa fa-plus"></i> Create New</a>
                                </div>
                            @endcan
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Permission</th>
                                        <th>Action</th>
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
@stop
@push('js')
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route($route . '.index') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'permission',
                        name: 'permission'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        "searchable": false
                    }
                ]
            });
        });
    </script>
@endpush
