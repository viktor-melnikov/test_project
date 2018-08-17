<?php
/**
 * Created by Viktor Melnikov.
 * Date: 03.08.2018
 * GitHub: viktor-melnikov
 */

declare(strict_types=1);

namespace Domain\User\Queries;

use App\User;
use Illuminate\Database\Eloquent\Collection;

class GetUserByIdQuery
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return User|mixed
     */
    public function handle(): User
    {
        return User::findOrFail($this->id);
    }
}