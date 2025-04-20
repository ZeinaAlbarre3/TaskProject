<?php

namespace App\Http\Requests\Media;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PodcastRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo|max:51200',
        ];
    }

    public function messages(): array
    {
        return [
            'video.mimes' => 'Only mp4, mov, avi... are allowed.',
            'video.max' => 'Each video must not exceed 50MB in size.',
        ];
    }

}

