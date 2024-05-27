@extends('admin.layouts.app')

@section('title', 'Spot')

@section('content')
    <div class="pagetitle">
        <h1>Data Spot</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/spot">Spot</a></li>
                <li class="breadcrumb-item active">Data Spot</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Spot</h5>
                        <a type="button" class="btn btn-primary m-2" href="/admin/spot/add"><i
                                class="bi bi-plus-square-fill"></i> Tambah Spot</a>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Spot</th>
                                    <th scope="col">Gambar Spot</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($spots as $spot)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $spot->name }}</td>
                                        <td>
                                            <img src="{{ Storage::url($spot->image) }}" alt="{{ $spot->name }}"
                                                style="height:40px; width:60px; object-fit: cover;">
                                        </td>
                                        <td><a href="/admin/spot/{{ $spot->id }}/edit" class="btn btn-warning"><i
                                                    class="bi bi-pencil-fill text-white"></i></a>
                                            | <a href="/admin/spot/{{ $spot->id }}/delete" class="btn btn-danger"><i
                                                    class="bi bi-trash3-fill text-white"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
