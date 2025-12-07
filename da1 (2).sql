-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 07, 2025 lúc 02:02 AM
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

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `departure_id`, `total_price`, `booking_date`, `status`, `last_status_change`) VALUES
(2, 12, 174, 122222.00, '2025-11-30 23:36:47', 'Confirmed', '2025-11-30 23:46:43'),
(3, 13, 120, 1850000.00, '2025-12-06 00:38:53', 'Confirmed', '2025-12-06 00:38:53'),
(4, 20, 163, 212312.00, '2025-12-06 01:07:53', 'Pending', '2025-12-06 01:07:53');

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

--
-- Đang đổ dữ liệu cho bảng `booking_customers`
--

INSERT INTO `booking_customers` (`id`, `booking_id`, `name`, `phone`, `special_note`, `is_checked_in`, `room_hotel_name`, `room_number`) VALUES
(1, 4, 'zxcx', '232131', 'sdas', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `custom_tour_quotes`
--

CREATE TABLE `custom_tour_quotes` (
  `id` int NOT NULL,
  `request_id` int NOT NULL COMMENT 'FK tới custom_tour_requests.id',
  `staff_id` int DEFAULT NULL COMMENT 'Admin/Staff tạo báo giá (FK tới users.id)',
  `quote_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `valid_until` date DEFAULT NULL COMMENT 'Báo giá có hiệu lực đến ngày',
  `final_price` decimal(12,2) NOT NULL,
  `itinerary_draft` text COMMENT 'Tóm tắt lịch trình đề xuất',
  `quote_status` enum('Sent','Revised','Accepted','Rejected') NOT NULL DEFAULT 'Sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `custom_tour_requests`
--

CREATE TABLE `custom_tour_requests` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL COMMENT 'FK tới users.id nếu khách hàng đã đăng nhập (NULL nếu đặt qua điện thoại)',
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `num_people` int NOT NULL,
  `desired_start_date` date DEFAULT NULL,
  `destination_notes` text COMMENT 'Ghi chú về địa điểm, sở thích',
  `budget_range` decimal(12,2) DEFAULT NULL COMMENT 'Ngân sách dự kiến',
  `request_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `request_status` enum('New','Quoting','Accepted','Rejected','Closed') NOT NULL DEFAULT 'New'
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

--
-- Đang đổ dữ liệu cho bảng `departure_resources`
--

INSERT INTO `departure_resources` (`id`, `departure_id`, `resource_type`, `resource_id`, `details`, `cost`) VALUES
(1, 163, 'guide', 13, '1', 111.00),
(2, 163, 'hotel', 1, 'q', 2122.00),
(3, 163, 'hotel', 1, 'ass', 2212.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `destinations`
--

CREATE TABLE `destinations` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `type` enum('City','Country','Region') DEFAULT 'City'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `country`, `type`) VALUES
(3, 'Phú Quốc', 'Việt Nam', 'City'),
(4, 'Seoul', 'Hàn Quốc', 'City'),
(5, 'Tokyo', 'Nhật Bản', 'City'),
(6, 'Sapa', 'Việt Nam', 'City');

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
-- Cấu trúc bảng cho bảng `guide_profiles`
--

CREATE TABLE `guide_profiles` (
  `user_id` int NOT NULL,
  `category` enum('domestic','international') DEFAULT 'domestic',
  `specialty_route` varchar(255) DEFAULT NULL,
  `specialty_group` enum('corporate','leisure','vip','standard') DEFAULT 'standard',
  `certification` text,
  `health_status` text,
  `notes` text,
  `date_of_birth` date DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `experience_years` int DEFAULT NULL,
  `languages` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `guide_profiles`
--

INSERT INTO `guide_profiles` (`user_id`, `category`, `specialty_route`, `specialty_group`, `certification`, `health_status`, `notes`, `date_of_birth`, `photo_url`, `experience_years`, `languages`) VALUES
(11, 'international', 'Tuyến miền Bắc (Hà Nội, Sapa, Hạ Long)', 'vip', 'Chứng chỉ HDV Quốc tế', 'Tốt', NULL, '1985-05-20', 'avatar/1764270881-Ảnh chụp màn hình 2025-04-24 183748.png', 15, 'Tiếng Anh, Tiếng Pháp'),
(12, 'domestic', 'Tuyến miền Trung', 'leisure', 'Chứng chỉ HDV Nội địa', 'Tốt', NULL, '1992-11-01', 'avatar/1764270873-ai-la-nguoi-dam-me-nhung-bau-troi-dem-day-sao-dep-den-nao-long-nao.jpg', 8, 'Tiếng Anh, Tiếng Nhật'),
(13, 'domestic', 'Tuyến TP.HCM và Đồng bằng Sông Cửu Long', 'standard', 'Chứng chỉ HDV Nội địa', 'Cần theo dõi dị ứng', '<br />\r\n<b>Deprecated</b>:  htmlspecialchars(): Passing null to parameter #1 ($string) of type string is deprecated in <b>D:\\laragon\\www\\DA1\\Base\\views\\admin\\guides\\update-guide.php</b> on line <b>77</b><br />\r\n', '2000-03-15', 'avatar/1764270864-ai-la-nguoi-dam-me-nhung-bau-troi-dem-day-sao-dep-den-nao-long-nao.jpg', 2, 'Tiếng Việt'),
(30, 'international', 'ád', 'corporate', 'Chứng chỉ HDV Nội địa', 'Cần theo dõi dị ứng', 'qqqq', '2025-11-22', 'avatar/1764338792-ai-la-nguoi-dam-me-nhung-bau-troi-dem-day-sao-dep-den-nao-long-nao.jpg', 2, 'aaaa');

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

--
-- Đang đổ dữ liệu cho bảng `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `address`, `destination_id`) VALUES
(1, 'Sapa Heaven Hotel', '45 Phan Si Păng, Sapa', 6),
(2, 'Sunset Beach Resort', 'Bãi Dài, Gành Dầu, Phú Quốc', 3),
(3, 'Phu Quoc Luxury Villa', 'Trần Hưng Đạo, Dương Tơ', 3),
(4, 'Gangnam Stay Inn', 'Teheran-ro, Gangnam-gu, Seoul', 4),
(5, 'Muong Thanh Holiday Sapa', 'Thạch Sơn, Sapa', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `itinerary_details`
--

CREATE TABLE `itinerary_details` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL COMMENT 'FK tới tours.id',
  `day_number` int NOT NULL COMMENT 'Ngày thứ mấy của tour (1, 2, 3...)',
  `time_slot` time DEFAULT NULL COMMENT 'Thời gian cụ thể của hoạt động (HH:MM)',
  `activity` varchar(255) NOT NULL COMMENT 'Mô tả chi tiết hoạt động/điểm dừng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `itinerary_details`
--

INSERT INTO `itinerary_details` (`id`, `tour_id`, `day_number`, `time_slot`, `activity`) VALUES
(1, 41, 1, '23:28:00', 'aaa'),
(2, 41, 2, '10:26:00', 'fffff'),
(9, 42, 1, '00:19:00', 'aaaa'),
(28, 40, 1, '01:10:00', 'dad'),
(36, 44, 1, '16:38:00', 'aaa'),
(37, 43, 1, '11:40:00', 'aaa'),
(38, 43, 2, '14:38:00', 'fffff');

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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int DEFAULT NULL,
  `tour_origin` enum('Catalog','Custom') DEFAULT 'Catalog',
  `cancellation_policy_text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`id`, `name`, `tour_type`, `description`, `base_price`, `created_at`, `category_id`, `tour_origin`, `cancellation_policy_text`) VALUES
(1, 'Tour Hà Nội - Sapa 3 ngày', 'Nội địa', 'Khám phá Sapa với núi non hùng vĩ, bản làng truyền thống.', 3500000.00, '2025-11-20 19:55:42', 1, 'Catalog', NULL),
(2, 'Tour Đà Nẵng - Hội An 4 ngày', 'Nội địa', 'Tham quan Đà Nẵng và phố cổ Hội An, trải nghiệm ẩm thực địa phương.', 4200000.00, '2025-11-20 19:55:42', 2, 'Catalog', NULL),
(3, 'Tour Phú Quốc 3 ngày', 'Nội địa', 'Thư giãn tại Phú Quốc, khám phá biển đảo và hải sản tươi ngon.', 3800000.00, '2025-11-20 19:55:42', 2, 'Catalog', NULL),
(40, 'Tour Phú Quốc 3 ngày', 'Nội địa', 'dddddddd', 22222222.00, '2025-12-06 12:00:55', 1, 'Catalog', NULL),
(41, 'Tour Phú Quốc 3 ngàyy', 'Nội địa', 'qqqqqqqqq', 111111.00, '2025-12-06 13:25:35', 2, 'Custom', NULL),
(42, 'long', 'Nội địa', 'aaaaaaaaaaaaaaaa', 2222222.00, '2025-12-06 14:16:21', 1, 'Custom', NULL),
(43, 'Tour Phú Quốc 3 ngày', 'Nội địa', 'dddddd', 11111.00, '2025-12-06 15:40:03', 2, 'Catalog', 'qqqqqqqqqqqqq111111111111111        '),
(44, 'long', 'Nội địa', 'qqqqq', 1.00, '2025-12-06 19:36:19', 1, 'Catalog', '11111   ');

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

--
-- Đang đổ dữ liệu cho bảng `tour_departures`
--

INSERT INTO `tour_departures` (`id`, `tour_id`, `start_date`, `end_date`, `current_price`, `available_slots`) VALUES
(119, 3, '2026-01-20', '2026-01-22', 1900000.00, 15),
(120, 3, '2026-03-10', '2026-03-12', 1850000.00, 10),
(163, 1, '2025-11-20', '2025-11-30', 212312.00, 0),
(164, 1, '2026-04-30', '2026-05-05', 5500000.00, 20),
(174, 2, '2026-03-05', '2026-03-08', 8200000.00, 2),
(199, 41, '2025-12-12', '2025-12-07', 11111.00, 2),
(206, 42, '2025-12-05', '2025-12-16', 1111111.00, 2),
(218, 40, '2025-12-25', '2025-12-25', 2.00, 3),
(219, 40, '2025-12-25', '2025-12-25', 2.00, 3),
(227, 44, '2025-12-20', '2026-01-03', 1111.00, 1),
(228, 43, '2025-12-19', '2025-12-26', 12.00, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_destinations`
--

CREATE TABLE `tour_destinations` (
  `tour_id` int NOT NULL,
  `destination_id` int NOT NULL,
  `order_number` int NOT NULL COMMENT 'Thứ tự điểm đến trong Tour',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_destinations`
--

INSERT INTO `tour_destinations` (`tour_id`, `destination_id`, `order_number`, `id`) VALUES
(1, 3, 2, 1),
(1, 4, 1, 2),
(2, 4, 1, 3),
(3, 3, 2, 4),
(41, 3, 1, 6),
(41, 4, 2, 7),
(42, 4, 1, 15),
(42, 3, 2, 16),
(40, 4, 3, 37),
(44, 4, 1, 48),
(44, 3, 2, 49),
(43, 3, 1, 50),
(43, 3, 2, 51);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_images`
--

CREATE TABLE `tour_images` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL COMMENT 'FK tới tours.id',
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Đường dẫn tệp ảnh sau khi upload',
  `is_featured` tinyint(1) DEFAULT '0' COMMENT '1 nếu đây là ảnh đại diện chính (Cover Photo)',
  `order_number` int DEFAULT '0' COMMENT 'Thứ tự hiển thị trong Gallery'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_images`
--

INSERT INTO `tour_images` (`id`, `tour_id`, `image_url`, `is_featured`, `order_number`) VALUES
(19, 3, 'tours_gallery/1764422574692af3ae7c6fa.jpg', 1, 1),
(83, 1, 'tours_gallery/1764428927692b0c7fcf073.png', 1, 1),
(84, 1, 'tours_gallery/1764428927692b0c7fd1b90.png', 0, 2),
(92, 2, 'tours_gallery/1764428907692b0c6b2fb5b.jpg', 1, 1),
(149, 41, 'tours_gallery/176502753569342ecf860f3.jpg', 1, 1),
(156, 42, 'tours_gallery/176503058169343ab5ea4a3.jpg', 1, 1),
(167, 40, 'tours_gallery/176502245569341af7ca998.jpg', 1, 1),
(175, 44, 'tours_gallery/1765049779693485b30b445.jpg', 1, 1),
(176, 43, 'tours_gallery/176503560369344e53218a2.jpg', 1, 1);

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
-- Cấu trúc bảng cho bảng `transport_suppliers`
--

CREATE TABLE `transport_suppliers` (
  `id` int NOT NULL,
  `supplier_name` varchar(150) NOT NULL COMMENT 'Tên công ty vận tải',
  `contact_person` varchar(100) DEFAULT NULL COMMENT 'Người liên hệ chính',
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `details` text COMMENT 'Ghi chú về đội xe, hợp đồng',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `transport_suppliers`
--

INSERT INTO `transport_suppliers` (`id`, `supplier_name`, `contact_person`, `phone`, `email`, `details`, `created_at`) VALUES
(2, 'ád', 'ddddddd', 'dqew12312312', 'longadmin@gmail.com', 'sadasd', '2025-11-30 15:56:44');

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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `phone`, `role`, `created_at`) VALUES
(1, 'longadmin@gmail.com', '1bbd886460827015e5d605ed44252251', 'long', '0000000001', 'admin', '2025-11-11 14:54:31'),
(2, 'admin@tour.vn', '0192023a7bbd73250516f069df18b500', 'Nguyễn Thị Quản Lý', '0901234567', 'admin', '2025-11-20 05:54:49'),
(3, 'admin3@example.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lê Văn C', '0903333333', 'admin', '2025-11-20 05:55:48'),
(4, 'admin4@example.com', 'e10adc3949ba59abbe56e057f20f883e', 'Phạm Thị D', '0904444444', 'admin', '2025-11-20 05:55:48'),
(5, 'admin5@example.com', 'd41d8cd98f00b204e9800998ecf8427e', 'Hoàng Văn E', '0405555554', 'admin', '2025-11-20 05:55:48'),
(6, 'customer1@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Vũ Đình Khách', '0916666666', 'customer', '2025-11-20 05:55:48'),
(7, 'customer2@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Thị Hoa', '0917777777', 'customer', '2025-11-20 05:55:48'),
(8, 'customer3@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Đinh Văn Nam', '0918888888', 'customer', '2025-11-20 05:55:48'),
(9, 'customer4@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Bùi Thanh Tú', '0919999999', 'customer', '2025-11-20 05:55:48'),
(10, 'customer5@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lý Ngọc Hân', '0910000000', 'customer', '2025-11-20 05:55:48'),
(11, 'guide1@tour.com', '7fa8282ad93047a4d6fe6111c93b308a', 'Phan Hướng Đạo', '0981111111', 'guide', '2025-11-20 05:55:48'),
(12, 'guide2@tour.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lê Thị Trinh', '0982222222', 'guide', '2025-11-20 05:55:48'),
(13, 'guide3@tour.com', 'e10adc3949ba59abbe56e057f20f883e', 'Hoàng Văn Minh', '0983333333', 'guide', '2025-11-20 05:55:48'),
(20, 'a@gmail.com', '$2y$10$f.szHT0LJ1eSPHWXTPRlw.RRJreg0Ypj2Z/AFKXzgrb7qxzYuulc6', 'sad', '4234234234', 'guide', '2025-11-27 17:21:29'),
(21, 'aw@gmail.com', '$2y$10$9tkin/a8h8gG/YR/Zx17pe7xYtCr7hQXh3aRY7La0wUTuhcCGfz0O', 'sad', '4234234234', 'guide', '2025-11-27 17:21:47'),
(30, 'duongv@gmail.com', '1bbd886460827015e5d605ed44252251', 'Nhật Long', '0866939060', 'guide', '2025-11-28 14:06:32');

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
-- Chỉ mục cho bảng `custom_tour_quotes`
--
ALTER TABLE `custom_tour_quotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Chỉ mục cho bảng `custom_tour_requests`
--
ALTER TABLE `custom_tour_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- Chỉ mục cho bảng `guide_profiles`
--
ALTER TABLE `guide_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hotel_destination` (`destination_id`);

--
-- Chỉ mục cho bảng `itinerary_details`
--
ALTER TABLE `itinerary_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

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
-- Chỉ mục cho bảng `tour_destinations`
--
ALTER TABLE `tour_destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `tour_destinations_ibfk_1` (`tour_id`);

--
-- Chỉ mục cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `tour_logs`
--
ALTER TABLE `tour_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tl_departure` (`departure_id`),
  ADD KEY `fk_tl_staff` (`staff_id`);

--
-- Chỉ mục cho bảng `transport_suppliers`
--
ALTER TABLE `transport_suppliers`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `custom_tour_quotes`
--
ALTER TABLE `custom_tour_quotes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `custom_tour_requests`
--
ALTER TABLE `custom_tour_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `departure_resources`
--
ALTER TABLE `departure_resources`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `financial_transactions`
--
ALTER TABLE `financial_transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `itinerary_details`
--
ALTER TABLE `itinerary_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `tour_categories`
--
ALTER TABLE `tour_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tour_departures`
--
ALTER TABLE `tour_departures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT cho bảng `tour_destinations`
--
ALTER TABLE `tour_destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT cho bảng `tour_logs`
--
ALTER TABLE `tour_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `transport_suppliers`
--
ALTER TABLE `transport_suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
-- Các ràng buộc cho bảng `custom_tour_quotes`
--
ALTER TABLE `custom_tour_quotes`
  ADD CONSTRAINT `custom_tour_quotes_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `custom_tour_requests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `custom_tour_quotes_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `custom_tour_requests`
--
ALTER TABLE `custom_tour_requests`
  ADD CONSTRAINT `custom_tour_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
-- Các ràng buộc cho bảng `guide_profiles`
--
ALTER TABLE `guide_profiles`
  ADD CONSTRAINT `guide_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `fk_hotel_destination` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `itinerary_details`
--
ALTER TABLE `itinerary_details`
  ADD CONSTRAINT `itinerary_details_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `fk_tour_category` FOREIGN KEY (`category_id`) REFERENCES `tour_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tour_departures`
--
ALTER TABLE `tour_departures`
  ADD CONSTRAINT `fk_td_tour` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tour_destinations`
--
ALTER TABLE `tour_destinations`
  ADD CONSTRAINT `tour_destinations_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tour_destinations_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  ADD CONSTRAINT `tour_images_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
