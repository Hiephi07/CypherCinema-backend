<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email',
            'token' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:32',
                'regex:/[a-z]/', 
                'regex:/[A-Z]/',
                'regex:/[0-9]/', 
                'regex:/[@$!%*#?&]/', 
                'confirmed'
            ],
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email sai định dạng',
            'token.required' => 'Token là bắt buộc',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
            'password.regex' => 'Mật khẩu phải bao gồm ít nhất một chữ cái thường, một chữ cái hoa, một chữ số và một ký tự đặc biệt.',
            'password.confirmed' => 'Password không khớp',
            'password_confirmation.required' => 'Password Confirm là bắt buộc'

        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'msg' => $validator->errors()
        ], 401));
    }
}
