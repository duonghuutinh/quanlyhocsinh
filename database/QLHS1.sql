-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2024 at 10:36 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `QLHS1`
--

-- --------------------------------------------------------

--
-- Table structure for table `chuNhiem`
--

CREATE TABLE `chuNhiem` (
  `maGV` varchar(10) NOT NULL,
  `maLop` int(11) NOT NULL,
  `namHoc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chuNhiem`
--

INSERT INTO `chuNhiem` (`maGV`, `maLop`, `namHoc`) VALUES
('GV101', 101, '2023-2024'),
('GV101', 111, '2023-2024'),
('GV101', 121, '2023-2024'),
('GV102', 102, '2023-2024'),
('GV102', 112, '2023-2024'),
('GV102', 122, '2023-2024'),
('GV103', 103, '2023-2024'),
('GV103', 113, '2023-2024'),
('GV103', 123, '2023-2024'),
('GV104', 104, '2023-2024'),
('GV104', 114, '2023-2024'),
('GV104', 124, '2023-2024'),
('GV105', 105, '2023-2024'),
('GV105', 115, '2023-2024'),
('GV105', 125, '2023-2024');

-- --------------------------------------------------------

--
-- Table structure for table `diem`
--

CREATE TABLE `diem` (
  `maHS` varchar(10) NOT NULL,
  `maMon` int(11) NOT NULL,
  `diemMieng` decimal(3,1) DEFAULT NULL,
  `diem15Phut` decimal(3,1) DEFAULT NULL,
  `diem1Tiet` decimal(3,1) DEFAULT NULL,
  `diemThi` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diem`
--

INSERT INTO `diem` (`maHS`, `maMon`, `diemMieng`, `diem15Phut`, `diem1Tiet`, `diemThi`) VALUES
('HS004', 204, 9.0, 8.0, 9.0, 10.0),
('HS005', 201, 8.5, 7.0, 8.0, 9.0),
('HS005', 205, 7.5, 6.5, 7.5, 8.0),
('HS006', 202, 6.5, 7.5, 8.5, 7.0),
('HS006', 206, 8.0, 8.5, 9.0, 8.0),
('HS007', 203, 7.0, 8.0, 6.5, 8.5),
('HS007', 207, 7.0, 7.0, 6.5, 7.5),
('HS008', 208, 9.5, 8.5, 9.0, 9.5),
('HS009', 209, 6.0, 7.0, 8.0, 6.5),
('HS010', 210, 7.5, 7.5, 8.5, 7.0);

-- --------------------------------------------------------

--
-- Table structure for table `giaoVien`
--

CREATE TABLE `giaoVien` (
  `maGV` varchar(10) NOT NULL,
  `hoTen` varchar(50) DEFAULT NULL,
  `ngaySinh` date DEFAULT NULL,
  `diaChi` varchar(100) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `giaoVien`
--

INSERT INTO `giaoVien` (`maGV`, `hoTen`, `ngaySinh`, `diaChi`, `SDT`) VALUES
('GV101', 'Nguyễn Văn An', '1980-01-15', 'Cần Thơ', '0912345678'),
('GV102', 'Trần Thị Bích', '1982-05-20', 'Vĩnh Long', '0987654321'),
('GV103', 'Lê Văn Cường', '1975-11-25', 'Đồng Tháp', '0934567890'),
('GV104', 'Phạm Thị Duyên', '1984-07-12', 'An Giang', '0911223344'),
('GV105', 'Huỳnh Văn Hòa', '1979-09-23', 'Sóc Trăng', '0944332211'),
('GV106', 'Nguyễn Thị Hương', '1986-03-18', 'Tiền Giang', '0901234567'),
('GV107', 'Trần Văn Tùng', '1990-04-05', 'Bến Tre', '0912345679'),
('GV108', 'Lê Thị Hoa', '1985-12-10', 'Hậu Giang', '0923456780'),
('GV109', 'Phạm Minh Tuấn', '1988-06-30', 'Kiên Giang', '0931234568'),
('GV110', 'Huỳnh Thị Hằng', '1992-08-14', 'Cà Mau', '0945678901'),
('GV111', 'Nguyễn Văn Phúc', '1983-10-20', 'Vĩnh Long', '0909876543'),
('GV112', 'Trần Thị Như', '1991-01-25', 'Đồng Tháp', '0913456782'),
('GV113', 'Lê Văn Minh', '1989-11-11', 'An Giang', '0922345678'),
('GV114', 'Phạm Thị Hạnh', '1987-05-15', 'Hà Tiên', '0934567891'),
('GV115', 'Nguyễn Thị Lan', '1985-02-22', 'Sóc Trăng', '0912345680'),
('GV116', 'Trần Văn Hải', '1981-09-09', 'Bạc Liêu', '0945678910'),
('GV117', 'Lê Thị Bảo', '1994-07-01', 'Cần Thơ', '0908765432'),
('GV118', 'Phạm Minh Quân', '1993-03-20', 'Hậu Giang', '0911234567'),
('GV119', 'Huỳnh Văn Duy', '1980-08-14', 'Tiền Giang', '0923456789'),
('GV120', 'Nguyễn Văn Khải', '1978-11-28', 'Bến Tre', '0934567801');

-- --------------------------------------------------------

--
-- Table structure for table `hocSinh`
--

CREATE TABLE `hocSinh` (
  `maHS` varchar(10) NOT NULL,
  `hoTen` varchar(50) DEFAULT NULL,
  `ngaySinh` date DEFAULT NULL,
  `diaChi` varchar(100) DEFAULT NULL,
  `sdtPH` varchar(15) DEFAULT NULL,
  `maLop` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hocSinh`
--

INSERT INTO `hocSinh` (`maHS`, `hoTen`, `ngaySinh`, `diaChi`, `sdtPH`, `maLop`) VALUES
('HS004', 'Nguyễn Văn An', '2008-03-12', 'An Giang', '0911222333', 101),
('HS005', 'Trần Thị Bình', '2007-04-10', 'Cà Mau', '0944556677', 101),
('HS006', 'Lê Văn Cường', '2008-09-08', 'Kiên Giang', '0977889900', 102),
('HS007', 'Phạm Thị Duyên', '2008-01-15', 'Bến Tre', '0912345678', 102),
('HS008', 'Nguyễn Thị Hằng', '2007-02-20', 'Hậu Giang', '0944332211', 103),
('HS009', 'Trần Văn Hoàng', '2008-03-25', 'Sóc Trăng', '0901234567', 103),
('HS010', 'Lê Thị Lan', '2008-04-30', 'Vĩnh Long', '0912345679', 104),
('HS011', 'Phạm Minh Tuấn', '2007-05-12', 'Đồng Tháp', '0912345680', 104),
('HS012', 'Nguyễn Văn Hải', '2008-06-10', 'Tiền Giang', '0923456780', 105),
('HS013', 'Trần Thị Mai', '2007-07-15', 'Hà Tiên', '0931234568', 105),
('HS014', 'Lê Văn Kiệt', '2008-08-20', 'Bạc Liêu', '0945678901', 111),
('HS015', 'Phạm Thị Ngọc', '2007-09-25', 'Cà Mau', '0909876543', 111),
('HS016', 'Nguyễn Văn Thanh', '2008-10-10', 'Vĩnh Long', '0913456782', 112),
('HS017', 'Trần Văn Nam', '2008-11-15', 'Đồng Tháp', '0922345678', 112),
('HS018', 'Lê Thị Hương', '2007-12-20', 'Hậu Giang', '0934567891', 113),
('HS019', 'Phạm Minh Phúc', '2008-01-30', 'Kiên Giang', '0912345680', 113),
('HS020', 'Nguyễn Thị Như', '2007-02-14', 'An Giang', '0945678910', 114),
('HS021', 'Trần Văn Tú', '2008-03-05', 'Bến Tre', '0908765432', 114),
('HS022', 'Lê Văn Nghĩa', '2008-04-18', 'Sóc Trăng', '0911234567', 115),
('HS023', 'Phạm Thị Quỳnh', '2007-05-30', 'Tiền Giang', '0923456789', 115),
('HS024', 'Nguyễn Văn Đạt', '2008-06-22', 'Hà Tiên', '0934567801', 121),
('HS025', 'Trần Thị Lan', '2007-07-19', 'Bạc Liêu', '0901234567', 121),
('HS026', 'Lê Văn Phú', '2008-08-14', 'Cà Mau', '0912345678', 122),
('HS027', 'Phạm Thị Yến', '2008-09-10', 'Vĩnh Long', '0987654321', 122),
('HS028', 'Nguyễn Minh Khải', '2007-10-25', 'Đồng Tháp', '0934567890', 123),
('HS029', 'Trần Văn Cường', '2008-11-30', 'Tiền Giang', '0911222333', 123),
('HS031', 'Phạm Hiếu Văn', '2009-01-05', 'Kiên Giang', '0977889900', 106),
('HS032', 'Nguyễn Văn Ngọc Ngà', '2009-02-28', 'An Giang', '0912345678', 106);

-- --------------------------------------------------------

--
-- Table structure for table `lop`
--

CREATE TABLE `lop` (
  `maLop` int(11) NOT NULL,
  `tenLop` varchar(50) DEFAULT NULL,
  `nienKhoa` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lop`
--

INSERT INTO `lop` (`maLop`, `tenLop`, `nienKhoa`) VALUES
(101, '10A1', '2023-2024'),
(102, '10A2', '2023-2024'),
(103, '10A3', '2022-2023'),
(104, '10A4', '2022-2023'),
(105, '10A5', '2023-2024'),
(106, '10A6', '2023-2024'),
(111, '11A1', '2021-2022'),
(112, '11A2', '2021-2022'),
(113, '11A3', '2021-2022'),
(114, '11A4', '2023-2024'),
(115, '11A5', '2023-2024'),
(121, '12A1', '2022-2023'),
(122, '12A2', '2022-2023'),
(123, '12A3', '2023-2024'),
(124, '12A4', '2023-2024'),
(125, '12A5', '2023-2024');

-- --------------------------------------------------------

--
-- Table structure for table `monHoc`
--

CREATE TABLE `monHoc` (
  `maMon` int(11) NOT NULL,
  `tenMonHoc` varchar(50) DEFAULT NULL,
  `khoi` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `monHoc`
--

INSERT INTO `monHoc` (`maMon`, `tenMonHoc`, `khoi`) VALUES
(201, 'Toán', '10'),
(202, 'Vật Lý', '10'),
(203, 'Hóa Học', '11'),
(204, 'Sinh Học', '11'),
(205, 'Tiếng Anh', '10'),
(206, 'Ngữ Văn', '10'),
(207, 'Lịch Sử', '11'),
(208, 'Địa Lý', '11'),
(209, 'Thể Dục', '10'),
(210, 'Tin Học', '10');

-- --------------------------------------------------------

--
-- Table structure for table `phongHoc`
--

CREATE TABLE `phongHoc` (
  `maPhong` varchar(10) NOT NULL,
  `soPhong` int(11) DEFAULT NULL,
  `soChoToiDa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phongHoc`
--

INSERT INTO `phongHoc` (`maPhong`, `soPhong`, `soChoToiDa`) VALUES
('P101', 101, 40),
('P102', 102, 35),
('P103', 103, 45),
('P104', 104, 50),
('P105', 105, 30),
('P106', 106, 40),
('P107', 107, 45),
('P108', 108, 38),
('P109', 109, 32),
('P110', 110, 48);

-- --------------------------------------------------------

--
-- Table structure for table `phongLop`
--

CREATE TABLE `phongLop` (
  `maPhong` varchar(10) NOT NULL,
  `maLop` int(11) NOT NULL,
  `hocKyNamHoc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phongLop`
--

INSERT INTO `phongLop` (`maPhong`, `maLop`, `hocKyNamHoc`) VALUES
('P101', 101, 'HK1_2023-2024'),
('P102', 102, 'HK1_2023-2024'),
('P103', 103, 'HK1_2022-2023'),
('P104', 104, 'HK2_2023-2024'),
('P105', 105, 'HK2_2023-2024'),
('P106', 111, 'HK1_2023-2024'),
('P107', 112, 'HK1_2023-2024'),
('P108', 113, 'HK1_2023-2024'),
('P109', 114, 'HK1_2023-2024'),
('P110', 115, 'HK1_2023-2024');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chuNhiem`
--
ALTER TABLE `chuNhiem`
  ADD PRIMARY KEY (`maGV`,`maLop`,`namHoc`),
  ADD KEY `maLop` (`maLop`);

--
-- Indexes for table `diem`
--
ALTER TABLE `diem`
  ADD PRIMARY KEY (`maHS`,`maMon`),
  ADD KEY `maMon` (`maMon`);

--
-- Indexes for table `giaoVien`
--
ALTER TABLE `giaoVien`
  ADD PRIMARY KEY (`maGV`);

--
-- Indexes for table `hocSinh`
--
ALTER TABLE `hocSinh`
  ADD PRIMARY KEY (`maHS`),
  ADD KEY `maLop` (`maLop`);

--
-- Indexes for table `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`maLop`);

--
-- Indexes for table `monHoc`
--
ALTER TABLE `monHoc`
  ADD PRIMARY KEY (`maMon`);

--
-- Indexes for table `phongHoc`
--
ALTER TABLE `phongHoc`
  ADD PRIMARY KEY (`maPhong`);

--
-- Indexes for table `phongLop`
--
ALTER TABLE `phongLop`
  ADD PRIMARY KEY (`maPhong`,`maLop`,`hocKyNamHoc`),
  ADD KEY `maLop` (`maLop`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chuNhiem`
--
ALTER TABLE `chuNhiem`
  ADD CONSTRAINT `chunhiem_ibfk_1` FOREIGN KEY (`maGV`) REFERENCES `giaoVien` (`maGV`),
  ADD CONSTRAINT `chunhiem_ibfk_2` FOREIGN KEY (`maLop`) REFERENCES `lop` (`maLop`);

--
-- Constraints for table `diem`
--
ALTER TABLE `diem`
  ADD CONSTRAINT `diem_ibfk_1` FOREIGN KEY (`maHS`) REFERENCES `hocSinh` (`maHS`),
  ADD CONSTRAINT `diem_ibfk_2` FOREIGN KEY (`maMon`) REFERENCES `monHoc` (`maMon`);

--
-- Constraints for table `hocSinh`
--
ALTER TABLE `hocSinh`
  ADD CONSTRAINT `hocsinh_ibfk_1` FOREIGN KEY (`maLop`) REFERENCES `lop` (`maLop`);

--
-- Constraints for table `phongLop`
--
ALTER TABLE `phongLop`
  ADD CONSTRAINT `phonglop_ibfk_1` FOREIGN KEY (`maPhong`) REFERENCES `phongHoc` (`maPhong`),
  ADD CONSTRAINT `phonglop_ibfk_2` FOREIGN KEY (`maLop`) REFERENCES `lop` (`maLop`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
