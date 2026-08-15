@extends('admin.main.main')

@section('title', 'Dashboard')

@section('main-content')
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
            </div>
            <div class="page-header-right ms-auto">
                <div class="d-flex gap-2">
                    <a href="{{ route('videos.create') }}" class="btn btn-primary">
                        <i class="feather-plus-circle me-2"></i>Add
                    </a>
                    <a href="{{ route('videos.index') }}" class="btn btn-light-brand">
                        <i class="feather-edit-2 me-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-4">
                                <div class="avatar-text avatar-lg bg-soft-primary text-primary">
                                    <i class="feather-video"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0">{{ $videoCount }}</h3>
                                    <p class="text-muted mb-0">Total Videos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-4">
                                <div class="avatar-text avatar-lg bg-soft-success text-success">
                                    <i class="feather-users"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0">{{ $teacherCount }}</h3>
                                    <p class="text-muted mb-0">Teachers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
