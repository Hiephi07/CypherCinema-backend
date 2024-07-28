<?php

namespace App\Http\Requests\Banner;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BannerUpdateRequest extends FormRequest
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
            'image' => 'file|mimes:png,jpeg,jpg,jfif|max:5120',
            'type' => 'required|in:sub,main', 
            'status' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'image.file' => 'File ảnh không đúng định dạng.',
            'image.mimes' => 'Vui lòng chọn file đúng định dạng ảnh như png, jpeg, jpg, jfif.',
            'image.max' => 'Kích thước ảnh quá lớn, vui lòng chọn ảnh < 5MB.',
            'type.required' => 'Type là bắt buộc.',
            'type.in' => 'Type phải là một trong các giá trị: sub, main.', 
            'status.required' => 'Status là bắt buộc.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
            'msg'    => 'Validation errors',
        ], 422));
    }
}
