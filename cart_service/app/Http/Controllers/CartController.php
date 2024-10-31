<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CartController extends Controller
{
    protected $productServiceUrl;

    public function __construct()
    {
        $this->productServiceUrl = env('PRODUCT_SERVICE_URL');
    }

    /**
     * Cria um novo carrinho para um cliente.
     *
     * @param int $customerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($customerId)
    {
        $cart = Cart::create(['customer_id' => $customerId]);

        return response()->json($cart, 201);
    }

    /**
     * Adiciona um item ao carrinho.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addItem(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        if (!$this->productExists($request->product_id)) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $cartItem = CartItem::updateOrCreate(
            ['cart_id' => $request->cartId, 'product_id' => $request->product_id],
            ['quantity' => DB::raw("quantity + {$request->quantity}")]
        );

        return response()->json($cartItem, 201);
    }

    /**
     * Remove um item do carrinho.
     *
     * @param int $cartId
     * @param int $itemId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItem($cartId, $itemId)
    {
        $cartItem = CartItem::where('cart_id', $cartId)->find($itemId);

        if (!$cartItem) {
            return response()->json(['message' => 'Item do carrinho não encontrado.'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Item do carrinho foi removido com sucesso.']);
    }

    /**
     * Retorna os itens de um carrinho.
     *
     * @param int $cartId
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewItems($cartId)
    {
        $cartItems = CartItem::where('cart_id', $cartId)->get();

        return response()->json($cartItems);
    }

    /**
     * Atualiza a quantidade de um item no carrinho.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $cartId
     * @param int $itemId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQuantity(Request $request, $cartId, $itemId)
    {
        $this->validate($request, [
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('cart_id', $cartId)->find($itemId);

        if (!$cartItem) {
            return response()->json(['message' => 'Item do carrinho não encontrado.'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json($cartItem);
    }

    /**
     * Verifica se o produto existe no microserviço de produtos.
     *
     * @param int $productId
     * @return bool
     */
    private function productExists($productId)
    {
        $client = new Client();

        try {
            $response = $client->get("{$this->productServiceUrl}/products/{$productId}");
            return $response->getStatusCode() === 200;
        } catch (RequestException $e) {
            dd($e->getMessage());
            return false;
        }
    }
}
