@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Header Menu</h3>
                {{-- <button class="btn btn-primary" ><a style="color:white" href="{{ route('header.create') }}">+ Header</a></button> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr style="font-weight:800">
                            <th>#</th>
                            <th>Category</th>
                            <th>Slug</th>
                            <!-- <th>Sub Category</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($headerData as $key => $header)
                        <tr>
                            @if($header->parent_id === null)
                            <td>{{ $key + 1 }}</td>

                            <td style="font-weight: 600; font-size:14px;">{{ $header->category }}


                                @if($header->children->isNotEmpty())
                                @foreach ($header->children as $child)

                                <p style="font-size:12px; font-weight:500; margin-bottom:0px; padding-top:8px;">
                                    <i style="font-size: 7px; padding-right: 3px; " class="fa fa-circle" aria-hidden="true"></i> {{ $child->category ?? '' }}
                                </p>
                                @endforeach
                                @endif
                            </td>

                            @if($header->link == '/')
                            <td style="font-weight: 600; font-size:14px;">http://localhost:5173/</td>

                            @else
                            <td style="font-weight: 600; font-size:14px;">{{ $header->link }}

                                @if($header->children->isNotEmpty())
                                @foreach ($header->children as $child)
                                <p style="font-size:13px; font-weight:500; margin-bottom:0px; padding-top:8px;">
                                    <i style="font-size: 7px; padding-right: 3px; " class="fa fa-circle" aria-hidden="true"></i> {{ $child->link ?? '' }}
                                </p>
                                @endforeach
                                @endif

                            </td>
                            @endif
                            <!-- <td>
                                    @if($header->children->isNotEmpty())
                                        @foreach ($header->children as $child)
                                        <button class="btn btn-info">{{ $child->category ?? '' }}</button>
                                        @endforeach
                                    @endif
                                </td> -->
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