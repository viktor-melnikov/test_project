<?php

namespace Domain\User\Requests;

use App\Http\Requests\Request;

class StoreUserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'last_name'  => ['required'],
            'first_name' => ['required'],
            'patronymic' => ['required'],
            'balance'    => ['nullable', 'numeric'],
            'inn'        => ['required'],
        ];
    }
}
