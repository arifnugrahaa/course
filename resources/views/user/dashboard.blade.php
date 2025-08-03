@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>
                <div class="card-body">
                    <h4>Welcome, {{ Auth::user()->name }}!</h4>
                    <p>You are logged in as User</p>
                    <div class="alert alert-success">
                        This is your personal dashboard. You can access user-specific features here.
                    </div>

                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('materials.index') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-book"></i> Lihat Materi Edukasi
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('materials.create') }}" class="btn btn-success w-100">
                                    <i class="fas fa-plus"></i> Buat Materi Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
