<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VoucherRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'required',
            'expiration_date' => 'required|date|after:today',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name là bắt buộc',
            'name.string' => 'Name phải là chuỗi',
            'name.max' => 'Name tối đa 255 ký tự',
            'discount.required' => 'Discount là bắt buộc',
            'discount.numeric' => 'Discount phải là số',
            'discount.min' => 'Discount phải >= 0',
            'status.required' => 'Status là bắt buộc',
            'expiration_date.required' => 'Expiration Date là bắt buộc',
            'expiration_date.date' => 'Expiration Date không đúng định dạng',
            'expiration_date.after' => 'Expiration Date phải lớn hơn hôm nay',
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
