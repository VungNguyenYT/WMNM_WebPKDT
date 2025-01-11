-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 11, 2025 lúc 07:13 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mnm_pkdt`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-01-10 15:41:38', '2025-01-10 15:41:38'),
(2, 3, '2025-01-10 15:41:38', '2025-01-10 15:41:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '2025-01-10 15:41:46', '2025-01-10 15:41:46'),
(2, 1, 2, 1, '2025-01-10 15:41:46', '2025-01-10 15:41:46'),
(3, 2, 3, 3, '2025-01-10 15:41:46', '2025-01-10 15:41:46'),
(4, 2, 5, 1, '2025-01-10 15:41:46', '2025-01-10 15:41:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Ốp lưng', '2025-01-10 15:40:27', '2025-01-10 15:40:27'),
(2, 'Kính cường lực', '2025-01-10 15:40:27', '2025-01-10 15:40:27'),
(3, 'Cáp sạc', '2025-01-10 15:40:27', '2025-01-10 15:40:27'),
(4, 'Pin dự phòng', '2025-01-10 15:40:27', '2025-01-10 15:40:27'),
(5, 'Tai nghe', '2025-01-10 15:40:27', '2025-01-10 15:40:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_orders`
--

CREATE TABLE `customer_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `payment_method` enum('COD','BANK') NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customer_orders`
--

