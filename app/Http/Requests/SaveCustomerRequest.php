<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCustomerRequest extends FormRequest
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
            'name' => 'required',
            //'email'   => 'email',
        ];
    }

	public function messages() {
        return [
            'name.required' => '顧客を入力してください。',
            //'email.email' => '正しいメールアドレスを入力してください。',
        ];
    }
}
