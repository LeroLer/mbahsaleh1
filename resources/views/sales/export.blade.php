@extends('layouts.app')

@section('title', 'Export Laporan Penjualan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Export Laporan Penjualan</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('sales.export') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="export_type">Jenis Export</label>
                            <select class="form-control" id="export_type" name="format" required>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Export</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
