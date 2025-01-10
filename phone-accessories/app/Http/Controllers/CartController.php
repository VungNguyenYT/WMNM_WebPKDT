<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // Lấy giỏ hàng của người dùng hiện tại
        $cart = Cart::where('user_id', Auth::id())->first();

        // Truyền dữ liệu giỏ hàng đến view `cart.index`
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        // Thêm sản phẩm vào giỏ hàng
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $cartItem = CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return redirect()->route('cart.index');
    }

    public function update(Request $request, $id)
    {
        // Cập nhật số lượng sản phẩm trong giỏ hàng
        $cartItem = CartItem::findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        // Xóa sản phẩm khỏi giỏ hàng
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index');
    }
}
