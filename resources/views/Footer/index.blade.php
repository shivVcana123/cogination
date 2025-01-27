@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content footer (Page footer) -->
    <div class="col-md-12">
        <div class="card">
        @if(!$footerData->count())
            <div class="card-footer" >
                <h3 class="card-title">Footer</h3>
                <button class="btn btn-primary" ><a style="color:white" href="{{ route('footer.create') }}">+ Footer</a></button>
            </div>
            @endif
            <!-- /.card-footer -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Contact Info</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($footerData as $key => $footer)
                        <tr>
                         @if($footer->parent_id === null)
                            <td>{{ $key + 1 }}</td>
                           
                                <td>{{ $footer->description }}</td>
                                <td>{{ $footer->address }}</td>
                                <td>{{ $footer->email }}</td>
                                <td>{{ $footer->phone_no }}</td>
                                <td>
                                    <a href="{{route('footer.edit',$footer->id)}}"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('footer.destroy', $footer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </form>
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