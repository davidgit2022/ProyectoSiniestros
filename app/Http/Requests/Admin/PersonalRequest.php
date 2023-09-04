<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PersonalRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'full_name' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'status' => 'required',
                    'department_id' => 'required',
                    'province_id' => 'required',
                    'district_id' => 'required',
                ];
            case 'PUT':
                return [
                    'name' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'status' => 'required',
                    'department_id' => 'required',
                    'province_id' => 'required',
                    'district_id' => 'required',
                ];
        }
    }
}
