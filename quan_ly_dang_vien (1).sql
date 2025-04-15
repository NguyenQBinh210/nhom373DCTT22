-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 07, 2025 lúc 05:19 PM
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
-- Cơ sở dữ liệu: `quan_ly_dang_vien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chibo`
--

CREATE TABLE `chibo` (
  `maChiBo` varchar(10) NOT NULL,
  `tenChiBo` varchar(255) NOT NULL,
  `ngayThanhLap` date NOT NULL,
  `diaDiem` varchar(255) NOT NULL,
  `nganhLinhVuc` varchar(100) DEFAULT NULL,
  `soLuongDangVien` int(11) DEFAULT 0,
  `biThuChiBo` varchar(255) NOT NULL,
  `thongTinKhac` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chibo`
--

INSERT INTO `chibo` (`maChiBo`, `tenChiBo`, `ngayThanhLap`, `diaDiem`, `nganhLinhVuc`, `soLuongDangVien`, `biThuChiBo`, `thongTinKhac`) VALUES
('CB001', 'Chi bộ Văn phòng2', '1995-03-10', 'Số 1, Phố Phúc Lý, Quận Hà Bắc', 'Hành chính', 25, 'Nguyễn Văn Anh', 'Hoạt động tích cực trong công tác hành chính.'),
('CB002', 'Chi bộ Quận Hoàn Kiếm', '1980-05-20', 'Quận Hoàn Kiếm, Hà Nội', 'Quản lý đô thị', 40, 'Phạm Thị Bích', 'Chi bộ lớn nhất quận với nhiều hoạt động cộng đồng.'),
('CB003', 'Chi bộ Văn phòng 3', '2023-02-04', 'Thanh Xuân,Hà Nội', 'Tài nguyên môi trường', 0, 'Hoàng Văn Chiến', 'Chi bộ quản lý cơ sở hạ tầng và tài nguyên'),
('CB04', '73dctt22', '2020-01-02', 'Hà Nội', 'Giáo dục', 0, 'Nguyễn Quốc Bình', 'CNTT');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_dangvien`
--

CREATE TABLE `chi_tiet_dangvien` (
  `maDangVien` varchar(50) NOT NULL,
  `hoTenCha` varchar(255) DEFAULT NULL,
  `namSinhCha` year(4) DEFAULT NULL,
  `ngheNghiepCha` varchar(255) DEFAULT NULL,
  `noiOCha` varchar(255) DEFAULT NULL,
  `hoTenMe` varchar(255) DEFAULT NULL,
  `namSinhMe` year(4) DEFAULT NULL,
  `ngheNghiepMe` varchar(255) DEFAULT NULL,
  `noiOMe` varchar(255) DEFAULT NULL,
  `hoTenVoChong` varchar(255) DEFAULT NULL,
  `namSinhVoChong` year(4) DEFAULT NULL,
  `ngheNghiepVoChong` varchar(255) DEFAULT NULL,
  `noiOVoChong` varchar(255) DEFAULT NULL,
  `soLuongCon` int(11) DEFAULT NULL,
  `trinhDoHocVan` varchar(255) DEFAULT NULL,
  `trinhDoChuyenMon` varchar(255) DEFAULT NULL,
  `trinhDoLyLuanChinhTri` varchar(255) DEFAULT NULL,
  `ngoaiNgu` varchar(255) DEFAULT NULL,
  `ngayVaoDang` date DEFAULT NULL,
  `ngayChinhThuc` date DEFAULT NULL,
  `quaTrinhCongTac` text DEFAULT NULL,
  `khenThuong` text DEFAULT NULL,
  `kyLuat` text DEFAULT NULL,
  `soDienThoai` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_dangvien`
--

INSERT INTO `chi_tiet_dangvien` (`maDangVien`, `hoTenCha`, `namSinhCha`, `ngheNghiepCha`, `noiOCha`, `hoTenMe`, `namSinhMe`, `ngheNghiepMe`, `noiOMe`, `hoTenVoChong`, `namSinhVoChong`, `ngheNghiepVoChong`, `noiOVoChong`, `soLuongCon`, `trinhDoHocVan`, `trinhDoChuyenMon`, `trinhDoLyLuanChinhTri`, `ngoaiNgu`, `ngayVaoDang`, `ngayChinhThuc`, `quaTrinhCongTac`, `khenThuong`, `kyLuat`, `soDienThoai`, `email`) VALUES
('CM004', 'Trần Văn An', '1970', 'Nông dân', 'Xã Khánh Hòa, huyện U Minh, tỉnh Cà Mau', 'Nguyễn Thị Hoa', '1972', 'Giáo viên', 'Xã Khánh Hòa, huyện U Minh, tỉnh Cà Mau', 'Lê Thị Hồng', '1997', 'Công nhân', 'Xã Khánh Hòa, huyện U Minh, tỉnh Cà Mau', 2, '12', 'Đại họcs', 'Thạc sĩ', 'Anh văn B', '2018-06-15', '2019-06-15', 'Làm việc tại UBND xã Khánh Hòa, giữ chức Phó Chủ tịch xã', 'Huân chương Lao động hạng Ba', 'Không', '0987654321', 'ngochai@gmail.com'),
('DN003', 'Lê Văn Thái', '1970', 'Nông dân', 'Phường Hòa Khánh Bắc, quận Liên Chiểu, Đà Nẵng', 'Nguyễn Thị Hồng', '1967', 'Buôn bán', 'Phường Hòa Khánh Bắc, quận Liên Chiểu, Đà Nẵng', 'Cúc Thị Huế', '2000', 'Kế toán', 'Đà Nẵng', 1, '12/12', 'Cử nhân Xã hội học', 'Trung cấp', 'Anh văn C', '2020-05-01', '2021-05-01', 'Công tác tại Hội đồng nhân dân quận Liên Chiểu', 'Bằng khen chủ tịch nước', 'Không', '0933456789', 'levanlong@example.com'),
('HN001', 'Nguyễn Văn Bình', '1971', 'Kỹ sư', 'Phường Dịch Vọng Hậu, Quận Cầu Giấy, Hà Nội', 'Nguyễn Thị Lan', '1973', 'Giáo viên', 'Phường Dịch Vọng Hậu, Quận Cầu Giấy, Hà Nội', 'Không', '0000', 'Không', 'Không', 1, '12/12', 'Cử nhân Công nghệ thông tin', 'Cao cấp', 'Anh văn C', '2019-03-01', '2020-03-01', 'Công tác tại Sở Thông tin và Truyền thông Hà Nội', 'Bằng khen Thủ tướng', 'Không', '0901234567', 'nguyenvana_hn@example.com'),
('HN003', 'Nguyễn Quốc Tuấn', '1975', 'Bác sĩ', 'xã Thái Hưng, huyện Thái Thụy, tỉnh Thái Bình', 'Phạm Thị Mai', '1978', 'Nhân viên ngân hàng', 'xã Thái Hưng, huyện Thái Thụy, tỉnh Thái Bình', NULL, NULL, NULL, NULL, NULL, '12/12', 'Cử nhân Y khoa', 'Cao cấp', 'Pháp văn B', '2021-07-01', '2022-07-01', 'Công tác tại Bệnh viện Bạch Mai', NULL, NULL, '0378432433', 'nguyenbinh@example.com'),
('HP006', 'Hoàng Văn Hùng', '1968', 'Nông dân', 'Xã Tiên Lãng, huyện Tiên Lãng, thành phố Hải Phòng', 'Lê Thị Lý', '1970', 'Nội trợ', 'Xã Tiên Lãng, huyện Tiên Lãng, thành phố Hải Phòng', NULL, NULL, NULL, NULL, NULL, '12/12', 'Cử nhân Nông nghiệp', 'Trung cấp', 'Anh văn B', '2020-02-15', '2021-02-15', 'Công tác tại Hội Nông dân huyện Tiên Lãng', NULL, NULL, '0964321765', 'hoangvanbinh@example.com'),
('LC007', 'Đào Văn Hải', '1972', 'Giáo viên', 'Xã Sín Chải, huyện Sa Pa, tỉnh Lào Cai', 'Lý Thị Hoa', '1974', 'Nông dân', 'Xã Sín Chải, huyện Sa Pa, tỉnh Lào Cai', NULL, NULL, NULL, NULL, NULL, '12/12', 'Cử nhân Văn hóa', 'Trung cấp', 'Anh văn A', '2021-06-01', '2022-06-01', 'Công tác tại UBND huyện Sa Pa', NULL, NULL, '0943218765', 'daothihoa@example.com'),
('NB005', 'Vũ Văn Long', '1969', 'Thợ cơ khí', 'Phường Nam Bình, thành phố Ninh Bình, tỉnh Ninh Bình', 'Nguyễn Thị Hà', '1971', 'Buôn bán', 'Phường Nam Bình, thành phố Ninh Bình, tỉnh Ninh Bình', NULL, NULL, NULL, NULL, NULL, '12/12', 'Cử nhân Kinh doanh', 'Trung cấp', 'Anh văn B', '2018-09-01', '2019-09-01', 'Công tác tại Sở Công thương tỉnh Ninh Bình', 'Bằng khen của tỉnh', NULL, '0976543210', 'vuthilan@example.com'),
('HN004', 'adsfds', '2003', 'gfdg', 'ggfdgdf', 'fdsf', '0000', 'fdsfds', 'fdsfsd', 'fdsfs', '0000', 'fdsfds', 'fdsfsd', 2, '0', '0', '0', 'fdsfs', '2015-10-02', '2015-02-03', 'sđa', 'dsa', NULL, NULL, NULL),
('CM004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('NM001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichtrinh`
--

CREATE TABLE `lichtrinh` (
  `maLichTrinh` varchar(50) NOT NULL,
  `tenSuKien` varchar(255) NOT NULL,
  `moTa` text NOT NULL,
  `loaiHinh` varchar(100) NOT NULL,
  `nguoiChuTri` varchar(255) NOT NULL,
  `trangThai` varchar(50) NOT NULL,
  `diaDiem` varchar(255) NOT NULL,
  `thoiGian` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lichtrinh`
--

INSERT INTO `lichtrinh` (`maLichTrinh`, `tenSuKien`, `moTa`, `loaiHinh`, `nguoiChuTri`, `trangThai`, `diaDiem`, `thoiGian`) VALUES
('LT001', 'Họp Ban Chấp Hành', 'Họp thường kỳ của ban chấp hành', 'Họp thường kỳ', 'Nguyễn Văn A', 'Đang chuẩn bị', 'Phòng họp số 1', '2025-01-15 09:00:00'),
('LT002', 'Hội Thảo Công Nghệ', 'Hội thảo về xu hướng công nghệ năm 2025', 'Hội thảo', 'Trần Thị B', 'Đã diễn ra', 'Hội trường tầng 3', '2024-12-20 14:00:00'),
('LT003', 'Họp Khẩn Cấp', 'Họp khẩn cấp về tình hình hoạt động', 'Họp khẩn cấp', 'Lê Văn C', 'Đã kết thúc', 'Phòng họp số 2', '2024-11-10 10:00:00'),
('LT004', 'Họp tổng kết cuối năm', 'ko có', 'Lễ kỷ niệm', 'ko có', 'Đang chuẩn bị', 'Hội trường lớn số 5', '2025-05-01 16:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lylichdangvien`
--

CREATE TABLE `lylichdangvien` (
  `maDangVien` varchar(255) NOT NULL,
  `hoTen` varchar(255) NOT NULL,
  `ngaySinh` date NOT NULL,
  `danToc` varchar(50) NOT NULL,
  `gioiTinh` varchar(50) NOT NULL,
  `tonGiao` varchar(50) NOT NULL,
  `queQuan` varchar(50) NOT NULL,
  `noiCuTru` varchar(50) NOT NULL,
  `soDienThoai` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lylichdangvien`
--

INSERT INTO `lylichdangvien` (`maDangVien`, `hoTen`, `ngaySinh`, `danToc`, `gioiTinh`, `tonGiao`, `queQuan`, `noiCuTru`, `soDienThoai`, `email`) VALUES
('CM004', 'Trần Ngọc Mai', '2000-04-25', 'Khơ-me', 'Nam', 'Không', 'Xã Khánh Hòa, huyện U Minh, tỉnh Cà Mau', 'Xã Khánh Hòa, huyện U Minh, tỉnh Cà Mau', '0987654321', 'tranngochai@gmail.com'),
('DN003', 'Lê Văn Long', '2001-11-20', 'Kinh', 'Nam', 'Phật giáo', 'Phường Hòa Khánh Bắc, quận Liên Chiểu, Đà Nẵng', 'Phường Hòa Khánh Bắc, quận Liên Chiểu, Đà Nẵng', '0933456789', 'lelong1980@gmail.com'),
('HN001', 'Nguyễn Văn Anh', '2003-07-12', 'Kinh', 'Nam', 'Không', 'Phường Dịch Vọng Hậu, Quận Cầu Giấy, Hà Nội', 'Phường Dịch Vọng Hậu, Quận Cầu Giấy, Hà Nội', '0901234567', 'nguyenvana@gmail.com'),
('HN003', 'Nguyễn Quốc Bình', '2004-10-27', 'Kinh', 'Nam', 'Không', 'xã Thái Hưng, huyện Thái Thụy, tỉnh Thái Bình', 'Bắc Từ Liêm, Hà Nội', '0378432433', ''),
('HN004', 'Lê Hoàng An', '2004-01-02', 'Kinh', 'Nam', 'Không', 'Hưng Yên', 'Hà Nội', '01235462546', 'an@gmail.com'),
('HP006', 'Hoàng Văn Bình', '2004-12-10', 'Tày', 'Nam', 'Không', 'Xã Tiên Lãng, huyện Tiên Lãng, thành phố Hải Phòng', 'Xã Tiên Lãng, huyện Tiên Lãng, thành phố Hải Phòng', '0964321765', 'hoangbinh78@gmail.com'),
('LC007', 'Đào Thị Hoa', '2005-06-18', 'H-Mông', 'Nữ', 'Không', 'Xã Sín Chải, huyện Sa Pa, tỉnh Lào Cai', 'Xã Sín Chải, huyện Sa Pa, tỉnh Lào Cai', '0943218765', 'daothihoa@gmail.com'),
('NB005', 'Vũ Thị Lan', '1999-08-30', 'Kinh', 'Nữ', 'Không', 'Phường Nam Bình, thành phố Ninh Bình, tỉnh Ninh Bì', 'Phường Nam Bình, thành phố Ninh Bình, tỉnh Ninh Bì', '0976543210', 'vuthilan@gmail.com'),
('NM001', 'sda', '2000-01-01', 'Kinh', 'Nữ', 'Không', 'Hà nma', 'Hà Nội', '0123432', 'd@gmail.com'),
('YB001', 'Trần Thị Bích Ngọc', '2001-01-03', 'Thái', 'Nam', 'Không', 'Xã Púng Luông, huyện Mù Cang Chải, tỉnh Yên Bái', 'Xã Púng Luông, huyện Mù Cang Chải, tỉnh Yên Bái', '0987654321', 'tranbichngoc@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `maDangVien` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `maDangVien`) VALUES
(1, 'binh123', 'quocbinh', 'user', NULL),
(2, 'binh1234', 'quocbinh2', 'admin', NULL),
(3, 'binhdzd', '$2y$10$PDP38KnGoJ/pE6GZkkuRyehhggjh9YW1OGjwE4CXcS4oGWU6C2ZO.', 'user', NULL),
(4, 'binh1', '$2y$10$PcwfTvelBYlZvj34HqWMdO2j6MjJigAnYftKzUWhiO/880NkA/VTi', 'admin', 'HN003'),
(5, '73dctt22', '$2y$10$BtaMk36hoeT5LMRJlaDIE.J.GLz3gAL3V8whu8kYgD4Ox1eHI8FBm', 'admin', NULL),
(6, '73dctt22476', '$2y$10$RLlQeO253mhJ9jAN8nYSqOi3SIUQd2ieTb4W8kCIqXmUOGUQZXFjq', 'user', NULL),
(7, '5555', '$2y$10$UrHfM5whsIyVc8z/7LSrQuBfaIiLbTqCXn87FEi1u45H2EBeC799y', 'user', NULL),
(8, 'admin', 'admin123', 'admin', NULL),
(9, 'dzd', '$2y$10$CpR5LYPUezJKphMZ9TOxeeRAOf8SXC1cgxmwpjJS2SQwAV.XiwmvG', 'admin', 'YB001');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chibo`
--
ALTER TABLE `chibo`
  ADD PRIMARY KEY (`maChiBo`);

--
-- Chỉ mục cho bảng `chi_tiet_dangvien`
--
ALTER TABLE `chi_tiet_dangvien`
  ADD KEY `maDangVien` (`maDangVien`);

--
-- Chỉ mục cho bảng `lichtrinh`
--
ALTER TABLE `lichtrinh`
  ADD PRIMARY KEY (`maLichTrinh`);

--
-- Chỉ mục cho bảng `lylichdangvien`
--
ALTER TABLE `lylichdangvien`
  ADD PRIMARY KEY (`maDangVien`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_maDangVien` (`maDangVien`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_dangvien`
--
ALTER TABLE `chi_tiet_dangvien`
  ADD CONSTRAINT `chi_tiet_dangvien_ibfk_1` FOREIGN KEY (`maDangVien`) REFERENCES `lylichdangvien` (`maDangVien`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_maDangVien` FOREIGN KEY (`maDangVien`) REFERENCES `lylichdangvien` (`maDangVien`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
