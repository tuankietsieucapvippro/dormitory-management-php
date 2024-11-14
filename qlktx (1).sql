-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 01:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlktx`
--

-- --------------------------------------------------------

--
-- Table structure for table `loaiphong`
--

CREATE TABLE `loaiphong` (
  `LoaiPhongID` int(11) NOT NULL,
  `TenLoaiPhong` varchar(30) NOT NULL,
  `DonGia` float NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loaiphong`
--

INSERT INTO `loaiphong` (`LoaiPhongID`, `TenLoaiPhong`, `DonGia`, `MoTa`) VALUES
(1, 'Phòng VIP', 1000000, 'Thoáng mát, tiện nghi, thiết bị đầy đủ'),
(2, 'Phòng bình dân', 300000, 'Thoáng mát');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `NhanVienID` int(11) NOT NULL,
  `UserID` varchar(10) DEFAULT NULL,
  `HoTen` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ChucVu` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`NhanVienID`, `UserID`, `HoTen`, `ChucVu`, `Email`) VALUES
(1, 'nv1', 'Nguyễn Công Phương', 'Nhân viên quản lý', 'phuong@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `phong`
--

CREATE TABLE `phong` (
  `PhongID` int(11) NOT NULL,
  `ToaNhaID` int(11) DEFAULT NULL,
  `LoaiPhongID` int(11) DEFAULT NULL,
  `TenPhong` varchar(30) NOT NULL,
  `TinhTrang` varchar(30) DEFAULT NULL,
  `SoLuongGiuong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phong`
--

INSERT INTO `phong` (`PhongID`, `ToaNhaID`, `LoaiPhongID`, `TenPhong`, `TinhTrang`, `SoLuongGiuong`) VALUES
(11, 1, 1, '101', 'Đang sử dụng', 2),
(12, 1, 1, '102', 'Đang sử dụng', 2),
(13, 1, 2, '103', 'Đang sử dụng', 6),
(14, 2, 1, '101', 'Đang sử dụng', 2),
(15, 2, 1, '102', 'Đang sử dụng', 2),
(16, 2, 2, '103', 'Đang sử dụng', 6),
(17, 2, 2, '104', 'Đang sử dụng', 6);

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien`
--

