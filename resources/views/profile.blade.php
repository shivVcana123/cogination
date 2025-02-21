@extends('layouts.guest')
@section('content')

<style>
    .admin-caard{
    border-top: 43px solid #069aef !important;
}
</style>
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
                    <div class="card card-primary card-outline admin-caard">
                    <div class="card-body box-profile">
                       

               

                        <ul class="list-group  mb-3">
                        <li class="list-group-item">
                            <b>Name</b> <a class="float-right">{{ auth()->user()->name }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ auth()->user()->email }}</a>
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