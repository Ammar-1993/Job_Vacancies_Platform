<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:job_vacancies,title',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'jobCategoryId' => 'required|string|max:255',
            'companyId' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'title.unique' => 'The job title has already been taken.',
            'title.max' => 'The job title must be less than 255 characters.',
            'title.string' => 'The job title must be a string.',
            'location.required' => 'The job location is required.',
            'location.max' => 'The job location must be less than 255 characters.',
            'location.string' => 'The job location must be a string.',
            'salary.required' => 'The job salary is required.',
            'salary.numeric' => 'The job salary must be a number.',
            'salary.min' => 'The job salary must be at least 0.',
            'type.required' => 'The job type is required.',
            'type.max' => 'The job type must be less than 255 characters.',
            'type.string' => 'The job type must be a string.',
            'description.required' => 'The job description is required.',
            'description.max' => 'The job description must be less than 255 characters.',
            'description.string' => 'The job description must be a string.',
            'jobCategoryId.required' => 'The job category is required.',
            'jobCategoryId.max' => 'The job category must be less than 255 characters.',
            'jobCategoryId.string' => 'The job category must be a string.',
            'companyId.required' => 'The company is required.',
            'companyId.max' => 'The company must be less than 255 characters.',
            'companyId.string' => 'The company must be a string.',
        ];
    }
}