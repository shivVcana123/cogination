@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" >
                <h3 class="card-title">Header</h3>
                {{-- <button class="btn btn-primary" ><a style="color:white" href="{{ route('header.create') }}">+ Header</a></button> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Link</th>
                            <th>Sub Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($headerData as $key => $header)
                        <tr>
                         @if($header->parent_id === null)
                            <td>{{ $key + 1 }}</td>
                           
                                <td>{{ $header->category }}</td>
                                <td>{{ $header->link }}</td>
                                <td>
                                    @if($header->children->isNotEmpty())
                                        @foreach ($header->children as $child)
                                        <button class="btn btn-info">{{ $child->category ?? '' }}</button>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('header.edit',$header->id)}}"><i class="fa fa-edit"></i></a>
                                    <!-- <form action="{{ route('header.destroy', $header->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </form> -->
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