<?php

namespace App\Http\Requests\Theater;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TheaterUpdateRequest extends FormRequest
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
            'name' => 'required|string',
            'image' => 'file|mimes:png,jpeg,jpg,jfif|max:5120',
            'content' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9]+$/|min:10',
            'city_id' => 'required|integer|exists:cities,id|min:1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name không được bỏ trống',
            'name.string' => 'Name phải là chuỗi ký tự',
            'image.file' => 'File ảnh không đúng định dạng',
            'image.mimes' => 'Vui lòng chọn file đúng định dạng ảnh như png, jpeg, jpg, jfif',
            'image.max' => 'Kích thước ảnh quá lớn, vui lòng chọn ảnh < 5MB.',
            'content.required' => 'Nội dung không được bỏ trống',
            'address.required' => 'Address không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Phone không được bỏ trống',
            'phone.regex' => 'Phone phải là chữ số',
            'phone.min' => 'Phone tối thiểu 10 ký tự',
            'city_id.required' => 'City không được bỏ trống',
            'city_id.integer' => 'City phải là chữ số',
            'city_id.exists' => 'City không tồn tại',
            'city_id.min' => 'City có tối thiếu 1 chữ số'  
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
            'msg'    => 'Validation errors',
        ], 500));
    }
}
