@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Service</h3>
                <button class="btn btn-primary" ><a style="color:white" href="{{ route('service.create') }}">+ Service</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Service Type</th>
                             <th>Button Content</th>
                            <th>Background Color</th>
                             <th>Button Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $key => $service)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->subtitle }}</td>
                            <td>{{ $service->service_type }}</td>
                            <td>{{ $service->button_content }}</td>
                            <td>{{ $service->background_color }}</td>
                            <td>{{ $service->button_link }}</td>
                            <td>
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash"></i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection