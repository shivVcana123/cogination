@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Use full Links</h3>
                <button class="btn btn-primary"><a style="color:white" href="{{ route('link.create') }}">+ Links</a></button>
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
                        @foreach ($usefulllinks as $key => $linkData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $linkData->title }}</td>
                            <td>
                                @if ($linkData->link_type === 1)
                                <span>Department Of Veterans Affairs (VA)</span>
                                @else
                                <span>General Services Administration (GSA)</span>
                                @endif
                            </td>
                            @php
                            $links = $array = json_decode($linkData->pointers, true);
                            @endphp
                            <td>
                                @foreach ($links as $link)
                                <button class="btn btn-info">{{ $link }}</button>
                                @endforeach
                            </td>

                            <td>
                                <a href="{{route('link.edit',$linkData->id)}}"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('link.destroy', $linkData->id) }}" method="POST" style="display:inline;">
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