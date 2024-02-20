<?php

namespace App\Constants;

use App\Models\Order;

class OrderStatusConstants
{
    public const FINAL_STATUSES = [
        OrderStatus::SUCCESS,
        OrderStatus::REFUNDED,
        OrderStatus::DISPUTED,
    ];
}
