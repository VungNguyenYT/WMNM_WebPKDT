<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Lấy danh sách đơn hàng của người dùng hiện tại
        $orders = Order::where('user_id', Auth::id())->get();

        // Truyền dữ liệu đến view `orders.index`
        return view('orders.index', compact('orders'));
    }

    public function checkout(Request $request)
    {
        // Xử lý thanh toán và tạo đơn hàng
        $cart = Auth::user()->cart;
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $cart->items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            }),
            'status' => 'pending'
        ]);

        // Chuyển các sản phẩm từ giỏ hàng sang chi tiết đơn hàng
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        // Xóa giỏ hàng sau khi thanh toán
        $cart->items()->delete();

        return redirect()->route('orders.index');
    }
}
