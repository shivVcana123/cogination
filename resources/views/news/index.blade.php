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
                <h3 class="card-title">News</h3>
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
                            <th>Background Color</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $key => $home)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $home->title }}</td>
                            <td>{{ substr($home->description_1,0,25) }}
                            <span class="tooltip-container" onclick="toggleTooltip(event, this)">
                                    Read more...
                            <span class="tooltip-content"><p>{{ $home->description_1 }}</p></span>
                                </span>
                            </td>
                            <td>{{ $home->background_color }}</td>
                            <td>
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash"></i>
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
</script>
@endsection