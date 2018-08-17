<?php
/**
 * Created by Viktor Melnikov.
 * Date: 02.08.2018
 * GitHub: viktor-melnikov
 */

use App\User;
use Domain\User\Queries\GetInnByNumberQuery;
use Ramsey\Uuid\Uuid;

if (! function_exists('asset_vendor')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function asset_vendor($path, $secure = null)
    {
        return app('url')->asset('vendor/'.$path, $secure);
    }
}

if (! function_exists('asset_dist')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function asset_dist($path, $secure = null)
    {
        return app('url')->asset('dist/'.$path, $secure);
    }
}

if (! function_exists('getAccountNumber')) {
    /**
     * Generate unique account number
     *
     * @return null|string
     */
    function getAccountNumber() {
        $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, time())->toString();;

        while(User::query()->where('account_number', $uuid)->first() !== null) {
            $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, time())->toString();
        }

        return $uuid;
    }
}

if (! function_exists('getSum')) {
    /**
     * Calculate correct deposit
     *
     * @param $inn
     * @param $userId
     *
     * @return array
     */
    function getSum($inn, $userId) {
        /** @var \App\Inn $inn */
        $inn   = dispatch_now(new GetInnByNumberQuery($inn, false));
        $users = $inn->users()->where('id', '<>', $userId)->get();

        return [round(request('deposit') / $users->count(), 2), $users];
    }
}