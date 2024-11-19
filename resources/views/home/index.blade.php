@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Home</h3>
                <button class="btn btn-primary" style="margin-left: 82%;" ><a style="color:white" href="{{ route('homes.create') }}">+ Home</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                             <th>Button Content</th>
                             <th>Button Link</th>
                            <th>Background Color</th>
                            <th>Background Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($homeData as $key => $home)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $home->title }}</td>
                            <td>{{ $home->subtitle }}</td>
                            <td>{{ $home->button_content }}</td>
                            <td>{{ $home->button_link }}</td>
                            <td>{{ $home->background_color }}</td>
                            <td>{{ $home->background_image }}</td>
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