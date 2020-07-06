<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Balance;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BalanceService
{
    /**
     * @param Account $account
     * @return Balance
     */
    public function start(Account $account): Balance
    {
        $balance = Balance::create([
            'value' => 0,
            'old_value' => 0,
            'account_id' => $account->id,
        ]);

        $balance->save();

        return $balance;
    }

    /**
     * @param Account $account
     * @return Balance
     */
    public function get(Account $account): Balance
    {
        if ($account->status == Account::STATUS_INACTIVE) {
            throw new BadRequestHttpException('Conta inativa');
        }

        return Balance::where('account_id', $account->id)->latest()->first();
    }

    /**
     * @param Account $account
     * @param float $value
     * @return mixed
     */
    public function deposit(Account $account, float $value): Balance
    {
        if ($account->status == Account::STATUS_INACTIVE) {
            throw new BadRequestHttpException('Conta inativa');
        }

        $oldBalance = $this->get($account);
        $balance = Balance::create([
            'value' => $oldBalance->value + $value,
            'old_value' => $oldBalance->value,
            'account_id' => $account->id,
        ]);

        $balance->save();

        return $balance;
    }

    /**
     * @param Account $account
     * @param $value
     * @return Balance
     */
    public function withdraw(Account $account, $value): Balance
    {
        if ($account->status == Account::STATUS_INACTIVE) {
            throw new BadRequestHttpException('Conta inativa');
        }

        $oldBalance = $this->get($account);
        if ($oldBalance->value < $value) {
            throw new BadRequestHttpException('Saldo insuficiente');
        }

        $balance = Balance::create([
            'value' => $oldBalance->value - $value,
            'old_value' => $oldBalance->value,
            'account_id' => $account->id,
        ]);
        $balance->save();

        return $balance;
    }
}
