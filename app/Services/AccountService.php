<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Agency;
use App\Models\Holder;

class AccountService
{
    /**
     * @var BalanceService
     */
    private $balanceService;

    /**
     * AccountService constructor.
     * @param BalanceService $balanceService
     */
    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * @param Agency $agency
     * @param Holder $holder
     * @param string $password
     * @return Account
     */
    public function create(Agency $agency, Holder $holder, string $password): Account
    {
        $number = sprintf('%08d', Account::all()->count() + 1);
        $account = Account::create([
            'number' => $number,
            'status' => Account::STATUS_ACTIVE,
            'password' => bcrypt($password),
            'agency_id' => $agency->id,
            'holder_id' => $holder->id,
        ]);

        $account->save();
        $this->balanceService->start($account);

        return $account;
    }
}
