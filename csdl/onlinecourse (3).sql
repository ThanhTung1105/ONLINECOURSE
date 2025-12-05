-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 05, 2025 lúc 03:21 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `onlinecourse`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Lập trình Web', 'Các khóa học về Front-end, Back-end, Fullstack', '2025-12-04 23:30:27'),
(2, 'Thiết kế đồ họa', 'Photoshop, AI, UI/UX Design', '2025-12-04 23:30:27'),
(3, 'Khoa học dữ liệu', 'Python, Machine Learning, AI', '2025-12-04 23:30:27'),
(4, 'Marketing', 'Digital Marketing, SEO, Content', '2025-12-04 23:30:27'),
(5, 'ANIME', 'ANIME fsfafafasf', '2025-12-05 21:10:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `duration_weeks` int(11) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL COMMENT 'Beginner, Intermediate, Advanced',
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `instructor_id`, `category_id`, `price`, `duration_weeks`, `level`, `image`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Xây Dựng Website Tương Tác với HTML, CSS và JavaScript', 'Khóa học nền tảng giúp bạn tự tay tạo ra các trang web động, đẹp mắt và có tính tương tác cao.', 1, 1, 500000.00, 5, 'Intermediate', 'Gemini_Generated_Image_1ie89a1ie89a1ie8 (2).png', '2025-12-04 23:38:57', '2025-12-05 20:40:32', 'approved'),
(2, 'Phân Tích Dữ Liệu Thực Chiến với Python và Excel', 'Khám phá sức mạnh của dữ liệu để đưa ra các quyết định kinh doanh thông minh thông qua Python và Excel.', 1, 3, 1200000.00, 5, 'Advanced', 'Gemini_Generated_Image_1ie89a1ie89a1ie8 (3).png', '2025-12-04 23:38:57', '2025-12-05 20:41:15', 'approved'),
(3, 'Trực Quan Hóa Dữ Liệu: Kể Chuyện Bằng Biểu Đồ và Dashboard', 'Biến dữ liệu thô thành những câu chuyện hấp dẫn và dễ hiểu thông qua các công cụ trực quan hóa chuyên nghiệp', 1, 3, 500000.00, 5, 'Intermediate', 'Gemini_Generated_Image_1ie89a1ie89a1ie8 (4).png', '2025-12-04 23:38:57', '2025-12-05 20:51:36', 'approved'),
(4, 'Digital Marketing Tổng Lực: SEO, Content, Google Ads và Facebook Marketing', 'Nắm vững các chiến lược tiếp thị kỹ thuật số từ tối ưu hóa công cụ tìm kiếm, sáng tạo nội dung đến chạy quảng cáo hiệu quả trên Google và Facebook.', 1, 4, 500000.00, 5, 'Advanced', 'Gemini_Generated_Image_4v37a94v37a94v37.png', '2025-12-04 23:38:57', '2025-12-05 20:52:32', 'approved'),
(7, 'Adobe Photoshop & Illustrator Từ A-Z ', 'Nắm vững hai công cụ thiết kế mạnh mẽ nhất để chỉnh sửa ảnh, vẽ minh họa và tạo ra các tác phẩm đồ họa sáng tạo.', 1, 2, 200000.00, 4, 'Beginner', 'Gemini_Generated_Image_1ie89a1ie89a1ie8 (1).png', '2025-12-05 17:23:33', '2025-12-05 20:58:04', 'approved'),
(8, ' Thiết Kế Logo & Nhận Diện Thương Hiệu Chuyên Nghiệp', 'Học cách tạo ra những logo độc đáo và hệ thống nhận diện thương hiệu ấn tượng, giúp doanh nghiệp nổi bật trên thị trường.', 1, 2, 500000.00, 5, 'Beginner', 'Gemini_Generated_Image_1ie89a1ie89a1ie8.png', '2025-12-05 18:02:26', '2025-12-05 20:39:02', 'approved');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `enrolled_date` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'active' COMMENT 'active, completed, dropped',
  `progress` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `enrollments`
--

INSERT INTO `enrollments` (`id`, `course_id`, `student_id`, `enrolled_date`, `status`, `progress`) VALUES
(1, 2, 2, '2025-12-04 23:59:45', 'active', 0),
(2, 1, 2, '2025-12-05 00:15:20', 'completed', 100),
(3, 2, 1, '2025-12-05 14:45:31', 'active', 0),
(4, 7, 2, '2025-12-05 17:24:41', 'active', 0),
(5, 8, 2, '2025-12-05 18:13:01', 'completed', 100);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `ordering` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `content`, `video_url`, `ordering`, `created_at`) VALUES
(1, 1, 'JavaScript ES6+ Toàn Tập (Arrow, Destructuring, Async/Await)', 'Ôn tập và đi sâu vào các tính năng mới của JavaScript (ES6+), nền tảng bắt buộc để làm việc với các Framework hiện đại.', 'https://www.youtube.com/watch?v=I4AyW8vETxM&list=RDI4AyW8vETxM&start_radio=1', 1, '2025-12-05 00:10:26'),
(2, 1, 'Làm Quen Với React: Component & Props', 'Giới thiệu kiến trúc React, cách tạo và sử dụng Component, truyền dữ liệu qua Props và sử dụng cú pháp JSX.', 'https://www.youtube.com/watch?v=vpRi8S6uXAg&list=RDI4AyW8vETxM&index=5', 2, '2025-12-05 00:10:26'),
(3, 1, 'Quản Lý State Hiệu Quả Với Hooks (useState, useEffect)', 'Hướng dẫn cách sử dụng React Hooks cơ bản để quản lý trạng thái, xử lý side-effect và tối ưu hóa hiệu suất Component.', 'https://www.youtube.com/watch?v=T5SpBJDIwjM&list=RDI4AyW8vETxM&index=3', 3, '2025-12-05 00:10:26'),
(4, 8, 'Hiểu Về Bản Sắc Thương Hiệu (Brand Identity)', 'Tìm hiểu các thành phần cốt lõi (tầm nhìn, sứ mệnh, giá trị) và cách chuyển hóa chúng thành yếu tố thiết kế.', 'https://www.youtube.com/watch?v=KaohUQ2gloo&list=RDKaohUQ2gloo&start_radio=1', 1, '2025-12-05 18:10:01'),
(5, 8, 'Nguyên Tắc Thiết Kế Logo Đa Dụng & Ấn Tượng', 'Hướng dẫn quy trình phác thảo, chọn màu, chọn font và hoàn thiện một mẫu logo hoạt động hiệu quả trên mọi nền tảng.', 'https://www.youtube.com/watch?v=I4AyW8vETxM&list=RDI4AyW8vETxM&start_radio=1', 2, '2025-12-05 20:56:44'),
(6, 8, 'Xây Dựng Hệ Thống Hình Ảnh (Visual System)', 'Thiết lập bảng màu (color palette), hướng dẫn sử dụng Typography và các mẫu thiết kế ứng dụng cho Brand Guideline.', 'https://www.youtube.com/watch?v=T5SpBJDIwjM&list=RDI4AyW8vETxM&index=3', 1, '2025-12-05 20:57:27'),
(7, 7, 'Giải Phẫu Font Chữ & Phân Loại Các Họ Font Chính', 'Học cách nhận diện các bộ phận của chữ, phân biệt Serif, Sans-Serif, Script và hiểu rõ tâm lý học đằng sau từng loại font.', 'https://www.youtube.com/watch?v=T5SpBJDIwjM&list=RDI4AyW8vETxM&index=3', 1, '2025-12-05 20:58:33'),
(8, 7, 'Thiết Lập Hệ Thống Phân Cấp Chữ (Typographic Hierarchy)', 'Hướng dẫn sử dụng cỡ chữ, độ đậm, khoảng cách (leading/kerning) để tạo ra sự phân cấp rõ ràng và dẫn dắt mắt người đọc.', 'https://www.youtube.com/watch?v=vpRi8S6uXAg&list=RDI4AyW8vETxM&index=5', 2, '2025-12-05 20:59:04'),
(9, 7, 'Kỹ Thuật Kết Hợp Font Chữ Chuyên Nghiệp (Font Pairing)', 'Khám phá các công thức kết hợp 2-3 font chữ hài hòa, tránh lỗi và tối ưu hóa khả năng đọc cho các dự án thiết kế.', 'https://www.youtube.com/watch?v=vpRi8S6uXAg&list=RDI4AyW8vETxM&index=5', 3, '2025-12-05 20:59:32'),
(10, 2, 'Kiến Trúc Máy Chủ (Server) & Cấu Trúc ExpressJS', 'Hiểu rõ cơ chế hoạt động của Web Server, cài đặt môi trường NodeJS và xây dựng ứng dụng Express cơ bản.', 'https://www.youtube.com/watch?v=I4AyW8vETxM&list=RDI4AyW8vETxM&start_radio=1', 1, '2025-12-05 21:01:57'),
(11, 2, 'Xây Dựng API RESTful Với Router, Controller & Service', 'Hướng dẫn thiết kế các tuyến đường (routes), xử lý yêu cầu (request), trả về phản hồi (response) theo chuẩn API RESTful.', 'https://www.youtube.com/watch?v=akgNYX8i9Xs&list=RDI4AyW8vETxM&index=3', 2, '2025-12-05 21:02:28'),
(12, 2, 'Tích Hợp Cơ Sở Dữ Liệu MongoDB & Mongoose', 'Hướng dẫn kết nối Node/Express với NoSQL Database (MongoDB), định nghĩa Schema (Mongoose) và thực hiện các thao tác CRUD.', 'https://www.youtube.com/watch?v=vpRi8S6uXAg&list=RDI4AyW8vETxM&index=5', 3, '2025-12-05 21:02:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lesson_completions`
--

CREATE TABLE `lesson_completions` (
  `id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `completed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `materials`
--

INSERT INTO `materials` (`id`, `lesson_id`, `filename`, `file_path`, `file_type`, `uploaded_at`) VALUES
(1, 4, 'CSE485-CNW-Chuong5-PHT.pdf', '1764943943_CSE485-CNW-Chuong5-PHT.pdf', 'pdf', '2025-12-05 21:12:23'),
(2, 4, 'CSE485_BTTH 01_2025.docx', '1764943967_CSE485_BTTH 01_2025.docx', 'docx', '2025-12-05 21:12:47'),
(3, 4, 'CSE485_BTTH02_K65_2025.docx', '1764943974_CSE485_BTTH02_K65_2025.docx', 'docx', '2025-12-05 21:12:54'),
(4, 6, 'CSE485_BTTH 01_2025.docx', '1764944001_CSE485_BTTH 01_2025.docx', 'docx', '2025-12-05 21:13:21'),
(5, 5, 'CSE485_BTTH 01_2025.docx', '1764944018_CSE485_BTTH 01_2025.docx', 'docx', '2025-12-05 21:13:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT 0 COMMENT '0: Student, 1: Instructor, 2: Admin',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `fullname`, `role`, `created_at`) VALUES
(1, 'hieutc', 'gv@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Hiếu Tc', 1, '2025-12-04 23:33:18'),
(2, 'hocvien1', 'hv@gmail.com', '$2y$10$yFquLLZeFPfQqksW9P2z0OjvToKCC9LDaYOf2Zosdmv/mHhfh5Ezm', 'Nguyễn Văn A', 0, '2025-12-03 08:48:37'),
(3, 'admin', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Quản Trị Viên', 2, '2025-12-03 17:12:32'),
(4, 'tungdz123', 'dothanhtung1105@gmail.com', '$2y$10$YkSc7ouy1TEJ6UB7eSWBTebv479SFULU3oIp/me0iixWTXk23l6PS', 'Thanh Tùng', 0, '2025-12-03 17:30:48');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Chỉ mục cho bảng `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `lesson_completions`
--
ALTER TABLE `lesson_completions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_id` (`enrollment_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Chỉ mục cho bảng `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `lesson_completions`
--
ALTER TABLE `lesson_completions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lesson_completions`
--
ALTER TABLE `lesson_completions`
  ADD CONSTRAINT `lesson_completions_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_completions_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
