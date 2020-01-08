<?php

namespace App\Http\Requests\Api;

use App\Models\Images;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $method = $this->method();
        $rules = [];
        if ($method == 'POST') {
            $rules = [
                'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name',
                'password' => 'required|alpha_dash|min:6',
                'verification_key' => 'required|string',
                'verification_code' => 'required|string',
            ];
        } elseif ($method == 'PATCH') {
            $userId = auth('api')->id();
            $rules = [
                'name' => [
                    'required',
                    'between:3,25',
                    'regex:/^[A-Za-z0-9\-\_]+$/',
                    Rule::unique('users')->ignore($userId)
                ],
                'email' => [
                    'email',
                    Rule::unique('users')->ignore($userId)
                ],
                'introduction' => 'max:80',
                'avatar_image_id' => Rule::exists('images','id')->where('type', 'avatar')->where('user_id', $userId)
            ];
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'verification_key' => '短信验证码 key',
            'verification_code' => '短信验证码',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杆和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
        ];
    }
}
