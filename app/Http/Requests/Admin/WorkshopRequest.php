<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class WorkshopRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|unique:workshops,name',
                    'representante' => 'required',
                    'phone' => 'required',
                    'email' => 'required',
                    'status' => 'required',
                    'department_id' => 'required',
                    'province_id' => 'required',
                    'district_id' => 'required',
                ];
            case 'PUT':
                return [
                    'name' => 'required|unique:workshops,name,' . $this->workshop->id,
                    'representante' => 'required',
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