INSERT INTO `customer_orders` (`id`, `user_id`, `full_name`, `phone`, `address`, `payment_method`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 8, 'Nguyễn Văn Vửng', '0347482012', 'aa', 'COD', '1200000.00', '2025-01-10 22:22:39', '2025-01-10 22:22:39'),
(2, 5, 'Nguyễn Văn Vửng', '0347482012', 'aa', 'COD', '1800000.00', '2025-01-11 05:52:33', '2025-01-11 05:52:33'),
(3, 5, 'Nguyễn Văn Vửng', '0347482012', 'test', 'BANK', '150000.00', '2025-01-11 05:54:22', '2025-01-11 05:54:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_order_items`
--

CREATE TABLE `customer_order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customer_order_items`
--

INSERT INTO `customer_order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 3, 1, '250000.00', '250000.00'),
(2, 1, 8, 2, '300000.00', '600000.00'),
(3, 1, 1, 1, '350000.00', '350000.00'),
(4, 2, 2, 12, '150000.00', '1800000.00'),
(5, 3, 2, 1, '150000.00', '150000.00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, '850000.00', 'completed', '2025-01-10 15:41:55', '2025-01-10 15:41:55'),
(2, 3, '950000.00', 'pending', '2025-01-10 15:41:55', '2025-01-10 15:41:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '350000.00', '2025-01-10 15:42:14', '2025-01-10 15:42:14'),
(2, 1, 2, 1, '150000.00', '2025-01-10 15:42:14', '2025-01-10 15:42:14'),
(3, 2, 3, 3, '250000.00', '2025-01-10 15:42:14', '2025-01-10 15:42:14'),
(4, 2, 5, 1, '300000.00', '2025-01-10 15:42:14', '2025-01-10 15:42:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` text DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `stock`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Ốp lưng iPhone 13 Spigen', 'Ốp lưng chống sốc, thiết kế hiện đại.', '350000.00', 'oplung_iphone13.jpg', 50, 1, '2025-01-10 15:41:22', '2025-01-10 15:41:22'),
(2, 'Kính cường lực Nillkin', 'Bảo vệ màn hình tối ưu, độ trong suốt cao.', '150000.00', 'kinhcuongluc_nillkin.jpg', 100, 2, '2025-01-10 15:41:22', '2025-01-10 15:41:22'),
(3, 'Cáp sạc Anker PowerLine+', 'Cáp sạc bền bỉ, hỗ trợ sạc nhanh.', '250000.00', 'capsac_anker.jpg', 70, 3, '2025-01-10 15:41:22', '2025-01-10 15:41:22'),
(4, 'Pin dự phòng Xiaomi 20000mAh', 'Hỗ trợ sạc nhanh QC 3.0.', '450000.00', 'pinduphong_xiaomi.jpg', 30, 4, '2025-01-10 15:41:22', '2025-01-10 15:41:22'),
(5, 'Tai nghe JBL T110', 'Tai nghe chất lượng âm thanh cao.', '300000.00', 'tainghe_jbl.jpg', 40, 5, '2025-01-10 15:41:22', '2025-01-10 15:41:22'),
(7, 'Ốp lưng Samsung S22 Ultra UAG', 'Ốp chống va đập cao cấp.', '500000.00', 'oplung_samsung_uag.jpg', 30, 1, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(8, 'Ốp lưng iPhone 14 Pro Max Nillkin', 'Ốp siêu mỏng, chất liệu nhựa dẻo.', '300000.00', 'oplung_iphone14_nillkin.jpg', 40, 1, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(9, 'Ốp lưng Xiaomi Redmi Note 12 Ringke', 'Thiết kế trong suốt, thời trang.', '250000.00', 'oplung_xiaomi_ringke.jpg', 60, 1, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(10, 'Kính cường lực iPhone 13 Nillkin', 'Bảo vệ tối ưu, chống xước.', '150000.00', 'kinhcuongluc_iphone13.jpg', 100, 2, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(11, 'Kính cường lực Samsung A73', 'Chống trầy xước, dễ dán.', '120000.00', 'kinhcuongluc_samsung_a73.jpg', 80, 2, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(12, 'Kính cường lực Oppo Reno 8', 'Siêu bền, trong suốt.', '140000.00', 'kinhcuongluc_oppo_reno8.jpg', 90, 2, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(13, 'Kính cường lực Xiaomi Poco X5 Pro', 'Chống va đập, bảo vệ hiệu quả.', '130000.00', 'kinhcuongluc_xiaomi_poco.jpg', 70, 2, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(14, 'Cáp sạc Anker PowerLine+', 'Cáp sạc bền bỉ, hỗ trợ sạc nhanh.', '250000.00', 'capsac_anker.jpg', 70, 3, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(15, 'Cáp sạc Baseus USB-C to Lightning', 'Tương thích iPhone, sạc nhanh.', '200000.00', 'capsac_baseus.jpg', 60, 3, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(16, 'Cáp sạc Samsung chính hãng', 'Cáp bền, tốc độ truyền tải cao.', '180000.00', 'capsac_samsung.jpg', 90, 3, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(17, 'Cáp sạc Xiaomi Mi 10W', 'Giá rẻ, phù hợp nhiều thiết bị.', '100000.00', 'capsac_xiaomi.jpg', 100, 3, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(18, 'Pin dự phòng Xiaomi 20000mAh', 'Hỗ trợ sạc nhanh QC 3.0.', '450000.00', 'pinduphong_xiaomi.jpg', 30, 4, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(19, 'Pin dự phòng Anker PowerCore 10000mAh', 'Thiết kế nhỏ gọn, tiện lợi.', '400000.00', 'pinduphong_anker.jpg', 50, 4, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(20, 'Pin dự phòng Baseus 30000mAh', 'Dung lượng lớn, nhiều cổng sạc.', '600000.00', 'pinduphong_baseus.jpg', 20, 4, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(21, 'Pin dự phòng Samsung 15000mAh', 'Sạc nhanh, thiết kế chắc chắn.', '420000.00', 'pinduphong_samsung.jpg', 25, 4, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(22, 'Tai nghe JBL T110', 'Tai nghe chất lượng âm thanh cao.', '300000.00', 'tainghe_jbl.jpg', 40, 5, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(23, 'Tai nghe Sony WH-CH510', 'Tai nghe không dây, âm thanh sống động.', '800000.00', 'tainghe_sony.jpg', 30, 5, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(24, 'Tai nghe Xiaomi Redmi AirDots 3', 'Tai nghe không dây giá rẻ.', '500000.00', 'tainghe_xiaomi.jpg', 50, 5, '2025-01-10 15:42:58', '2025-01-10 15:42:58'),
(25, 'Tai nghe Apple AirPods Pro', 'Chống ồn chủ động, chất âm tuyệt vời.', '4900000.00', 'tainghe_airpods.jpg', 20, 5, '2025-01-10 15:42:58', '2025-01-10 15:42:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(2, 'Trần Thị Tuyết', 'user1', 'hashed_password_456', '0912345678', 'user', '2025-01-10 15:37:32', '2025-01-10 15:37:32'),
(3, 'Lê Văn C', 'user2', 'hashed_password_789', '0923456789', 'user', '2025-01-10 15:37:32', '2025-01-10 15:37:32'),
(4, 'Nguyễn Văn A', 'admin', 'hashed_password_123', '0901234567', 'admin', '2025-01-10 15:39:38', '2025-01-10 15:39:38'),
(5, 'Nguyễn Văn Vửng', 'VungNguyenYT', '$2y$10$0Yqa89JMnAqoL56Fi8O1BO9iirpkMmgUS0sHFJ0tnBscaku2408Km', '0347482012', 'user', '2025-01-10 14:48:49', '2025-01-10 14:48:49'),
(7, 'Admin User', 'admin1', '$2y$10$e0NRvEiFbB6xeDwKnUIoSOaDdsjoP3Dr5RA9dpb1ixlXsWT3WtLWm', '0123456789', 'admin', '2025-01-10 21:00:47', '2025-01-10 21:00:47'),
(8, 'Nguyễn Văn Vửng', 'admin001', '$2y$10$Xf7WTGka/jvJNaiTw1AnFOuuubkqCL1Izvkzk3/qaNqJU861P4aum', '0347482012', 'admin', '2025-01-10 15:09:06', '2025-01-10 15:09:06');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer_order_items`
--
ALTER TABLE `customer_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `customer_orders`
--
ALTER TABLE `customer_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `customer_order_items`
--
ALTER TABLE `customer_order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `customer_order_items`
--
ALTER TABLE `customer_order_items`
  ADD CONSTRAINT `customer_order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `customer_orders` (`id`),
  ADD CONSTRAINT `customer_order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
