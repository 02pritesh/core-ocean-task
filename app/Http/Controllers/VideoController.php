<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoStoreRequest;
use App\Http\Requests\VideoUpdateRequest;
use App\Models\Teacher;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(): View
    {
        $videos = Video::with('teacher')->latest()->get();

        return view('admin.videos.index', compact('videos'));
    }

    public function create(): View
    {
        $teachers = Teacher::orderBy('name')->get();

        return view('admin.videos.create', compact('teachers'));
    }

    public function store(VideoStoreRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();
        $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');

        Video::create($data);

        return $this->respondWithSuccess($request, 'Video added successfully!');
    }

    public function edit(Video $video): View
    {
        $teachers = Teacher::orderBy('name')->get();

        return view('admin.videos.edit', compact('video', 'teachers'));
    }

    public function update(VideoUpdateRequest $request, Video $video): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $video->update($data);

        return $this->respondWithSuccess($request, 'Video updated successfully!');
    }

    private function respondWithSuccess(Request $request, string $message): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => $message,
                'redirect' => route('videos.index'),
            ]);
        }

        return redirect()->route('videos.index')->with('success', $message);
    }
}
