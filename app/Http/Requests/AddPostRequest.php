<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ValidationTrait;

class AddPostRequest extends FormRequest
{
    use ValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "caption" => "required_without_all:images,videos",
            "images" => "required_without_all:caption,videos",
            "videos" => "required_without_all:images,caption",
            "type" => "required|in:post,page,group"
        ];
    }
}
