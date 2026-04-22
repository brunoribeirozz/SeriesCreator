<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeriesFormRequest extends FormRequest
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
            'nome' => ['required', 'min:2'],
            'seasonsQty' => ['required', 'numeric', 'min:1'],
            'episodesPerSeason' => ['required'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => "Insira o nome da serie",
            'nome.min' => "O nome da serie precisa ter ao menos 2 caracteres",
            'seasonsQty.required' => "A quantidade de temporadas deve ser preenchida",
            'episodesPerSeason.required' => "A quanidade de episódios deve ser informada"
        ];
    }
}
