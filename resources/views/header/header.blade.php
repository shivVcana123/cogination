@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Home Section</h3>
                <button class="btn btn-primary" style="margin-left: 82%;">Add Section</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Sub Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($headerData as $key => $home)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $home->title }}</td>
                            <td>
                                @if($home->children->isNotEmpty())
                                    @foreach ($home->children as $child)
                                    <button class="btn btn-info">{{ $child->sub_title ?? '' }}</button>
                                    @endforeach
                                @endif
                            </td>
                            <td>Action</td>
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