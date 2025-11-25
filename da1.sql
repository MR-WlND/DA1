-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 24, 2025 lúc 01:17 PM
-- Phiên bản máy phục vụ: 8.4.3
-- Phiên bản PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `da1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'Khách hàng đặt (FK Users.id)',
  `departure_id` int NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `booking_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Confirmed','Pending','Cancelled') NOT NULL DEFAULT 'Pending',
  `last_status_change` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_customers`
--

CREATE TABLE `booking_customers` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `special_note` varchar(255) DEFAULT NULL,
  `is_checked_in` tinyint(1) DEFAULT '0' COMMENT 'Trạng thái Check-in',
  `room_hotel_name` varchar(100) DEFAULT NULL COMMENT 'Tên khách sạn/phòng đã phân bổ',
  `room_number` varchar(50) DEFAULT NULL COMMENT 'Số phòng cụ thể'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departure_resources`
--

CREATE TABLE `departure_resources` (
  `id` int NOT NULL,
  `departure_id` int NOT NULL,
  `resource_type` enum('guide','hotel','transport','other') NOT NULL,
  `resource_id` int DEFAULT NULL COMMENT 'FK tới Users.id hoặc Hotels.id, v.v.',
  `details` text COMMENT 'Chi tiết dịch vụ/NCC',
  `cost` decimal(10,2) DEFAULT NULL COMMENT 'Chi phí dự kiến'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `destinations`
--

CREATE TABLE `destinations` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `country`) VALUES
(1, 'Sapa', 'Việt Nam'),
(2, 'Hội An', 'Việt Nam'),
(3, 'Phú Quốc', 'Việt Nam'),
(4, 'Seoul', 'Hàn Quốc'),
(5, 'Tokyo', 'Nhật Bản');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `financial_transactions`
--

CREATE TABLE `financial_transactions` (
  `id` int NOT NULL,
  `departure_id` int DEFAULT NULL COMMENT 'Chi tiêu/Thu nhập liên quan đến chuyến đi',
  `transaction_type` enum('Revenue','Expense') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `transaction_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hotels`
--

CREATE TABLE `hotels` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `destination_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

  CREATE TABLE `tours` (
    `id` int NOT NULL,
    `name` varchar(255) NOT NULL,
    `tour_type` enum('Nội địa','Quốc tế') NOT NULL,
    `description` text,
    `base_price` decimal(10,2) NOT NULL COMMENT 'Giá cơ bản trước khuyến mãi',
    `cancellation_policy` text COMMENT 'Chính sách hủy tour',
    `destination_id` int NOT NULL,
    `image` varchar(255) DEFAULT NULL COMMENT 'Đường dẫn ảnh đại diện',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `category_id` int DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`id`, `name`, `tour_type`, `description`, `base_price`, `cancellation_policy`, `destination_id`, `image`, `created_at`, `category_id`) VALUES
(1, 'Tour Hà Nội - Sapa 3 ngày', 'Nội địa', 'Khám phá Sapa với núi non hùng vĩ, bản làng truyền thống.', 3500000.00, 'Hủy trước 7 ngày miễn phí, sau đó mất 50%', 1, 'images/sapa.jpg', '2025-11-20 19:55:42', NULL),
(2, 'Tour Đà Nẵng - Hội An 4 ngày', 'Nội địa', 'Tham quan Đà Nẵng và phố cổ Hội An, trải nghiệm ẩm thực địa phương.', 4200000.00, 'Hủy trước 5 ngày miễn phí, sau đó mất 30%', 2, 'images/hoian.jpg', '2025-11-20 19:55:42', NULL),
(3, 'Tour Phú Quốc 3 ngày', 'Nội địa', 'Thư giãn tại Phú Quốc, khám phá biển đảo và hải sản tươi ngon.', 3800000.00, 'Hủy trước 7 ngày miễn phí, sau đó mất 50%', 3, 'images/phuquoc.jpg', '2025-11-20 19:55:42', NULL),
(4, 'Tour Hàn Quốc 5 ngày', 'Quốc tế', 'Khám phá Seoul, Busan, trải nghiệm văn hóa và ẩm thực Hàn Quốc.', 12000000.00, 'Hủy trước 14 ngày miễn phí, sau đó mất 70%', 4, 'images/korea.jpg', '2025-11-20 19:55:42', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_categories`
--

CREATE TABLE `tour_categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_categories`
--

INSERT INTO `tour_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Tour Khám phá (Exploration)', 'Các tour tập trung vào địa điểm hoang dã, tự nhiên.', '2025-11-22 14:21:05'),
(2, 'Tour Nghỉ dưỡng (Relaxation)', 'Các tour nghỉ ngơi tại resort, bãi biển.', '2025-11-22 14:21:05'),
(3, 'Tour Văn hóa & Lịch sử', 'Các tour tham quan di tích, bảo tàng.', '2025-11-22 14:21:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_departures`
--

CREATE TABLE `tour_departures` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `current_price` decimal(10,2) NOT NULL COMMENT 'Giá bán hiện tại',
  `available_slots` int NOT NULL COMMENT 'Số chỗ còn trống'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_logs`
--

CREATE TABLE `tour_logs` (
  `id` int NOT NULL,
  `departure_id` int NOT NULL,
  `staff_id` int NOT NULL COMMENT 'Người tạo log (FK Users.id)',
  `log_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `log_content` text NOT NULL COMMENT 'Nội dung ghi chú/log',
  `log_type` enum('note','check','expense') NOT NULL DEFAULT 'note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` enum('admin','customer','guide') NOT NULL,
  `hdv_experience` int DEFAULT NULL,
  `hdv_languages` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `phone`, `role`, `hdv_experience`, `hdv_languages`, `created_at`) VALUES
