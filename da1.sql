-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 10, 2025 lúc 04:43 PM
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
  `payment_status` enum('Pending','Paid','Failed') NOT NULL DEFAULT 'Pending',
  `last_status_change` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `departure_id`, `total_price`, `booking_date`, `payment_status`, `last_status_change`, `transaction_id`, `payment_date`) VALUES
(2, 12, 174, 122222.00, '2025-11-30 23:36:47', 'Pending', '2025-11-30 23:46:43', NULL, NULL),
(3, 13, 120, 1850000.00, '2025-12-06 00:38:53', 'Paid', '2025-12-07 17:35:32', '12222222', '2025-12-07 17:35:32'),
(4, 20, 163, 212312.00, '2025-12-06 01:07:53', 'Paid', '2025-12-07 17:30:46', '213456', '2025-12-07 17:30:46'),
(5, 1, 219, 1000000.00, '2025-12-07 17:44:00', 'Paid', '2025-12-10 23:00:39', '11111', '2025-12-07 18:03:05'),
(6, 12, 174, 8200000.00, '2025-12-07 19:42:47', 'Pending', '2025-12-07 19:42:47', NULL, NULL),
(8, 11, 119, 1900000.00, '2025-12-07 19:45:02', 'Pending', '2025-12-07 19:58:13', NULL, NULL),
(9, 1, 233, 36.00, '2025-12-07 23:08:13', 'Paid', '2025-12-07 23:08:51', 'aaa', '2025-12-07 23:08:51');

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
  `room_number` varchar(50) DEFAULT NULL COMMENT 'Số phòng cụ thể',
  `date_of_birth` date DEFAULT NULL COMMENT 'Ngày sinh của khách hàng đi kèm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_customers`
--

INSERT INTO `booking_customers` (`id`, `booking_id`, `name`, `phone`, `special_note`, `is_checked_in`, `room_hotel_name`, `room_number`, `date_of_birth`) VALUES
(1, 4, 'zxcx', '232131', 'sdas', 0, NULL, NULL, NULL),
(2, 5, 'gfxgfxf', '123213', 'asd', 0, NULL, NULL, NULL),
(4, 8, 'ưqewqe', '123213', 'qqqq', 0, NULL, NULL, '2025-12-25'),
(5, 9, 'gfxgfxf', '123213', 'asd', 0, NULL, NULL, '2025-12-24'),
(6, 9, 'qưeqwe', '123123', 'ư', 0, NULL, NULL, '2025-12-10'),
(7, 9, '123wqda', '213123', 'ww', 0, NULL, NULL, '2025-12-17');

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

--
-- Đang đổ dữ liệu cho bảng `custom_tour_quotes`
--

INSERT INTO `custom_tour_quotes` (`id`, `request_id`, `staff_id`, `quote_date`, `valid_until`, `final_price`, `itinerary_draft`, `quote_status`) VALUES
(1, 2, 6, '2025-12-07 10:46:23', '2025-12-20', 12222.00, 'ádsad', 'Sent'),
(2, 1, 6, '2025-12-07 10:54:57', '2025-12-05', 22222222.00, 'ádsad', 'Sent'),
(3, 3, 6, '2025-12-07 10:55:16', '2025-12-26', 222.00, 'sadad', 'Sent'),
(4, 5, 6, '2025-12-07 11:02:42', '2026-01-03', 1111.00, 'aaaa', 'Sent'),
(5, 8, 1, '2025-12-08 08:32:32', '2025-12-27', 11.00, 'ưqe', 'Sent'),
(6, 8, 1, '2025-12-09 21:07:35', '2025-12-11', 11111.00, '1qqq', 'Sent');

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

--
-- Đang đổ dữ liệu cho bảng `custom_tour_requests`
--

