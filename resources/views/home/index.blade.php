@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
        
            <div class="card-header">
                <h3 class="card-title">Home</h3>
                <button class="btn btn-primary" ><a style="color:white" href="{{ route('home.create') }}">+ Home</a></button>
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
                            <td>
                                <a href="{{ route('home.edit',$home->id) }}"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('home.destroy', $home->id) }}" method="POST" style="display:inline;">
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