<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Order;
use App\Services\CartService;

interface OrderServiceInterface
{
    public function get(int $order_id);
    public function all();
    public function store(CartService $cart, Address $address): \Illuminate\Http\RedirectResponse|Order;
}