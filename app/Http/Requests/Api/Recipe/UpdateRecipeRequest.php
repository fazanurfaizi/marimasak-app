<?php

namespace App\Http\Requests\Api\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'materials' => 'required|string',
            'methods' => 'required|string',
            'thumbnail' => 'sometimes|file|mimes:png,jpg'
        ];
    }
}
