-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-server
-- Generation Time: Jan 04, 2022 at 04:47 PM
-- Server version: 8.0.1-dmr
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `ChucVu`
--

CREATE TABLE `ChucVu` (
  `maChucVu` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tenChucVu` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ChucVu`
--

INSERT INTO `ChucVu` (`maChucVu`, `tenChucVu`) VALUES
('GD', 'Giám Đốc'),
('NV', 'Nhân Viên'),
('TP', 'Trưởng phòng');

-- --------------------------------------------------------

--
-- Table structure for table `DonXinNghiPhep`
--

CREATE TABLE `DonXinNghiPhep` (
  `maDon` int(10) NOT NULL,
  `maNhanVien` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `soNgayNghi` int(11) NOT NULL,
  `trangThai` tinyint(1) NOT NULL DEFAULT '0',
  `lyDo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ngayTao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tapTin` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `KetQua` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `DonXinNghiPhep`
--

INSERT INTO `DonXinNghiPhep` (`maDon`, `maNhanVien`, `soNgayNghi`, `trangThai`, `lyDo`, `ngayTao`, `tapTin`, `KetQua`) VALUES
(1, 'KD001', 2, 0, 'Nghỉ đẻ', '2022-01-04 00:00:00', NULL, 0),
(2, 'KD002', 5, 0, 'Ốm', '2022-01-05 00:00:00', NULL, 0),
(10, 'KD001', 4, 0, 'đi đẻ', '2022-12-25 00:00:00', 'dsaa', 0),
(11, 'KD001', 4, 0, 'đi đẻ', '2022-01-04 04:24:50', 'dsaa', 0),
(13, 'KD001', 2, 0, 'đi khám bệnh', '2022-01-04 04:54:24', 'C:\\fakepath\\company_management_5.sql', 0);

-- --------------------------------------------------------

--
-- Table structure for table `GiamDoc`
--

CREATE TABLE `GiamDoc` (
  `hoTen` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ngaySinh` date NOT NULL,
  `diaChi` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `maNhanVien` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `matKhau` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `anhDaiDien` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maChucVu` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'GD',
  `doiMatKhau` bit(1) NOT NULL DEFAULT b'1',
  `gioiTinh` tinyint(1) NOT NULL DEFAULT '1',
  `sdt` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `GiamDoc`
--

INSERT INTO `GiamDoc` (`hoTen`, `ngaySinh`, `diaChi`, `maNhanVien`, `matKhau`, `anhDaiDien`, `maChucVu`, `doiMatKhau`, `gioiTinh`, `sdt`, `email`) VALUES
('Nguyễn Thế Trường', '2001-06-10', 'Quảng Bình', 'admin', '$2y$10$KMPx.QRP69KokKKyh9aPDu7wcNI2fRo/GV9SxtcxRgZZRJqzMpHC2', '133761888_2944264395895001_3110095411169706515_n.jpg', 'GD', b'1', 1, '0919004743', 'nttruong10101@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `KetQuaGui`
--

CREATE TABLE `KetQuaGui` (
  `maNhiemVu` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `noiDung` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `tapTin` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `KetQuaTraVe`
--

CREATE TABLE `KetQuaTraVe` (
  `maNhiemVu` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `noiDung` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `tapTin` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `hanThucHien` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `NhanVien`
--

CREATE TABLE `NhanVien` (
  `maNhanVien` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hoTen` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ngaySinh` date NOT NULL,
  `gioiTinh` tinyint(1) NOT NULL DEFAULT '1',
  `sdt` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `diaChi` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `maChucVu` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `maPhongBan` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `soNgayNghi` int(11) NOT NULL DEFAULT '12',
  `matKhau` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `doiMatKhau` tinyint(1) NOT NULL DEFAULT '0',
  `anhDaiDien` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `NhanVien`
--

INSERT INTO `NhanVien` (`maNhanVien`, `hoTen`, `ngaySinh`, `gioiTinh`, `sdt`, `diaChi`, `email`, `maChucVu`, `maPhongBan`, `soNgayNghi`, `matKhau`, `doiMatKhau`, `anhDaiDien`) VALUES
('KD001', 'Phạm Thanh Tuấn', '2001-10-07', 1, '0919002250', 'Quảng Ngãi', 'tung@gmail.com', 'NV', 'PBKD', 12, '$2y$10$Fsm.XfP6jEe0XU24i80K1uLK8MtLDtiRJ3OGwCc3Ewlpvk0F9Xtfa', 1, NULL),
('KD002', 'Nguyễn Văn Tèo', '2022-01-01', 1, '14', '1', 'nttruong21@gmail.com', 'TP', 'PBKD', 15, '$2y$10$w0fWGNWi9fZRX61gJ9UXsOJJtGEJ41mnWAarJmNZOG3J/XLJtV45e', 0, NULL),
('KT001', 'Phạm Thanh Tùng', '2001-10-07', 1, '0919002250', 'Bến Tre', 'tung@gmail.com', 'TP', 'PBKT', 15, '$2y$10$r22bb1ZIKV5uOBRg4eA7J.ytQbFYLhV4CXb5pQI8o37J4988jfk/u', 1, NULL),
('KT002', 'Nguyễn Văn A ', '2022-01-04', 1, '113', 'Quang Binh', 'nttruong21@gmail.com', 'NV', 'PBKT', 12, '$2y$10$ncUVKxxNMhWtePNZ3V5MiO9N/3N82SsCP4f5GhAALgds1pNr1yigi', 0, NULL),
('KT003', 'Nguyễn Văn D', '2022-01-04', 1, '233', 'Quang Binh', 'nttruong21@gmail.com', 'NV', 'PBKT', 12, '$2y$10$D7hF.wQ3sR.7TkGQuWcsiu7g94kI0sxFIWdoQWZJ7ZxZNHh.Ztg4K', 0, NULL),
('KT004', 'Bùi Thị E', '2022-01-04', 0, '2313', 'Quang Binh', 'kk@gmail.com', 'NV', 'PBKT', 12, '$2y$10$7wS2VhZmaaSGSgZnL7upIOoomyWAb.CQVvQ//F1rgd5Fsw5rdXwlK', 0, NULL);

--
-- Triggers `NhanVien`
--
DELIMITER $$
CREATE TRIGGER `trigger_insert_nhanvien` BEFORE INSERT ON `NhanVien` FOR EACH ROW BEGIN
	IF (NEW.maChucVu = 'TP') THEN
    	SET NEW.soNgayNghi = 15;
    ELSE 
    	SET NEW.soNgayNghi = 12;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_update_position_nhanvien` BEFORE UPDATE ON `NhanVien` FOR EACH ROW BEGIN
	IF (NEW.maChucVu = 'TP') THEN
    	SET NEW.soNgayNghi = 15;
    ELSE 
    	SET NEW.soNgayNghi = 12;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `NhiemVu`
--

CREATE TABLE `NhiemVu` (
  `maNhiemVu` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tenNhiemVu` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `maNhanVien` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `maPhongBan` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hanThucHien` datetime NOT NULL,
  `moTa` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `tapTin` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `trangThai` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `NhiemVuHoanThanh`
--

CREATE TABLE `NhiemVuHoanThanh` (
  `maNhiemVu` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mucDo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dungHan` tinyint(1) NOT NULL,
  `feedBack` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PhongBan`
--

CREATE TABLE `PhongBan` (
  `maPhongBan` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tenPhongBan` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `soPhongBan` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `moTa` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `truongPhong` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `PhongBan`
--

INSERT INTO `PhongBan` (`maPhongBan`, `tenPhongBan`, `soPhongBan`, `moTa`, `truongPhong`) VALUES
('PBKD', 'Kinh Doanh', 'A0710', 'abc', 'KD002'),
('PBKT', 'Kỹ thuật', 'A0705', '', 'KT001'),
('PBKTTC', 'Kế Toán Tài Chính', 'A0712', '', NULL),
('PBNS', 'Nhân Sự', 'A0702', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ChucVu`
--
ALTER TABLE `ChucVu`
  ADD PRIMARY KEY (`maChucVu`);

--
-- Indexes for table `DonXinNghiPhep`
--
ALTER TABLE `DonXinNghiPhep`
  ADD PRIMARY KEY (`maDon`),
  ADD KEY `FK_DXNP_NhanVien` (`maNhanVien`);

--
-- Indexes for table `KetQuaGui`
--
ALTER TABLE `KetQuaGui`
  ADD PRIMARY KEY (`maNhiemVu`);

--
-- Indexes for table `KetQuaTraVe`
--
ALTER TABLE `KetQuaTraVe`
  ADD KEY `FK_KQTV_NhiemVu` (`maNhiemVu`);

--
-- Indexes for table `NhanVien`
--
ALTER TABLE `NhanVien`
  ADD PRIMARY KEY (`maNhanVien`),
  ADD KEY `FK_NhanVien_PhongBan` (`maPhongBan`),
  ADD KEY `FK_NhanVien_ChucVu` (`maChucVu`);

--
-- Indexes for table `NhiemVu`
--
ALTER TABLE `NhiemVu`
  ADD PRIMARY KEY (`maNhiemVu`),
  ADD KEY `FK_NhiemVu_NhanVien` (`maNhanVien`),
  ADD KEY `FK_NhiemVu_PhongBan` (`maPhongBan`);

--
-- Indexes for table `NhiemVuHoanThanh`
--
ALTER TABLE `NhiemVuHoanThanh`
  ADD KEY `FK_NVHT_NhiemVu` (`maNhiemVu`);

--
-- Indexes for table `PhongBan`
--
ALTER TABLE `PhongBan`
  ADD PRIMARY KEY (`maPhongBan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DonXinNghiPhep`
--
ALTER TABLE `DonXinNghiPhep`
  MODIFY `maDon` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `DonXinNghiPhep`
--
ALTER TABLE `DonXinNghiPhep`
  ADD CONSTRAINT `FK_DXNP_NhanVien` FOREIGN KEY (`maNhanVien`) REFERENCES `NhanVien` (`maNhanVien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `KetQuaGui`
--
ALTER TABLE `KetQuaGui`
  ADD CONSTRAINT `FK_KetQuaGui_NhiemVu` FOREIGN KEY (`maNhiemVu`) REFERENCES `NhiemVu` (`maNhiemVu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `KetQuaTraVe`
--
ALTER TABLE `KetQuaTraVe`
  ADD CONSTRAINT `FK_KQTV_NhiemVu` FOREIGN KEY (`maNhiemVu`) REFERENCES `NhiemVu` (`maNhiemVu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `NhanVien`
--
ALTER TABLE `NhanVien`
  ADD CONSTRAINT `FK_NhanVien_ChucVu` FOREIGN KEY (`maChucVu`) REFERENCES `ChucVu` (`maChucVu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_NhanVien_PhongBan` FOREIGN KEY (`maPhongBan`) REFERENCES `PhongBan` (`maPhongBan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `NhiemVu`
--
ALTER TABLE `NhiemVu`
  ADD CONSTRAINT `FK_NhiemVu_NhanVien` FOREIGN KEY (`maNhanVien`) REFERENCES `NhanVien` (`maNhanVien`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_NhiemVu_PhongBan` FOREIGN KEY (`maPhongBan`) REFERENCES `PhongBan` (`maPhongBan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `NhiemVuHoanThanh`
--
ALTER TABLE `NhiemVuHoanThanh`
  ADD CONSTRAINT `FK_NVHT_NhiemVu` FOREIGN KEY (`maNhiemVu`) REFERENCES `NhiemVu` (`maNhiemVu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
