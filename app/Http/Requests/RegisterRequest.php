<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            // パスワード強度ルール：
            // - min(8)      : 最低8文字
            // - mixedCase() : 大文字と小文字の両方を含む（例: Abc...）
            // - numbers()   : 数字を1文字以上含む
            // - symbols()   : 記号を1文字以上含む（例: !@#$）
            // 弱いパスワード（"password" 等）が登録されるのを防ぐ
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ];
    }
}
