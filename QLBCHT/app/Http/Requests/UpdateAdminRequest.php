<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
    public function rules(): array
    {
        $maAdmin = $this->route('maAdmin');

        return [
            'ho' => 'required|string',
            'ten' => 'required|string',
            'sdt' => 'required|string|unique:admins,sdt,' . $maAdmin . ',maAdmin',
            'email' => 'required|email|unique:admins,email,' . $maAdmin . ',maAdmin',

        ];
    }
}
