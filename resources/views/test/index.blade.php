@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" >
                <h3 class="card-title">Header</h3>
                <button class="btn btn-primary" ><a style="color:white" href="{{ route('form') }}">+ add</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Section</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($autismBook as $key => $value)
                      
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$value->first_title}}</td>
                        <td>{{$value->type}}</td>
                        <td>{{$value->created_at}}</td>
                        <td>
                          <i class="fa fa-edit"></i>
                        </td>
                      </tr>
                      @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.content -->
     <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- /.content-wrapper -->
@endsection