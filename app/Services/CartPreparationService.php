<?php 

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class CartPreparationService
{
    private $cartService;
    private $productService;
    private $cartItemService;

    public function __construct(CartService $cartService, ProductService $productService, CartItemService $cartItemService)
    {
        $this->cartService = $cartService;
        $this->productService = $productService;
        $this->cartItemService = $cartItemService;
    }

    public function __invoke($productId)
    {
        $cart = $this->cartService->FindOrCreateCart(Auth::id());
        $product = $this->productService->getProductById($productId);
        $cartItem = $this->cartItemService->getCartItem($cart['id'], $product['id']);

        return [$cart, $product, $cartItem];
    }
}
