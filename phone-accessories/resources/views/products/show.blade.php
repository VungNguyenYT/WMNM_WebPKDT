<!DOCTYPE html>
<html>

<head>
    <title>{{ $product->name }}</title>
</head>

<body>
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>
    <p>Giá: {{ $product->price }} VND</p>
    <form action="/cart/add" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <label for="quantity">Số lượng:</label>
        <input type="number" name="quantity" value="1" min="1">
        <button type="submit">Thêm vào giỏ hàng</button>
    </form>
</body>

</html>