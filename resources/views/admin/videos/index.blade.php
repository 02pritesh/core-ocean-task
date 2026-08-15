@extends('admin.main.main')

@section('title', 'Videos')

@section('main-content')
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Videos</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Videos</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <a href="{{ route('videos.create') }}" class="btn btn-primary">
                    <i class="feather-plus-circle me-2"></i>Add
                </a>
            </div>
        </div>

        <div class="main-content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="videos-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Thumbnail</th>
                                    <th>Video</th>
                                    <th>Created Date</th>
                                    <th>Teacher</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($videos as $video)
                                    <tr>
                                        <td>{{ $video->title }}</td>
                                        <td>
                                            @if ($video->thumbnail)
                                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}"
                                                    class="rounded" style="width: 60px; height: 40px; object-fit: cover;" />
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-light-brand btn-view-video"
                                                data-embed-url="{{ \App\Support\Vimeo::embedUrl($video->video_link) }}"
                                                data-title="{{ $video->title }}">
                                                <i class="feather-eye me-1"></i>View
                                            </button>
                                        </td>
                                        <td>{{ $video->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $video->teacher->name ?? '-' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('videos.edit', $video) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="feather-edit-2 me-1"></i>Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Rendered outside .nxl-container (see main.blade.php) so the theme's
     "body.modal-open .nxl-container { filter: blur(3px) }" rule - meant to
     blur the page behind a modal - doesn't also blur the modal itself. --}}
@push('modals')
    <div class="modal fade" id="video-view-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="video-view-modal-title">Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <iframe id="video-view-modal-iframe" src="" allow="autoplay; fullscreen; picture-in-picture"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-brand" id="video-view-pause-btn">
                        <i class="feather-pause me-1"></i>Pause
                    </button>
                    <button type="button" class="btn btn-primary" id="video-view-play-btn">
                        <i class="feather-play me-1"></i>Play
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/dataTables.bs5.min.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendors/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/dataTables.bs5.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/video-index.js') }}"></script>
@endpush
