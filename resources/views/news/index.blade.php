@extends('layouts.guest')
@section('content')
<style>
/* Tooltip container styling */
.tooltip-container {
    position: relative;
    cursor: pointer;
    color: blue;
    text-decoration: underline;
}

/* Hidden tooltip content */
.tooltip-content {
    display: none;
    position: absolute;
    top: 20px;
    left: 0;
    background-color: #333;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    width: 290px;
    z-index: 10;
    max-height: 200px; /* Set max height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: hidden; /* Hide horizontal scrolling */
    white-space: normal; /* Allow text wrapping */
}

/* Show tooltip on active class */
.tooltip-container.active .tooltip-content {
    display: block;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Latest News</h3>
                <button class="btn btn-primary"><a style="color:white" href="{{ route('news.create') }}">+ News</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $key => $new)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $new->title }}</td>
                            <td>{{ substr($new->description_1,0,25) }}
                            <span class="tooltip-container" onclick="toggleTooltip(event, this)">
                                    Read more...
                            <span class="tooltip-content"><p>{{ $new->description_1 }}</p></span>
                                </span>
                            </td>
                            <td>
                                <a href="{{route('news.edit',$new->id)}}"><i class="fa fa-edit"></i></a>
                                <form id="delete-form-{{ $new->id }}" action="{{ route('news.destroy', $new->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-link p-0 delete-button" data-id="{{ $new->id }}">
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

function toggleTooltip(event, element) {
    // Close other active tooltips
    document.querySelectorAll('.tooltip-container.active').forEach((tooltip) => {
        if (tooltip !== element) {
            tooltip.classList.remove('active');
        }
    });

    // Toggle the clicked tooltip
    element.classList.toggle('active');

    // Stop event propagation to prevent triggering the document click listener
    event.stopPropagation();
}

// Close all tooltips when clicking outside
document.addEventListener('click', () => {
    document.querySelectorAll('.tooltip-container.active').forEach((tooltip) => {
        tooltip.classList.remove('active');
    });
});
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