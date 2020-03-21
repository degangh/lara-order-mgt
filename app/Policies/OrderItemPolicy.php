<?php

namespace App\Policies;

use App\User;
use App\OrderItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderItemPolicy
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

    public function modify(User $user, OrderItem $orderItem)
    {
        
        
        if ($orderItem->order->status->id != 1)
        {
            return $this->deny('Order Can NOT be changed after sent or paid');
        }

        return true;
    }
}
