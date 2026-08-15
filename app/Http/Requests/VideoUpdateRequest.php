<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'video_link' => ['required', 'string', 'max:500', 'regex:/vimeo\.com/i'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            // Optional on update - only replace the thumbnail if a new file is uploaded.
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'video_link.regex' => 'The video link must be a valid Vimeo link/iframe URL.',
        ];
    }
}
