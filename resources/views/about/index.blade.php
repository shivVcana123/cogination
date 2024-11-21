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
                <h3 class="card-title">About</h3>
                <button class="btn btn-primary"><a style="color:white" href="{{ route('about.create') }}">+ About</a></button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description 1</th>
                            <th>Description 2</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($about as $key => $abouts)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $abouts->title }}</td>
                            <td>{{ substr($abouts->description_1,0,25) }}
                            <span class="tooltip-container" onclick="toggleTooltip(event, this)">
                                    Read more...
                            <span class="tooltip-content"><p>{{ $abouts->description_1 }}</p></span>
                                </span>
                            </td>
                            <td>{{ substr($abouts->description_2, 0 ,25) }}
                            <span class="tooltip-container" onclick="toggleTooltip(event, this)">
                                    Read more...
                            <span class="tooltip-content"><p>{{ $abouts->description_2 }}</p></span>
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('about.edit',$abouts->id) }}"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('about.destroy', $abouts->id) }}" method="POST" style="display:inline;">
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