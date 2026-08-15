@php
    $isEdit = isset($video);
@endphp

<form id="video-form" class="row g-4" method="POST"
    action="{{ $isEdit ? route('videos.update', $video) : route('videos.store') }}"
    data-method="{{ $isEdit ? 'PUT' : 'POST' }}"
    data-redirect="{{ route('videos.index') }}"
    enctype="multipart/form-data" novalidate>
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title"
                        value="{{ old('title', $video->title ?? '') }}" required maxlength="255" />
                    <div class="invalid-feedback" data-error-for="title"></div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $video->description ?? '') }}</textarea>
                    <div class="invalid-feedback" data-error-for="description"></div>
                </div>

                <div class="mb-3">
                    <label for="video_link" class="form-label">Video Link (Vimeo) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="video_link" name="video_link"
                        value="{{ old('video_link', $video->video_link ?? '') }}" required
                        placeholder="https://vimeo.com/xxxxxxx or https://player.vimeo.com/video/xxxxxxx" />
                    <div class="form-text">Paste a Vimeo page link or iframe/embed link.</div>
                    <div class="invalid-feedback" data-error-for="video_link"></div>
                </div>

                <div class="mb-3">
                    <label for="teacher_id" class="form-label">Teacher <span class="text-danger">*</span></label>
                    <select class="form-select" id="teacher_id" name="teacher_id" required>
                        <option value="">Select Teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                @selected(old('teacher_id', $video->teacher_id ?? '') == $teacher->id)>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" data-error-for="teacher_id"></div>
                </div>

                <div class="mb-3">
                    <label for="thumbnail" class="form-label">
                        Thumbnail Image
                        @if (! $isEdit)
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*"
                        {{ $isEdit ? '' : 'required' }} />
                    @if ($isEdit)
                        <div class="form-text">Leave empty to keep the current thumbnail.</div>
                    @endif
                    <div class="invalid-feedback" data-error-for="thumbnail"></div>
                </div>

                <button type="submit" class="btn btn-primary" id="video-save-btn">
                    <span class="spinner-border spinner-border-sm d-none" id="video-save-spinner"></span>
                    Save
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">Video Preview</h6>
            </div>
            <div class="card-body">
                <div class="ratio ratio-16x9" id="video-preview-wrapper">
                    @if ($isEdit)
                        <iframe id="video-preview" src="{{ \App\Support\Vimeo::embedUrl($video->video_link) }}"
                            allow="autoplay; fullscreen; picture-in-picture"></iframe>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted" id="video-preview-empty">
                            Paste a Vimeo link to preview
                        </div>
                        <iframe id="video-preview" class="d-none" allow="autoplay; fullscreen; picture-in-picture"></iframe>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Thumbnail Preview</h6>
            </div>
            <div class="card-body text-center">
                <img id="thumbnail-preview"
                    src="{{ $isEdit && $video->thumbnail ? $video->thumbnail_url : '' }}"
                    class="img-fluid rounded {{ $isEdit && $video->thumbnail ? '' : 'd-none' }}"
                    alt="Thumbnail preview" />
                <p class="text-muted mb-0 {{ $isEdit && $video->thumbnail ? 'd-none' : '' }}" id="thumbnail-preview-empty">
                    No thumbnail selected
                </p>
            </div>
        </div>
    </div>
</form>
