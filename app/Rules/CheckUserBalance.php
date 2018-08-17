<?php

namespace App\Rules;

use Domain\User\Queries\GetUserByIdQuery;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CheckUserBalance implements Rule
{
    use DispatchesJobs;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = $this->dispatch(new GetUserByIdQuery((int)$value));

        return $user->balance >= request('deposit');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.check_balance');
    }
}
