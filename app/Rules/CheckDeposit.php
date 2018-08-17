<?php

namespace App\Rules;

use App\Inn;
use Domain\User\Queries\GetInnByNumberQuery;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CheckDeposit implements Rule
{
    use DispatchesJobs;

    private $sum;

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
     * @param  string $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        [$sum, $users] = getSum(request('inn'), request('users'));

        $this->sum = $sum * $users->count();

        return $this->sum <= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.check_deposit', ['sum' => $this->sum]);
    }
}
