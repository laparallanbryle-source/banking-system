<?php

namespace App\Notifications;

use App\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowBalanceNotification extends Notification
{
    use Queueable;

    public function __construct(public Account $account)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'account_number'  => $this->account->account_number,
            'balance'         => $this->account->balance,
            'minimum_balance' => $this->account->minimum_balance,
            'message'         => 'Your balance has reached the minimum threshold.',
        ];
    }
}