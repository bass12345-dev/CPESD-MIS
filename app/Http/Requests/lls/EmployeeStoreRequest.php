<?php

namespace App\Http\Requests\lls;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $default_connection = config('app._database.lls_whip');
        return [
                'establishment_id'          => 'nullable',   
                 'first_name'               => 'nullable',   
        ];
    }
}
