<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'image' => 'required|mimes:png,jpg,jpeg',
            'file' => 'required|mimes:mp3',
            'author_ids' => 'required|array',
            'author_ids.*' => 'exists:authors,id',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ];
    }
}
