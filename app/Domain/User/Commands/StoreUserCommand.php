<?php
/**
 * Created by Viktor Melnikov.
 * Date: 03.08.2018
 * GitHub: viktor-melnikov
 */

declare(strict_types=1);

namespace Domain\User\Commands;

use App\User;
use Domain\User\Queries\GetInnByNumberQuery;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Ramsey\Uuid\Uuid;

/**
 * Class StoreUserCommand
 *
 * @package Domain\User\Commands
 */
class StoreUserCommand
{
    use DispatchesJobs;

    private $params = [];
    private $inn;

    /**
     * StoreInnCommand constructor.
     *
     * @param array  $params
     * @param string $inn
     */
    public function __construct(array $params, string $inn)
    {
        $this->params = $params;
        $this->inn    = $this->dispatch(new GetInnByNumberQuery($inn));
    }

    /**
     *
     */
    public function handle()
    {
        $user = new User;

        $user
            ->fill($this->params + ['account_number' => getAccountNumber()])
            ->inn()
            ->associate($this->inn)
            ->save();
    }
}