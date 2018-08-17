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

class GetUserByFioQuery
{
    private $string;

    public function __construct($string)
    {
        $this->string = explode(' ',  $string);
    }

    /**
     * @return Collection
     */
    public function handle(): Collection
    {
        $users = User::query();

        $users->whereRaw("last_name like ?", ["%{$this->string[0]}%"]);

        switch (count($this->string)) {
            case 2 :
                $users->whereRaw("first_name like ?", ["%{$this->string[1]}%"]);
                break;

            case 3 :
                $users->whereRaw("patronymic like ?", ["%{$this->string[2]}%"]);
                break;
        }

        return $users->get();
    }
}