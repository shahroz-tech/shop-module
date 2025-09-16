<?php

namespace App\Http\Controllers\CartItemController;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest\AddToCartRequest;
use App\Http\Requests\CartItemRequest\UpdateCartRequest;
use App\Services\CartItemService;

class CartItemController extends Controller
{
    protected CartItemService $cartService;

    public function __construct(CartItemService $cartService)
    {
//        $this->middleware('auth:sanctum'); // require auth
        $this->cartService = $cartService;
    }

    public function index()
    {
        $items = $this->cartService->getCart();
        return view('cart.index',['cartItems' => $items]);

    }

    public function add(AddToCartRequest $request)
    {
        $item = $this->cartService->addToCart($request->product_id, $request->quantity);
        return back()->with('success', 'Item added to cart');
    }

    public function update(UpdateCartRequest $request, $productId)
    {
        $item = $this->cartService->updateCart($productId, $request->quantity);

        return $item ? back()->with('success_update','Updated Successfully') : back()->with('message', 'Not found');
    }

    public function remove($productId)
    {
        $this->cartService->removeFromCart($productId);
        return back()->with('success', 'Item removed from cart');
    }

    public function clear()
    {
        $this->cartService->clearCart();
        return back()->with('success', 'Item cleared');
    }
}
