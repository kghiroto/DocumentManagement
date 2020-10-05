<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'lesson_name' => 'required|max:80',
            'lesson_start_date'   => 'required|date_format:Y-m-d|max:30',
            'lesson_start_time'   => 'required|in:0:00,0:30,1:00,1:30,2:00,2:30,3:00,3:30,4:00,4:30,5:00,5:30,6:00,6:30,7:00,7:30,8:00,8:30,9:00,9:30,10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00,17:30,18:00,18:30,19:00,19:30,20:00,20:30,21:00,21:30,22:00,22:30,23:00,23:30',
            'lesson_password'    => 'required|min:6|regex:/^[!-~]+$/|max:250',
        ];
    }

    public function messages() {
        return [
            'lesson_name.required' => 'レッスン名を入力してください。',
            'lesson_name.max' => 'レッスン名は:max 文字以内で入力してください。',
            'lesson_start_date.required' => 'レッスン日付を入力してください。',
            'lesson_start_time.required' => 'レッスン時間を入力してください。',
            'lesson_password.required' => 'パスワードを入力してください。',
            'lesson_password.min' => 'パスワードは:min文字以上で入力してください。',
            'lesson_password.max' => 'パスワードは:max文字以内で入力してください。',
            'lesson_password.regex' => 'パスワードは半角英数記号のみで入力してください。',
        ];
    }
}