INSERT INTO `custom_tour_requests` (`id`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `num_people`, `desired_start_date`, `destination_notes`, `budget_range`, `request_date`, `request_status`) VALUES
(1, 6, 'Nhật Long', 'long16730z@gmail.com', '0866939060', 2, '2025-12-20', '                                              sapa                                                                       ', 30.00, '2025-12-07 10:06:30', 'Quoting'),
(2, 1, 'Nhật Long', 'long16730z@gmail.com', '0866939060', 2, '2025-12-20', '                                              sapa                                                                       ', 30.00, '2025-12-07 10:22:33', 'Quoting'),
(3, 6, 'Nhật Long', 'long16730z@gmail.com', '0866939060', 1, '2025-12-20', '                          ddddd             ', 2222.00, '2025-12-07 10:54:38', 'Quoting'),
(4, 6, 'Nhật Long', 'long16730z@gmail.com', '0866939060', 1, '2025-12-20', '                          ddddd             ', 2222.00, '2025-12-07 10:55:22', 'New'),
(5, 6, 'Nhật Long', 'long16730z@gmail.com', '0866939060', 1, '2025-12-20', '                          ddddd             ', 2222.00, '2025-12-07 10:55:33', 'Quoting'),
(6, 6, 'Nhật Long', 'long16730z@gmail.com', '0866939060', 1, '2025-12-20', '                          ddddd             ', 2222.00, '2025-12-07 11:02:48', 'New'),
(7, 6, 'Nhật Long', 'long16730z@gmail.com', '0866939060', 1, '2025-12-25', '                                      eeee ', 111.00, '2025-12-07 11:08:00', 'New'),
(8, 6, 'Nhật Long', 'long16730z@gmail.com', '0866939060', 1, '2025-12-25', '                                      eeee ', 111.00, '2025-12-07 11:11:18', 'Quoting');

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
(1, 163, 'guide', 13, '11', 111.00),
(2, 163, 'hotel', 1, 'q', 2122.00),
(3, 163, 'hotel', 1, 'ass', 2212.00),
(4, 163, 'guide', 30, 'ưqewqe', 1222.00),
(8, 163, 'guide', 13, '11111', 11111.00);

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
(47, 43, 1, '11:40:00', 'aaa'),
(48, 43, 2, '14:38:00', 'fffff'),
(49, 43, 3, '15:10:00', 'aaa'),
(52, 47, 1, '10:03:00', 'aaa'),
(53, 47, 2, '00:04:00', 'fffff');

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
(1, 'Tour Hà Nội - Sapa 3 ngày', 'Nội địa', 'Khám phá Sapa với núi non hùng vĩ, bản làng truyền thống.', 3500000.00, '2025-11-20 19:55:42', 1, 'Catalog', '                                    '),
(2, 'Tour Đà Nẵng - Hội An 4 ngày', 'Nội địa', 'Tham quan Đà Nẵng và phố cổ Hội An, trải nghiệm ẩm thực địa phương.', 4200000.00, '2025-11-20 19:55:42', 2, 'Catalog', NULL),
(3, 'Tour Phú Quốc 3 ngày', 'Nội địa', 'Thư giãn tại Phú Quốc, khám phá biển đảo và hải sản tươi ngon.', 3800000.00, '2025-11-20 19:55:42', 2, 'Catalog', NULL),
(40, 'Tour Phú Quốc 3 ngày', 'Nội địa', 'dddddddd', 22222222.00, '2025-12-06 12:00:55', 1, 'Catalog', NULL),
(41, 'Tour Phú Quốc 3 ngàyy', 'Nội địa', 'qqqqqqqqq', 111111.00, '2025-12-06 13:25:35', 2, 'Custom', NULL),
(42, 'long', 'Nội địa', 'aaaaaaaaaaaaaaaa', 2222222.00, '2025-12-06 14:16:21', 1, 'Custom', NULL),
(43, 'Tour Phú Quốc 3 ngày 2 đêm', 'Nội địa', 'dddddd', 11111.00, '2025-12-06 15:40:03', 2, 'Catalog', '                        qqqqqqqqqqqqq111111111111111                    '),
(47, 'long', 'Nội địa', 'qwweeee', 1111.00, '2025-12-09 14:03:24', 1, 'Catalog', '        qwwww    ');

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
(119, 3, '2026-01-20', '2026-01-22', 1900000.00, 14),
(120, 3, '2026-03-10', '2026-03-12', 1850000.00, 10),
(163, 1, '2025-11-20', '2025-11-30', 212312.00, 0),
(164, 1, '2026-04-30', '2026-05-05', 5500000.00, 20),
(174, 2, '2026-03-05', '2026-03-08', 8200000.00, 1),
(199, 41, '2025-12-12', '2025-12-07', 11111.00, 2),
(206, 42, '2025-12-05', '2025-12-16', 1111111.00, 2),
(219, 40, '2025-12-25', '2025-12-25', 2.00, 2),
(233, 43, '2025-12-19', '2025-12-26', 12.00, 4),
(235, 47, '2025-12-10', '2025-12-12', 11111111.00, 123);

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
(2, 4, 1, 3),
(3, 3, 2, 4),
(41, 3, 1, 6),
(41, 4, 2, 7),
(42, 4, 1, 15),
(42, 3, 2, 16),
(40, 4, 3, 37),
(1, 4, 1, 60),
(1, 3, 2, 61),
(43, 3, 1, 66),
(43, 3, 2, 67),
(47, 3, 1, 70);

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
(182, 43, 'tours_gallery/176503560369344e53218a2.jpg', 1, 1),
(187, 47, 'tours_gallery/176528902769382c4381db5.jpg', 1, 1),
(188, 47, 'tours_gallery/176528902769382c4383804.png', 0, 2),
(189, 47, 'tours_gallery/176528902769382c4384768.png', 0, 3);

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