(1, 'longadmin@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'long', '0000000001', 'admin', NULL, NULL, '2025-11-11 14:54:31'),
(2, 'admin@tour.vn', '0192023a7bbd73250516f069df18b500', 'Nguyễn Thị Quản Lý', '0901234567', 'admin', NULL, NULL, '2025-11-20 05:54:49'),
(3, 'admin3@example.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lê Văn C', '0903333333', 'admin', NULL, NULL, '2025-11-20 05:55:48'),
(4, 'admin4@example.com', 'e10adc3949ba59abbe56e057f20f883e', 'Phạm Thị D', '0904444444', 'admin', NULL, NULL, '2025-11-20 05:55:48'),
(5, 'admin5@example.com', 'd41d8cd98f00b204e9800998ecf8427e', 'Hoàng Văn E', '0405555554', 'admin', NULL, NULL, '2025-11-20 05:55:48'),
(6, 'customer1@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Vũ Đình Khách', '0916666666', 'customer', NULL, NULL, '2025-11-20 05:55:48'),
(7, 'customer2@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Thị Hoa', '0917777777', 'customer', NULL, NULL, '2025-11-20 05:55:48'),
(8, 'customer3@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Đinh Văn Nam', '0918888888', 'customer', NULL, NULL, '2025-11-20 05:55:48'),
(9, 'customer4@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Bùi Thanh Tú', '0919999999', 'customer', NULL, NULL, '2025-11-20 05:55:48'),
(10, 'customer5@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lý Ngọc Hân', '0910000000', 'customer', NULL, NULL, '2025-11-20 05:55:48'),
(11, 'guide1@tour.com', '7fa8282ad93047a4d6fe6111c93b308a', 'Phan Hướng Đạo', '0981111111', 'guide', 5, 'Anh, Pháp', '2025-11-20 05:55:48'),
(12, 'guide2@tour.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lê Thị Trinh', '0982222222', 'guide', 2, 'Việt, Anh', '2025-11-20 05:55:48'),
(13, 'guide3@tour.com', 'e10adc3949ba59abbe56e057f20f883e', 'Hoàng Văn Minh', '0983333333', 'guide', 10, 'Anh, Đức, Tây Ban Nha', '2025-11-20 05:55:48'),
(14, 'guide4@tour.com', 'e10adc3949ba59abbe56e057f20f883e', 'Trần Quốc Tuấn', '0984444444', 'guide', 7, 'Anh, Trung', '2025-11-20 05:55:48'),
(15, 'guide5@tour.com', 'e10adc3949ba59abbe56e057f20f883e', 'Đoàn Thị Vân', '0985555555', 'guide', 3, 'Việt, Nhật', '2025-11-20 05:55:48'),
(18, 'long16730z@gmail.com', 'bbb8aae57c104cda40c93843ad5e6db8', 'long', '1111111111', 'customer', NULL, NULL, '2025-11-21 00:41:46');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_booking_user` (`user_id`),
  ADD KEY `fk_booking_departure` (`departure_id`);

--
-- Chỉ mục cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bc_booking` (`booking_id`);

--
-- Chỉ mục cho bảng `departure_resources`
--
ALTER TABLE `departure_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dr_departure` (`departure_id`),
  ADD KEY `fk_dr_resource_user` (`resource_id`);

--
-- Chỉ mục cho bảng `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `financial_transactions`
--
ALTER TABLE `financial_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ft_departure` (`departure_id`);

--
-- Chỉ mục cho bảng `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hotel_destination` (`destination_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_booking` (`booking_id`);

--
-- Chỉ mục cho bảng `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tours_destination` (`destination_id`),
  ADD KEY `fk_tour_category` (`category_id`);

--
-- Chỉ mục cho bảng `tour_categories`
--
ALTER TABLE `tour_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `tour_departures`
--
ALTER TABLE `tour_departures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_td_tour` (`tour_id`);

--
-- Chỉ mục cho bảng `tour_logs`
--
ALTER TABLE `tour_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tl_departure` (`departure_id`),
  ADD KEY `fk_tl_staff` (`staff_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `departure_resources`
--
ALTER TABLE `departure_resources`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `financial_transactions`
--
ALTER TABLE `financial_transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `tour_categories`
--
ALTER TABLE `tour_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tour_departures`
--
ALTER TABLE `tour_departures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tour_logs`
--
ALTER TABLE `tour_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_booking_departure` FOREIGN KEY (`departure_id`) REFERENCES `tour_departures` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  ADD CONSTRAINT `fk_bc_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `departure_resources`
--
ALTER TABLE `departure_resources`
  ADD CONSTRAINT `fk_dr_departure` FOREIGN KEY (`departure_id`) REFERENCES `tour_departures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dr_resource_user` FOREIGN KEY (`resource_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `financial_transactions`
--
ALTER TABLE `financial_transactions`
  ADD CONSTRAINT `fk_ft_departure` FOREIGN KEY (`departure_id`) REFERENCES `tour_departures` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `fk_hotel_destination` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `fk_tour_category` FOREIGN KEY (`category_id`) REFERENCES `tour_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tours_destination` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tour_departures`
--
ALTER TABLE `tour_departures`
  ADD CONSTRAINT `fk_td_tour` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tour_logs`
--
ALTER TABLE `tour_logs`
  ADD CONSTRAINT `fk_tl_departure` FOREIGN KEY (`departure_id`) REFERENCES `tour_departures` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tl_staff` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
