<?php
/**
 * Created by Viktor Melnikov.
 * Date: 03.08.2018
 * GitHub: viktor-melnikov
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Inn;
use Domain\Pay\Requests\TransferMoneyRequest;
use Domain\User\Queries\GetInnByNumberQuery;
use Domain\User\Queries\GetUserByIdQuery;

class PayController extends Controller
{
    public function transfer(TransferMoneyRequest $request)
    {
        [$sum, $users] = getSum(request('inn'), request('users'));

        $activeUser = $this->dispatch(new GetUserByIdQuery(request('users')));

        $users->each(function ($user) use($sum) {
            $user->increment('balance', $sum);
        });

        $activeUser->decrement('balance', $sum * $users->count());

        return $this->message('api/pay.transfer');
    }
}