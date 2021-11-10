<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        Gate::authorize('users.edit');
        return true;
    }

    public function rules()
    {
        $id = request()->route('user')->id;
        return [
            'registration_code' => 'required|integer|unique:'.User::class.',registration_code',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . request()->route('user')->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required',
            'avatar' => 'nullable|image',
        ];
    }
}
