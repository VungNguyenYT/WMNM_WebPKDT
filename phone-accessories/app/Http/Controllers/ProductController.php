<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lọc sản phẩm theo danh mục hoặc từ khóa tìm kiếm
        $query = Product::query();

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        // Truyền dữ liệu đến view `products.index`
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        // Lấy thông tin chi tiết của sản phẩm
        $product = Product::findOrFail($id);

        // Truyền dữ liệu đến view `products.show`
        return view('products.show', compact('product'));
    }
}
