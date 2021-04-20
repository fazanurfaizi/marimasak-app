<?php

namespace App\Http\Requests\Api\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeCommentRequest extends FormRequest
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
            'body' => 'required|string',
            'recipe_id' => 'required|exists:recipes,id'
        ];
    }
}
