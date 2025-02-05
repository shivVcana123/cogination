@extends('layouts.guest')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content footer (Page footer) -->
    <div class="col-md-12">
        <div class="card">
        {{-- @if(!$banners->count()) --}}
            <div class="card-header" >
                <h3 class="card-title ctaa-cls">Banners</h3>
                <button class="btn btn-primary" ><a style="color:white" href="{{ route('banner.create') }}">+ Banner</a></button>
            </div>
            {{-- @endif --}}
            <!-- /.card-footer -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Page</th>
                            <th>Heading</th>
                            <th>Button Text</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $key => $banner)
                        <tr>
                         @if($banner->parent_id === null)
                            <td>{{ $key + 1 }}</td>
                                <td>{{ $banner->type }} 
                                    @if($banner->section_type) 
                                        ({{ $banner->section_type }})
                                    @endif
                                </td>
                           
                                <td>{{ $banner->heading }}</td>
                                <td>{{ $banner->button_text }}</td>
                                <td>
                                    <a href="{{route('banner.edit',$banner->id)}}"><i class="fa fa-edit"></i></a>
                                    <!-- <form id="delete-form-{{ $banner->id }}" action="{{ route('banner.destroy', $banner->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </form> -->
                                <form id="delete-form-{{ $banner->id }}" action="{{ route('banner.destroy', $banner->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-link p-0 delete-button" data-id="{{ $banner->id }}">
                                        <i class="fa fa-trash"   style="color:black"></i>
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