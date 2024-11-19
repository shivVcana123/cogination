@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">About</h3>
                <button class="btn btn-primary"><a style="color:white" href="{{ route('about.create') }}">+ About</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description 1</th>
                            <th>Description 2</th>
                            <th>Background Color</th>
                            <th>Background Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($about as $key => $abouts)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $abouts->title }}</td>
                            <td>{{ substr($abouts->description_1,0,100) }}</td>
                            <td>{{ substr($abouts->description_2, 0 ,100) }}</td>
                            <td>{{ $abouts->background_color }}</td>
                            <td>{{ $abouts->background_image }}</td>
                            <td>
                                <a href="{{ route('about.edit',$abouts->id) }}"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('about.destroy', $abouts->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </form>
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