<?php
namespace App\Enums;

enum OrderStatus: int
{
    case CREATED = 0;
    case STARTED = 1;
    case COOKING = 2;
    case READY = 3;
}
