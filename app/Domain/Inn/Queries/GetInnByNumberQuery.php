<?php
/**
 * Created by Viktor Melnikov.
 * Date: 03.08.2018
 * GitHub: viktor-melnikov
 */

declare(strict_types=1);

namespace Domain\User\Queries;

use App\Inn;

class GetInnByNumberQuery
{
    private $number;
    private $isCreate;

    public function __construct($number, ?bool $isCreate = true)
    {
        $this->number   = $number;
        $this->isCreate = $isCreate;
    }

    /**
     * @return Inn|mixed
     */
    public function handle(): Inn
    {
        if($this->isCreate) {
            return Inn::query()->firstOrCreate([
                'inn' => $this->number,
            ]);
        }

        return Inn::query()->where('inn', $this->number)->firstOrFail();
    }
}