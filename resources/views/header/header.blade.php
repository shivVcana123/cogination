@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Header</h3>
                <button class="btn btn-primary" ><a style="color:white" href="{{ route('addheader') }}">+ Header</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($headerData as $key => $home)
                        <tr>
                         @if($home->parent_id === null)
                            <td>{{ $key + 1 }}</td>
                           
                                <td>{{ $home->category }}</td>
                                <td>
                                    @if($home->children->isNotEmpty())
                                        @foreach ($home->children as $child)
                                        <button class="btn btn-info">{{ $child->category ?? '' }}</button>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <i class="fa fa-edit"></i>
                                    <i class="fa fa-trash"></i>
                                </td>
                             @endif

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