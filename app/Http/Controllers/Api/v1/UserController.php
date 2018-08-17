<?php
/**
 * Created by Viktor Melnikov.
 * Date: 03.08.2018
 * GitHub: viktor-melnikov
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Domain\User\Commands\StoreUserCommand;
use Domain\User\Queries\GetUserByFioQuery;
use Domain\User\Requests\StoreUserRequest;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    public function all()
    {
        /** @var Collection $users */
        $users = $this->dispatch(new GetUserByFioQuery(request('term')));

        $data = [];

        $users->each(function($user) use(&$data) {
            $data[] = [
                'text'    => implode(' ', [$user->last_name, $user->first_name, $user->patronymic]) . ' (' . $user->account_number . ')',
                'id'      => $user->id,
            ];
        });

        return response()->json( [ 'term' => request('term'), 'results' => $data ] );
    }

    public function store(StoreUserRequest $request)
    {
        $this->dispatch(new StoreUserCommand(request()->only(['first_name', 'last_name', 'balance', 'patronymic']), request('inn')));

        return $this->message('api/user.store');
    }
}