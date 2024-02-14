<?php

namespace App\Constants;

enum OrderStatus: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case SUCCESS = 'success';
}
