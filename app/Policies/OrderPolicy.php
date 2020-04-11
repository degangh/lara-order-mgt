<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function modify(User $user, Order $order)
    {
        
        if ($order->sent == 1 || $order->paid == 1)
        {
            return $this->deny('Order Can NOT be changed after sent or paid');
        }

        return true;
    }

    public function changeStatus(User $user, Order $order)
    {
        if ($order->items->count() < 1)
        {
            return $this->deny('There should be as least ONE item in the order');
        }
        return true;
    }
}
