<?php

namespace App\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|between:1,100',
            'position' => 'required|string|max:255',
            'shirt_number' => 'required|integer|between:1,100',
            'nationality' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'team_id' => 'required|integer|exists:teams,id',
        ];
    }
}
