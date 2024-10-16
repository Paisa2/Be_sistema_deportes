<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom_categoria' => "required|min:3|max:150" . $this->categoria,
            'edad_categoria' => "required|numeric|min:1|max:99",
            'fecha_inscription' => "required|date",
        ];
    }
}
