@extends('layouts.guest')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                       

                        <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                        <p class="text-muted text-center">{{ auth()->user()->email }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Admin Name</b> <a class="float-right">{{ auth()->user()->name }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Admin Email</b> <a class="float-right">{{ auth()->user()->email }}</a>
                        </li>
                        
                        </ul>
                    </div>
                    <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection