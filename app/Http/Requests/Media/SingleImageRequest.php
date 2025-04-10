<?php

namespace App\Http\Requests\Media;

use App\Http\Responses\Response;
use Illuminate\Foundation\Http\FormRequest;

class SingleImageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'You must upload at least one image.',
            'images.*.mimes' => 'Only jpeg, png, jpg, gif, svg images are allowed.',
            'images.*.max' => 'Each image must not exceed 2MB in size.',
        ];
    }

}

