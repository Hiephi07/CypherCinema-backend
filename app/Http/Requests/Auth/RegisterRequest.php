<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'unique:users',
            ],

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

            'fullname' => [
                'required',
                'string',
                'min:2',
                'max:64',
                'regex:/^[\pL\s]+$/u'
            ],

            'phone_number' => [
                'required',
                'numeric',
                'digits:10'
            ],

            'birthday' =>  'required|date|after:1900-01-01|before:today|date_format:Y-m-d',

            'gender' => 'required|numeric|in:1,2,3',

            'city_id' => 'required|numeric|min:1|max:63',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được bỏ trống.',
            'email.email'    => 'Email không đúng định dạng.',
            'email.unique'   => 'Email đã tồn tại. Hãy thử lại với email khác!',

            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.string'   => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min'      => 'Mật khẩu tối thiểu :min ký tự.',
            'password.max'      => 'Mật khẩu không được vượt quá :max ký tự.',
            'password.regex'    => 'Mật khẩu phải bao gồm tối thiểu một chữ cái thường, 
                                    một chữ cái hoa, một chữ số và một ký tự đặc biệt như @ $ ! % * # ? &',

            'fullname.required' => 'Họ và tên không được bỏ trống.',
            'fullname.string'   => 'Họ và tên phải là chuỗi ký tự.',
            'fullname.min'      => 'Họ và tên tối thiểu :min ký tự.',
            'fullname.max'      => 'Họ và tên tối đa :max ký tự.',
            'fullname.regex'    => 'Họ và tên chỉ được phép bao gồm chữ.',

            'phone_number.required' => 'Số điện thoại không được bỏ trống.',
            'phone_number.numeric'  => 'Số điện thoại chỉ bao gồm chữ số.',
            'phone_number.digits'   => 'Số điện thoại phải bao gồm 10 chữ số.',

            'birthday.required'    => 'Ngày sinh không được bỏ trống.',
            'birthday.date'        => 'Ngày sinh sai định dạng.',
            'birthday.before'      => 'Ngày sinh phải nhỏ hơn ngày hiện tại.',
            'birthday.after'       => 'Ngày sinh phải lớn hơn ngày 01/01/1900.',
            'birthday.date_format' => 'Ngày sinh phải theo định dạng năm/tháng/ngày (Ví dụ: 2000-01-01).',

            'gender.required' => 'Giới tính không được bỏ trống.',
            'gender.numeric'  => 'Giới tính phải mang giá trị là số.',
            'gender.in'       => 'Giới tính phải mang giá trị 1, 2 hoặc 3',

            'city_id.required' => 'Thành phố không được bỏ trống.',
            'city_id.numeric'  => 'Thành phố phải mang giá trị là số.',
            'city_id.min'      => 'Thành phố có giá trị tối thiểu là 1.',
            'city_id.max'      => 'Thành phố có giá trị tối đa là 63.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $errors,
            'msg' => 'Có lỗi trong quá trình xác thực đầu vào của dữ liệu. Vui lòng thử lại!',
        ], 401));
    }
}
