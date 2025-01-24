@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Subscribe Emails</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribeNewsletter as $key => $home)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $home->email }}</td>
                    
                            <!-- <td>
                                <a href="{{ route('home.edit',$home->id) }}"><i class="fa fa-edit"></i></a>
                                <form id="delete-form-{{ $home->id }}" action="{{ route('home.destroy', $home->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-link p-0 delete-button" data-id="{{ $home->id }}">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </form>

                            </td> -->
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