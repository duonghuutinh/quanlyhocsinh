-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2024 at 05:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28
use quanlyhocsinh;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlhs`
--

-- --------------------------------------------------------

--
-- Table structure for table `chuNhiem`
--

CREATE TABLE `chuNhiem` (
  `maGV` int(10) NOT NULL,
  `maLop` int(10) NOT NULL,
  `namHoc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chuNhiem`
--

INSERT INTO `chuNhiem` (`maGV`, `maLop`, `namHoc`) VALUES
(1, 101, '2023'),
(1, 101, '2023'),
(2, 102, '2023-2024');

-- --------------------------------------------------------

--
-- Table structure for table `diem`
--

CREATE TABLE `diem` (
  `maHS` int(11) NOT NULL,
  `maMon` int(11) NOT NULL,
  `diemMieng` int(11) NOT NULL,
  `diem15p` int(11) NOT NULL,
  `diem1t` int(11) NOT NULL,
  `diemThi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `giaoVien`
--

CREATE TABLE `giaoVien` (
  `maGV` int(11) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `ngaySinh` date NOT NULL,
  `diaChi` varchar(200) NOT NULL,
  `SDT` varchar(10) NOT NULL,
  `password` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `giaoVien`
--

INSERT INTO `giaoVien` (`maGV`, `hoTen`, `ngaySinh`, `diaChi`, `SDT`, `password`) VALUES
(1, 'Nguyễn Thị Thanh Tuyền', '2003-02-25', 'ninh kiều, cần thơ', '0869837470', '$2y$10$e3WZAa2va6oCdDKv52igzOL0G5Od/lT1t0j7HXlSurukJJKoFRQEu'),
(2, 'Nguyễn Ánh Đào', '2000-02-23', 'Ninh Kiều, Cần Thơ', '0909090909', '123');

--
-- Triggers `giaoVien`
--
DELIMITER $$
CREATE TRIGGER `check_maGV_unique` BEFORE INSERT ON `giaoVien` FOR EACH ROW BEGIN
    DECLARE existingCount INT;

    -- Đếm số lượng bản ghi với maGV tương ứng
    SELECT COUNT(*) INTO existingCount FROM giaovien WHERE maGV = NEW.maGV;

    -- Nếu số lượng lớn hơn 0, tức là maGV đã tồn tại
    IF existingCount > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Mã giáo viên đã tồn tại!';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hocSinh`
--

CREATE TABLE `hocSinh` (
  `maHS` int(10) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `ngaySinh` date NOT NULL,
  `diaChi` varchar(100) NOT NULL,
  `sdtPH` varchar(10) NOT NULL,
  `maLop` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `hocSinh`
--
DELIMITER $$
CREATE TRIGGER `after_student_delete` AFTER DELETE ON `hocSinh` FOR EACH ROW BEGIN
    UPDATE lop
    SET soLuongHocSinh = count_students_in_class(OLD.maLop)
    WHERE maLop = OLD.maLop;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_student_insert` AFTER INSERT ON `hocSinh` FOR EACH ROW BEGIN
    UPDATE lop
    SET soLuongHocSinh = count_students_in_class(NEW.maLop)
    WHERE maLop = NEW.maLop;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lop`
--

CREATE TABLE `lop` (
  `maLop` int(11) NOT NULL,
  `tenLop` varchar(50) NOT NULL,
  `nienKhoa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lop`
--

INSERT INTO `lop` (`maLop`, `tenLop`, `nienKhoa`) VALUES
(101, '10A1', '2023-2024'),
(102, '10A2', '2023-2024'),
(103, '10A3', '2023-2024'),
(104, '10A4', '2021-2022'),
(105, '10A5', '2023-2024'),
(111, '11A1', '2023-2024'),
(112, '11A2', '2021-2022'),
(113, '11A3', '2023-2024'),
(114, '11A4', '2022-2023'),
(115, '11A5', '2022-2023'),
(121, '12A1', '2022-2023'),
(122, '12A2', '2023-2024');

--
-- Triggers `lop`
--
DELIMITER $$
CREATE TRIGGER `before_delete_lop` BEFORE DELETE ON `lop` FOR EACH ROW BEGIN
    INSERT INTO lop_deleted (maLop, tenLop, nienKhoa)
    VALUES (OLD.maLop, OLD.tenLop, OLD.nienKhoa);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_lop` BEFORE UPDATE ON `lop` FOR EACH ROW BEGIN
    INSERT INTO lop_history (maLop, old_tenLop, old_nienKhoa, updated_at)
    VALUES (OLD.maLop, OLD.tenLop, OLD.nienKhoa, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lop_da_xoa`
--

CREATE TABLE `lop_da_xoa` (
  `maLop` int(11) NOT NULL,
  `tenLop` varchar(50) NOT NULL,
  `nienKhoa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lop_history`
--

CREATE TABLE `lop_history` (
  `maLop` int(11) NOT NULL,
  `tenLop` varchar(50) NOT NULL,
  `nienKhoa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monHoc`
--

CREATE TABLE `monHoc` (
  `maMon` int(11) NOT NULL,
  `tenMon` varchar(50) NOT NULL,
  `Khoi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phongHoc`
--

CREATE TABLE `phongHoc` (
  `maPhong` int(11) NOT NULL,
  `soPhong` int(11) NOT NULL,
  `choToiDa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phongLop`
--

CREATE TABLE `phongLop` (
  `maPhong` int(11) NOT NULL,
  `maLop` int(11) NOT NULL,
  `hocKyNamHoc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chuNhiem`
--
ALTER TABLE `chuNhiem`
  ADD KEY `maGV` (`maGV`),
  ADD KEY `maLop` (`maLop`);

--
-- Indexes for table `diem`
--
ALTER TABLE `diem`
  ADD KEY `maHS` (`maHS`),
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
  ADD PRIMARY KEY (`maPhong`),
  ADD KEY `maLop` (`maLop`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `giaoVien`
--
ALTER TABLE `giaoVien`
  MODIFY `maGV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12345;

--
-- AUTO_INCREMENT for table `hocSinh`
--
ALTER TABLE `hocSinh`
  MODIFY `maHS` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lop`
--
ALTER TABLE `lop`
  MODIFY `maLop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `monHoc`
--
ALTER TABLE `monHoc`
  MODIFY `maMon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phongHoc`
--
ALTER TABLE `phongHoc`
  MODIFY `maPhong` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phongLop`
--
ALTER TABLE `phongLop`
  MODIFY `maPhong` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chuNhiem`
--
ALTER TABLE `chuNhiem`
  ADD CONSTRAINT `chunhiem_ibfk_1` FOREIGN KEY (`maGV`) REFERENCES `giaoVien` (`maGV`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chunhiem_ibfk_2` FOREIGN KEY (`maLop`) REFERENCES `lop` (`maLop`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `diem`
--
ALTER TABLE `diem`
  ADD CONSTRAINT `diem_ibfk_1` FOREIGN KEY (`maHS`) REFERENCES `hocSinh` (`maHS`),
  ADD CONSTRAINT `diem_ibfk_2` FOREIGN KEY (`maMon`) REFERENCES `monHoc` (`maMon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hocSinh`
--
ALTER TABLE `hocSinh`
  ADD CONSTRAINT `hocsinh_ibfk_1` FOREIGN KEY (`maLop`) REFERENCES `lop` (`maLop`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phongLop`
--
ALTER TABLE `phongLop`
  ADD CONSTRAINT `phonglop_ibfk_1` FOREIGN KEY (`maLop`) REFERENCES `lop` (`maLop`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phonglop_ibfk_2` FOREIGN KEY (`maPhong`) REFERENCES `phongHoc` (`maPhong`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
