<?php

namespace App\Http\Requests\Event;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventUpdateRequest extends FormRequest
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
            'title'     => 'required|string',
            'title_sub' => 'required|string',
            'image'     => 'file|mimes:png,jpeg,jpg,jfif|max:5120',
            'content'   => 'required',
            'start_day' => 'required|date|after_or_equal:today',
            'end_day'   => 'required|date|after_or_equal:start_day',
            'status'    => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required'           => 'Title là bắt buộc',
            'title.string'             => 'Title phải là chuỗi ký tự',
            'title_sub.required'       => 'Title sub là bắt buộc',
            'title_sub.string'         => 'Title sub phải là chuỗi ký tự',
            'image.file'               => 'File ảnh không đúng định dạng.',
            'image.mimes'              => 'Vui lòng chọn file đúng định dạng ảnh như png, jpeg, jpg, jfif.',
            'image.max'                => 'Kích thước ảnh quá lớn, vui lòng chọn ảnh < 5MB.',
            'content.required'         => 'Nội dung là bắt buộc',
            'start_day.required'       => 'Ngày bắt đầu là bắt buộc',
            'start_day.date'           => 'Ngày bắt đầu không đúng định dạng',
            'start_day.after_or_equal' => 'Ngày bắt đầu phải lớn hơn hoặc bằng ngày hiện tại', 
            'end_day.required'         => 'Ngày kết thúc là bắt buộc',
            'end_day.date'             => 'Ngày kết thúc không đúng định dạng',
            'end_day.after_or_equal'   => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu',
            'status.required'          => 'Status là bắt buộc' 
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
