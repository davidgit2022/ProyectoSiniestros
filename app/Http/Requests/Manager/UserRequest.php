<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'first_name' => 'required|max:40',
                    'first_apell' => 'required|max:40',
                    'second_apell' => 'required|max:40',
                    'email' => 'required|email|unique:users',
                    'document_num' => 'required|unique:hr_per_people_f',
                    'cuspp' => 'nullable|unique:hr_per_people_f',
                    'nro_pasaporte' => 'nullable|unique:hr_per_people_f',
                    'ruc' => 'nullable|unique:hr_per_people_f',
                ];

            case 'PUT':
                return [
                    'name' => 'required|max:40|unique:users,name,'. $this->user->id,
                    'email' => 'required|max:255|unique:users,email,'. $this->user->id,
                ];
        }
    }
}
