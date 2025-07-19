<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'publisher_id' => 'required|exists:publishers,id',
            'author_ids' => 'required|array',
            'author_ids.*' => 'exists:authors,id',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'required|mimes:png,jpg,jpeg',
            'file' => 'required|mimes:mp3',
        ];
    }

    public function messages()
    {
        return [
            'publisher_id.required' => 'The publisher field is required',
            'author_ids.required' => 'The author field is required',
            'category_ids.required' => 'The category field is required',
            'image.required' => 'The image field is required',
            'image.mimes' => 'The image field must be png, jpg, jpeg',
            'file.required' => 'The file field is required',
            'file.mimes' => 'The file field must be mp3',
        ];
    }
}
