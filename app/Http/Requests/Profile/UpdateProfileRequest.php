<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        Gate::authorize('app.profile.update');
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image'
        ];
    }
}
