<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy tất cả danh mục sản phẩm
        $categories = Category::all();

        // Truyền dữ liệu đến view `home`
        return view('home', compact('categories'));
    }
}
