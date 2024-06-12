<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:32',
                'regex:/[a-z]/', 
                'regex:/[A-Z]/',
                'regex:/[0-9]/', 
                'regex:/[@$!%*#?&]/', 
            ],
            'full_name' => 'required',
            'phone_number' => 'required',
            'sex' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại. Hãy thử lại với email khác!',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
            'password.regex' => 'Mật khẩu phải bao gồm ít nhất một chữ cái thường, một chữ cái hoa, một chữ số và một ký tự đặc biệt.',
            'full_name.required' => 'Tên là bắt buộc.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'sex.required' => 'Giới tính là bắt buộc.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'data' => null,
            'msg' => $validator->errors(),
        ], 401));
    }
    
}
