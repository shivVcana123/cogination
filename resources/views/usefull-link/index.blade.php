@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Useful Links</h3>
                <button class="btn btn-primary"><a style="color:white" href="{{ route('link.create') }}">+ Links</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usefulllinks as $key => $linkData)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $linkData->title }}</td>
                            @php
                            $links = json_decode($linkData->pointers);
                            @endphp
                            <td>
                                @foreach ($links as $link)
                                <button class="btn btn-info">
                                    <p>{{$link->content}}</p>
                                    <p>{{$link->link}}</p>
                                </button>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{route('link.edit',$linkData->id)}}"><i class="fa fa-edit"></i></a>
                                <form id="delete-form-{{ $linkData->id }}" action="{{ route('link.destroy', $linkData->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-link p-0 delete-button" data-id="{{ $linkData->id }}">
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