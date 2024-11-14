@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Use full Links</h3>
                <button class="btn btn-primary" style="margin-left: 82%;"><a style="color:white" href="{{ route('usefulllinks.create') }}">Add Use full Links Section</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Link Type</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usefulllinks as $key => $home)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $home->title }}</td>
                            <td>
                                @if ($home->link_type === 1)
                                <span>Department Of Veterans Affairs (VA)</span>
                                @else
                                <span>General Services Administration (GSA)</span>
                                @endif
                            </td>
                            @php
                            $links = $array = json_decode($home->pointers, true);
                            @endphp
                            <td>
                                @foreach ($links as $link)
                                <button class="btn btn-info">{{ $link }}</button>
                                @endforeach
                            </td>

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