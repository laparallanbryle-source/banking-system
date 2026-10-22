<?php

namespace App\Observers;

use App\Exceptions\InsufficientFundsException;
use App\Models\Account;
use App\Models\Transaction;
use App\Notifications\LowBalanceNotification;

class AccountObserver
{
    // Tumatakbo BAGO i-save ang transaction
    public function creating(Transaction $transaction): void
    {
        $account = Account::lockForUpdate()->findOrFail($transaction->account_id);

        $amount = (float) $transaction->amount;
        $balance = (float) $account->balance;

        if ($transaction->type === 'deposit') {
            $newBalance = $balance + $amount;
        } else { // withdrawal o transfer
            $newBalance = $balance - $amount;

            if ($newBalance < 0 || $newBalance < (float) $account->minimum_balance) {
                throw new InsufficientFundsException('Insufficient funds. Hindi pwedeng bumaba sa minimum balance.');
            }
        }

        $account->update(['balance' => round($newBalance, 2)]);
    }

    // Tumatakbo PAGKATAPOS ma-save ang transaction
    public function created(Transaction $transaction): void
    {
        if ($transaction->type === 'deposit') {
            return;
        }

        $account = $transaction->account()->first();
        $previous = (float) $account->balance + (float) $transaction->amount;

        // Mag-notify lang kapag NAG-CROSS sa threshold (iwas duplicate)
        if ($previous > (float) $account->minimum_balance
            && (float) $account->balance <= (float) $account->minimum_balance) {
            $account->user->notify(new LowBalanceNotification($account));
        }
    }
}