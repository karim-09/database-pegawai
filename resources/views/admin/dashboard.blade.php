@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
<div class="callout callout-info">
<h4>Sistem Informasi Pegawai</h4>
<p>Selamat Datang {{ getUser()['name'] ?? '' }}</p>
</div>
@endsection

@push('scripts')
@endpush