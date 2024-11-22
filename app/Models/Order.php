<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    protected $appends = ['status_name'];

    public function getStatusNameAttribute(): string
    {
        return OrderStatus::from($this->status)->name;
    }
}