CREATE TABLE `sinhvien` (
  `SinhVienID` int(11) NOT NULL,
  `HoSV` varchar(255) DEFAULT NULL,
  `TenSV` varchar(255) DEFAULT NULL,
  `MSSV` varchar(20) DEFAULT NULL,
  `Lop` varchar(50) DEFAULT NULL,
  `GioiTinh` enum('Nam','Nữ') DEFAULT NULL,
  `NgaySinh` date DEFAULT NULL,
  `NoiSinh` varchar(255) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `SoCCCD` varchar(20) DEFAULT NULL,
  `TaiKhoanID` varchar(10) DEFAULT NULL,
  `PhongID` int(11) DEFAULT NULL,
  `Anh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`SinhVienID`, `HoSV`, `TenSV`, `MSSV`, `Lop`, `GioiTinh`, `NgaySinh`, `NoiSinh`, `DiaChi`, `Email`, `SoDienThoai`, `SoCCCD`, `TaiKhoanID`, `PhongID`, `Anh`) VALUES
(1, 'Nguyễn Công', 'Phương', '63135148', '63.CNTT-3', 'Nam', '2003-07-01', 'Bà Rịa - Vũng tàu', 'Ninh Hòa, Khánh Hòa', 'ncphuong0107@gmail.com', '0123456789', '012345678900', 'sv1', 11, 'user-avatar-male-5-512.png'),
(2, 'Bùi Tiến', 'Dũng', '63123456', '63.CNTT-3', 'Nam', '2003-02-02', 'Khánh Hòa', 'Nha Trang, Khánh Hòa', 'btdung0202@gmail.com', '0123456790', '012345678901', 'sv2', NULL, ''),
(3, 'Trần Văn', 'Cao', '63123457', '62.CNTT-1', 'Nam', '2002-03-03', 'Khánh Hòa', 'Ninh Hòa, Khánh Hòa', 'tvcao0303@gmail.com', '0123456791', '012345678902', 'sv3', NULL, NULL),
(4, 'Nguyễn Thị', 'Thủy', '63123458', '63.CNTT-2', 'Nữ', '2003-04-04', 'Khánh Hòa', 'Nha Trang, Khánh Hòa', 'ntthuy0404@gmail.com', '0123456792', '012345678903', 'sv4', NULL, 'user-avatar-female-6-512.png'),
(5, 'Nguyễn Kiều Cẩm', 'Thơ', '62123459', '62.NNA-1', 'Nữ', '2002-05-05', 'TP.Hồ Chí Minh', 'Nha Trang, Khánh Hòa', 'nkctho0505@gmail.com', '0123456793', '012345678904', 'sv5', NULL, NULL),
(6, 'Nguyễn Hùng Tuấn', 'Kiệt', '63132184', '63.CNTT-3', 'Nam', '2003-06-29', 'Khánh Hòa', 'Ninh Sim, Khánh Hòa', 'nhtkiet2906@gmail.com', '0123456794', '012345678905', 'sv6', NULL, NULL),
(7, 'Vũ Thanh', 'Vân', '63123461', '63.NNA-2', 'Nữ', '2003-07-07', 'TP.Hồ Chí Minh', 'Nha Trang, Khánh Hòa', 'vtvan0707@gmail.com', '0123456795', '012345678906', 'sv7', NULL, NULL),
(8, 'Phạm Văn', 'Lộc', '63123462', '63.NNA-1', 'Nam', '2003-08-08', 'Khánh Hòa', 'Nha Trang, Khánh Hòa', 'pvloc0808@gmail.com', '0123456796', '012345678907', 'sv8', NULL, NULL),
(9, 'Vũ Phạm Đình', 'Thái', '63123463', '63.CNTT-2', 'Nam', '2003-09-09', 'TP.Hồ Chí Minh', 'TP.Hồ Chí Minh', 'vpdthai0909@gmail.com', '0123456797', '012345678908', 'sv9', NULL, NULL),
(10, 'Hoàng Xuân', 'Vinh', '63123464', '63.CNTT-2', 'Nam', '2003-10-10', 'TP.Hồ Chí Minh', 'TP.Hồ Chí Minh', 'hxvinh1010@gmail.com', '0123456798', '012345678909', 'sv10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `toanha`
--

CREATE TABLE `toanha` (
  `ToaNhaID` int(11) NOT NULL,
  `TenToaNha` varchar(30) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toanha`
--

INSERT INTO `toanha` (`ToaNhaID`, `TenToaNha`, `MoTa`) VALUES
(1, 'K1', 'Thoáng mát, gần khu công nghệ thông tin, có căn tin'),
(2, 'K2', 'Thoáng mát, gần khu du lịch'),
(3, 'K3', 'Thoáng mát, gần khu ngôn ngữ Anh, có căn tin'),
(4, 'K4', 'Thoáng mát, gần khu công nghệ thông tin'),
(5, 'K5', 'Thoáng mát, gần nhà đa năng'),
(6, 'K6', 'Thoáng mát, gần cổng trường');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(10) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `PasswordUser` varchar(255) NOT NULL,
  `Role` enum('Admin','User') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `PasswordUser`, `Role`) VALUES
('nv1', 'testuser', '123456', 'Admin'),
('sv1', 'cphuong', '123456', 'User'),
('sv2', 'tdung', '123456', 'User'),
('sv3', 'vcao', '123456', 'User'),
('sv4', 'tthuy', '123456', 'User'),
('sv5', 'ctho', '123456', 'User'),
('sv6', 'tkiet', '123456', 'User'),
('sv7', 'tvan', '123456', 'User'),
('sv8', 'tploc', '123456', 'User'),
('sv9', 'dthai', '123456', 'User'),
('sv10', 'xvinh', '123456', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loaiphong`
--
ALTER TABLE `loaiphong`
  ADD PRIMARY KEY (`LoaiPhongID`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`NhanVienID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`PhongID`),
  ADD KEY `ToaNhaID` (`ToaNhaID`),
  ADD KEY `LoaiPhongID` (`LoaiPhongID`);

--
-- Indexes for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD KEY `PhongID` (`PhongID`);

--
-- Indexes for table `toanha`
--
ALTER TABLE `toanha`
  ADD PRIMARY KEY (`ToaNhaID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `phong`
--
ALTER TABLE `phong`
  ADD CONSTRAINT `phong_ibfk_1` FOREIGN KEY (`ToaNhaID`) REFERENCES `toanha` (`ToaNhaID`) ON DELETE CASCADE,
  ADD CONSTRAINT `phong_ibfk_2` FOREIGN KEY (`LoaiPhongID`) REFERENCES `loaiphong` (`LoaiPhongID`) ON DELETE CASCADE;

--
-- Constraints for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD CONSTRAINT `sinhvien_ibfk_1` FOREIGN KEY (`PhongID`) REFERENCES `phong` (`PhongID`);
COMMIT;

ALTER TABLE `sinhvien`
  ADD CONSTRAINT `sinhvien_ibfk_2` FOREIGN KEY (`TaiKhoanID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