--
-- Đang đổ dữ liệu cho bảng `tour_logs`
--

INSERT INTO `tour_logs` (`id`, `departure_id`, `staff_id`, `log_date`, `log_content`, `log_type`) VALUES
(1, 163, 1, '2025-12-07 21:36:49', 'sadad', 'note'),
(2, 163, 30, '2025-12-10 02:39:24', 'aaaaa', 'note'),
(3, 163, 30, '2025-12-10 02:44:33', 'aaa', 'note'),
(4, 233, 30, '2025-12-10 02:44:39', 'aaa', 'note'),
(5, 163, 30, '2025-12-10 23:03:47', 'Sự cố hi hữu', 'note');

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
(3, 'THHH ', 'Nhật Long', '0866939060', 'longadmin@gmail.com', 'sadd', '2025-12-07 19:03:36'),
(4, 'ád', 'Nhật Long', '0866939060', 'kien@gmail.com', 'aaaaa', '2025-12-10 16:31:53');

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
(6, 'customer1@mail.com', '1bbd886460827015e5d605ed44252251', 'Vũ Đình Kháchh', '0916666666', 'customer', '2025-11-20 05:55:48'),
(7, 'customer2@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Thị Hoa', '0917777777', 'customer', '2025-11-20 05:55:48'),
(8, 'customer3@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Đinh Văn Nam', '0918888888', 'customer', '2025-11-20 05:55:48'),
(9, 'customer4@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Bùi Thanh Tú', '0919999999', 'customer', '2025-11-20 05:55:48'),
(10, 'customer5@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lý Ngọc Hân', '0910000000', 'customer', '2025-11-20 05:55:48'),
(11, 'guide1@tour.com', '7fa8282ad93047a4d6fe6111c93b308a', 'Phan Hướng Đạo', '0981111111', 'guide', '2025-11-20 05:55:48'),
(12, 'guide2@tour.com', 'e10adc3949ba59abbe56e057f20f883e', 'Lê Thị Trinh', '0982222222', 'guide', '2025-11-20 05:55:48'),
(13, 'guide3@tour.com', 'e10adc3949ba59abbe56e057f20f883e', 'Hoàng Văn Minh', '0983333333', 'guide', '2025-11-20 05:55:48'),
(20, 'a@gmail.com', '$2y$10$f.szHT0LJ1eSPHWXTPRlw.RRJreg0Ypj2Z/AFKXzgrb7qxzYuulc6', 'sad', '4234234234', 'guide', '2025-11-27 17:21:29'),
(21, 'aw@gmail.com', '$2y$10$9tkin/a8h8gG/YR/Zx17pe7xYtCr7hQXh3aRY7La0wUTuhcCGfz0O', 'sad', '4234234234', 'guide', '2025-11-27 17:21:47'),
(30, 'duongv@gmail.com', '1bbd886460827015e5d605ed44252251', 'Nhật Long', '0866939060', 'guide', '2025-11-28 14:06:32'),
(32, 'longadmin1@gmail.com', '1bbd886460827015e5d605ed44252251', 'Nhật Long', '0866939060', 'admin', '2025-12-07 04:25:26'),
(37, 'longadminem@gmail.com', '1bbd886460827015e5d605ed44252251', 'Nhật Long', '0866939060', 'customer', '2025-12-07 04:53:13'),
(38, 'longadmin@gmail.coe', '1bbd886460827015e5d605ed44252251', 'Nhật Long', '0866939060', 'customer', '2025-12-10 16:23:12');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `booking_customers`
--
ALTER TABLE `booking_customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `custom_tour_quotes`
--
ALTER TABLE `custom_tour_quotes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `custom_tour_requests`
--
ALTER TABLE `custom_tour_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `departure_resources`
--
ALTER TABLE `departure_resources`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `financial_transactions`
--
ALTER TABLE `financial_transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `itinerary_details`
--
ALTER TABLE `itinerary_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `tour_categories`
--
ALTER TABLE `tour_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tour_departures`
--
ALTER TABLE `tour_departures`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT cho bảng `tour_destinations`
--
ALTER TABLE `tour_destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT cho bảng `tour_logs`
--
ALTER TABLE `tour_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `transport_suppliers`
--
ALTER TABLE `transport_suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
