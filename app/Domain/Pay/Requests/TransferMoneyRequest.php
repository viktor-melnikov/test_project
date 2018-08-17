<?php

namespace Domain\Pay\Requests;

use App\Http\Requests\Request;
use App\Rules\CheckDeposit;
use App\Rules\CheckUserBalance;
use App\Rules\IsFloat;

class TransferMoneyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'users'   => ['required', 'exists:users,id', new CheckUserBalance],
            'inn'     => ['required', 'exists:inns'],
            'deposit' => ['bail', 'required', new IsFloat, new CheckDeposit],
        ];
    }
}
