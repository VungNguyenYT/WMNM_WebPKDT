<!DOCTYPE html>
<html>

<head>
    <title>Trang chủ</title>
</head>

<body>
    <h1>Chào mừng đến với website bán phụ kiện điện thoại</h1>
    <form action="/products" method="GET">
        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm...">
        <button type="submit">Tìm kiếm</button>
    </form>

    <h2>Danh mục sản phẩm</h2>
    <ul>
        @foreach ($categories as $category)
            <li><a href="/products?category={{ $category->id }}">{{ $category->name }}</a></li>
        @endforeach
    </ul>
</body>

</html>