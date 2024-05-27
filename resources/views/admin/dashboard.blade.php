@extends('admin.layouts.app')

@section('title', 'Admin')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/admin/dashboard">Dashboard</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-12 col-xl-12">
                        <div class="card info-card portocategory-card">
                            <div class="card-body">
                                <h5 class="card-title">Spot</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                        style="color: #4154f1;  background: #f6f6fe;">
                                        <i class="bi bi-pin-map"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $spotcounts }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Spot</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->
                </div>
            </div>
        </div>
    </section>
@endsection
