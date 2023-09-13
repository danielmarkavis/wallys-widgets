<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class OrderService implements OrderServiceInterface
{
    public function get(int $order_id)
    {
        return Order::find($order_id);
    }

    public function all(): Collection
    {
        return Order::whereAuthed()->with(['orderProducts.variant.product','address'])->get();
    }

    public function store(CartService $cart, Address $address): RedirectResponse|Order
    {
        $orderSession = session()->get('order', []);
        if(isset($orderSession['uuid'])) {
            $order = Order::where('uuid', $orderSession['uuid'])->first();
        } else {
            $orderSession['uuid'] = Str::uuid()->toString();

            $totalPrice = $cart->totalPrice();
            $subtotal = ($totalPrice/120)*100;
            $vat = $totalPrice - (($totalPrice/120)*100);

            $order = new Order();
            $order->uuid = $orderSession['uuid'];
            $order->subtotal = $subtotal;
            $order->vat = $vat;
            $order->total = $totalPrice;
            $order->status = PaymentServiceInterface::PAYMENT_PENDING;
            $order->shipping_address_id = $address->id;
            $order->user_id = auth()->user()->id;
            $order->save();

            foreach ($cart->get() as $variant) {
//                $order->orderProducts()->save(new OrderProduct([
//                    'order_id' => $order->id,
//                    'variant_id' => $variant['id'],
//                    'quantity' => $variant['quantity'],
//                    'price' => $variant['price'],
//                ]));
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->variant_id = $variant['id'];
                $orderProduct->quantity = $variant['quantity'];
                $orderProduct->price = $variant['price'];
                $orderProduct->save();
            }
        }

        if ($order === null) {
            $this->purgeSession();
            return redirect()->route('cart.index');
        }

        session()->put('order', $orderSession);

        return $order;
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function destroy(string $sku): void
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$sku])) {
            unset($cart[$sku]);
        }

        session()->put('cart', $cart);
    }

    public function getSessionOrder()
    {
        $orderUUID = $this->getOrderUUID();
        if ($orderUUID === null) {
            return null;
        }

        return Order::where('uuid', $orderUUID)->first();
    }


    public function getOrderUUID()
    {
        $orderSession = session()->get('order', []);

        return $orderSession['uuid'] ?? null;
    }

    public function purgeSession(): void
    {
        session()->put('order', []);
    }

}
