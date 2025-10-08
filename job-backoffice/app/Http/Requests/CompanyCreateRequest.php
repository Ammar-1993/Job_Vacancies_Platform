<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',

            // owner details
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'name.unique' => 'The company name has already been taken.',
            'name.max' => 'The company name must be less than 255 characters.',
            'name.string' => 'The company name must be a string.',
            'address.required' => 'The company address is required.',
            'address.max' => 'The company address must be less than 255 characters.',
            'address.string' => 'The company address must be a string.',
            'industry.required' => 'The company industry is required.',
            'industry.max' => 'The company industry must be less than 255 characters.',
            'industry.string' => 'The company industry must be a string.',
            'website.url' => 'The company website must be a valid URL.',
            'website.max' => 'The company website must be less than 255 characters.',
            'website.string' => 'The company website must be a string.',

            // owner details
            'owner_name.required' => 'The owner name is required.',
            'owner_name.max' => 'The owner name must be less than 255 characters.',
            'owner_name.string' => 'The owner name must be a string.',
            'owner_email.required' => 'The owner email is required.',
            'owner_email.email' => 'The owner email must be a valid email address.',
            'owner_email.unique' => 'The owner email has already been taken.',
            'owner_password.required' => 'The owner password is required.',
            'owner_password.min' => 'The owner password must be at least 8 characters long.',
            'owner_password.string' => 'The owner password must be a string.',
        ];
    }
}