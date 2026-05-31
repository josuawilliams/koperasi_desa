<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Carts::query()
            ->with('product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('cart.index', compact('carts'));
    }

    public function store(Request $request, string $id)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $data['quantity'];

        $result = DB::transaction(function () use ($id, $quantity, $request) {
            $product = Products::query()
                ->where('is_visible', true)
                ->lockForUpdate()
                ->findOrFail($id);

            if ($product->stock < $quantity) {
                return false;
            }

            $cart = Carts::query()
                ->where('user_id', $request->user()->id)
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($cart) {
                $cart->increment('quantity', $quantity);
            } else {
                Carts::create([
                    'user_id' => $request->user()->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ]);
            }

            $product->decrement('stock', $quantity);

            return true;
        });

        if (! $result) {
            return back()->with('error', 'Stok produk tidak cukup.');
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy(Request $request, string $id)
    {
        DB::transaction(function () use ($id, $request) {
            $cart = Carts::query()
                ->where('user_id', $request->user()->id)
                ->lockForUpdate()
                ->findOrFail($id);

            $product = Products::query()
                ->lockForUpdate()
                ->find($cart->product_id);

            if ($product) {
                $product->increment('stock', $cart->quantity);
            }

            $cart->delete();
        });

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
