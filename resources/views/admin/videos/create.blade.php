@extends('admin.main.main')

@section('title', 'Add Video')

@section('main-content')
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Add Video</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Add Video</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            @include('admin.videos._form', ['teachers' => $teachers])
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/video-form.js') }}"></script>
@endpush
