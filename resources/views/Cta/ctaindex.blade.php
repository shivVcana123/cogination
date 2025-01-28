@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title ctaa-cls">CTA</h3>
                <button class="btn btn-primary ad-btn" ><a style="color:black" href="{{ route('cta.create') }}">+ ADD</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Service Type</th>
                            <th>Button Content</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cts as $key => $cta)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $cta->title }}</td>
                            <td>{{ $cta->cta_type }}</td>
                            <td>{{ ($cta->button_content)?$cta->button_content:'N/A' }}</td>
                            <td>
                                <a href="{{route('cta.edit',$cta->id)}}"><i class="fa fa-edit"   style="color:black"></i></a>
                        
                                <form id="delete-form-{{ $cta->id }}" action="{{ route('cta.destroy', $cta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-link p-0 delete-button" data-id="{{ $cta->id }}">
                                        <i class="fa fa-trash"   style="color:black"></i>
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
 <script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const recordId = this.dataset.id;
                const form = document.getElementById(`delete-form-${recordId}`);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this record!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#02476c',
                    cancelButtonColor: '#dd3333',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
 </script>
@endsection