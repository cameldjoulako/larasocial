<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ValidationTrait;

class UserStoreRequest extends FormRequest
{
    use ValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "username" => "required|unique:users",
            "email" => "required|unique:users",
            "gender" => "required|in:male,female",
            "password" => "required",
            "country_id" => "required|exists:countries,id",
            "city_id" => "required|exists:cities,id",
        ];
    }
}
