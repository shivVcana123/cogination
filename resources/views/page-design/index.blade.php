@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Styles</h3>
                <button class="btn btn-primary">        <a style="color: white;" href="{{ route('page.create') }}">+ Style</a>
</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Page</th>
                            <th>Font Size</th>
                            <th>Font Weight</th>
                            <th>Font Allignment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pageData as $key => $page)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ ucfirst($page->category) }}</td>
                            <td>{{ $page->font_size }}</td>
                            <td>{{ $page->font_weight }}</td>
                            <td>{{ $page->text_alignment }}</td>
                            <td>
                                <a href="{{ route('page.edit',$page->id) }}"><i class="fa fa-edit"   style="color:white"></i></a>
                                <form id="delete-form-{{ $page->id }}" action="{{ route('page.destroy', $page->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-link p-0 delete-button" data-id="{{ $page->id }}">
                                        <i class="fa fa-trash"   style="color:white"></i>
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