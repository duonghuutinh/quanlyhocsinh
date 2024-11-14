-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2024 at 07:27 PM
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
-- Database: `quanlyhocsinh`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getStudentCountByClass` (IN `searchColumn` VARCHAR(50), IN `searchKeyword` VARCHAR(255), IN `sortColumn` VARCHAR(50), IN `sortOrder` VARCHAR(4))   BEGIN
    SET @sql = CONCAT(
        "SELECT 
            CASE 
                WHEN l.tenLop LIKE '10%' THEN 'Khối 10'
                WHEN l.tenLop LIKE '11%' THEN 'Khối 11'
                WHEN l.tenLop LIKE '12%' THEN 'Khối 12'
                ELSE 'Khối Khác'
            END AS khoi,
            COUNT(h.maHS) AS soSiSo,
            n.maNamHoc, 
            n.nienKhoa
        FROM 
            namhoc n
        JOIN 
            lop l ON n.maNamHoc = l.maNamHoc
        JOIN 
            hocsinh h ON l.maLop = h.maLop
        GROUP BY 
            khoi, n.maNamHoc, n.nienKhoa"
    );

    -- Thêm điều kiện tìm kiếm nếu có
    IF searchColumn IS NOT NULL AND searchKeyword IS NOT NULL THEN
        SET @sql = CONCAT(@sql, " HAVING ", searchColumn, " LIKE '", searchKeyword, "'");
    END IF;

    -- Thêm điều kiện sắp xếp nếu có
    IF sortColumn IS NOT NULL AND sortOrder IS NOT NULL THEN
        SET @sql = CONCAT(@sql, " ORDER BY ", sortColumn, " ", sortOrder);
    END IF;

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `thongKeGiaoVienTheoGioiTinh` ()   BEGIN
    SELECT gioiTinh, COUNT(*) AS soLuong
    FROM giaovien
    GROUP BY gioiTinh;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `thong_ke_hocsinh_theo_khoi` ()   BEGIN
    SELECT 
        namhoc.nienKhoa,
        lop.khoi,  -- Nhóm theo khối
        GROUP_CONCAT(DISTINCT lop.tenLop ORDER BY lop.tenLop ASC) AS danhSachLop,  -- Liệt kê các lớp trong khối
        COUNT(*) AS tongSo,  -- Tổng số học sinh trong khối
        SUM(CASE WHEN gioiTinh = 'Nam' THEN 1 ELSE 0 END) AS soNam,  -- Tổng số học sinh nam
        SUM(CASE WHEN gioiTinh = 'Nữ' THEN 1 ELSE 0 END) AS soNu,  -- Tổng số học sinh nữ
        GROUP_CONCAT(hocsinh.hoTen ORDER BY hocsinh.hoTen ASC) AS danhSachHocsinh  -- Danh sách học sinh trong khối
    FROM 
        hocsinh
    JOIN 
        lop ON hocsinh.maLop = lop.maLop
    JOIN 
        namhoc ON lop.maNamHoc = namhoc.maNamHoc
    GROUP BY 
        namhoc.nienKhoa, lop.khoi;  -- Nhóm theo niên khóa và khối
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `thong_ke_hocsinh_theo_lop` ()   BEGIN
    SELECT 
        namhoc.nienKhoa,
        lop.tenLop, 
        COUNT(*) AS tongSo,
        SUM(CASE WHEN gioiTinh = 'Nam' THEN 1 ELSE 0 END) AS soNam,
        SUM(CASE WHEN gioiTinh = 'Nữ' THEN 1 ELSE 0 END) AS soNu,
        GROUP_CONCAT(hocsinh.hoTen ORDER BY hocsinh.hoTen ASC) AS danhSachHocsinh
    FROM 
        hocsinh
    JOIN 
        lop ON hocsinh.maLop = lop.maLop
    JOIN 
        namhoc ON lop.maNamHoc = namhoc.maNamHoc
    GROUP BY 
        namhoc.nienKhoa, lop.tenLop;  -- Nhóm theo niên khóa và tên lớp
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `DemSoLuongGiaoVien` () RETURNS INT(11)  BEGIN
    DECLARE soLuong INT;
    SELECT COUNT(*) INTO soLuong FROM giaovien;
    RETURN soLuong;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chunhiem`
--

CREATE TABLE `chunhiem` (
  `maGV` varchar(10) NOT NULL,
  `maLop` int(11) NOT NULL,
  `maNamHoc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chunhiem`
--

INSERT INTO `chunhiem` (`maGV`, `maLop`, `maNamHoc`) VALUES
('GV105', 1, 2020),
('GV110', 2, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `giaovien`
--

CREATE TABLE `giaovien` (
  `maGV` varchar(10) NOT NULL,
  `hoTen` varchar(50) DEFAULT NULL,
  `ngaySinh` date DEFAULT NULL,
  `diaChi` varchar(100) DEFAULT NULL,
  `SDT` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gioiTinh` enum('Nam','Nữ','Khác') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `giaovien`
--

INSERT INTO `giaovien` (`maGV`, `hoTen`, `ngaySinh`, `diaChi`, `SDT`, `email`, `gioiTinh`) VALUES
('GV101', 'Nguyễn An', '2021-02-10', 'hậu giang', '0212123678', 'gv101@example.com', 'Nam'),
('GV102', 'Trần Thị Bích', '1982-05-20', 'Vĩnh Long', '0987654321', 'gv102@example.com', 'Nữ'),
('GV103', 'Lê Văn Cường', '1975-11-25', 'Đồng Tháp', '0934567890', 'gv103@example.com', 'Nam'),
('GV104', 'Phạm Thị Duyên', '1984-07-12', 'An Giang', '0911223344', 'gv104@example.com', 'Nữ'),
('GV105', 'Huỳnh Văn Hòa', '1979-09-23', 'Sóc Trăng', '0944332211', 'gv105@example.com', 'Nam'),
('GV106', 'Nguyễn Thị Hương', '1986-03-18', 'Tiền Giang', '0901234567', 'gv106@example.com', 'Nữ'),
('GV107', 'Trần Văn Tùng', '1990-04-05', 'Bến Tre', '0912345679', 'gv107@example.com', 'Nam'),
('GV108', 'Lê Thị Hoa', '1985-12-10', 'Hậu Giang', '0923456780', 'gv108@example.com', 'Nữ'),
('GV109', 'Phạm Minh Tuấn', '1988-06-30', 'Kiên Giang', '0931234568', 'gv109@example.com', 'Nam'),
('GV110', 'Huỳnh Thị Hằng', '1992-08-14', 'Cà Mau', '0945678901', 'gv110@example.com', 'Nữ'),
('GV111', 'Nguyễn Văn Phúc', '1983-10-20', 'Vĩnh Long', '0909876543', 'gv111@example.com', 'Nam'),
('GV112', 'Trần Thị Như', '1991-01-25', 'Đồng Tháp', '0913456782', 'gv112@example.com', 'Nữ'),
('GV113', 'Lê Văn Minh', '1989-11-11', 'An Giang', '0922345678', 'gv113@example.com', 'Nam'),
('GV114', 'Phạm Thị Hạnh', '1987-05-15', 'Hà Tiên', '0934567891', 'gv114@example.com', 'Nữ'),
('GV115', 'Nguyễn Thị Lan', '1985-02-22', 'Sóc Trăng', '0912345680', 'gv115@example.com', 'Nam'),
('GV116', 'Trần Văn Hải', '1981-09-09', 'Bạc Liêu', '0945678910', 'gv116@example.com', 'Nữ'),
('GV117', 'Lê Thị Bảo', '1994-07-01', 'Cần Thơ', '0908765432', 'gv117@example.com', 'Nam'),
('GV118', 'Phạm Minh Quang', '1993-03-20', 'Hậu Giang', '0971831109', 'gv118@example.com', 'Nữ'),
('GV119', 'Huỳnh Văn Duy', '1980-08-14', 'Tiền Giang', '0923456789', 'gv119@example.com', 'Nam'),
('GV120', 'Nguyễn Văn Khải', '1978-11-28', 'Bến Tre', '0934567801', 'gv120@example.com', 'Nữ'),
('GV121', 'Dương Hửu Tính', '2024-11-17', 'qưewqe', '2312323123', 'gv121@example.com', 'Nam'),
('GV123', 'Phạm Minh Quang', '2024-11-17', 'Cần thơ', '1231231231', 'gv123@example.com', 'Nam'),
('GV180', 'Cao Nguyễn Mỹ Quyên', '2024-11-18', 'eeeeeeeee', '0395549131', 'tinhb2111902@student.ctu.edu.vne', 'Nam');

--
-- Triggers `giaovien`
--
DELIMITER $$
CREATE TRIGGER `before_teacher_delete` BEFORE DELETE ON `giaovien` FOR EACH ROW BEGIN
    INSERT INTO log_deletions (maGV, hoTen)
    VALUES (OLD.maGV, OLD.hoTen);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hocky`
--

CREATE TABLE `hocky` (
  `maHocKy` int(11) NOT NULL,
  `tenHocKy` varchar(100) NOT NULL,
  `maNamHoc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hocky`
--

INSERT INTO `hocky` (`maHocKy`, `tenHocKy`, `maNamHoc`) VALUES
(1, 'Học Kỳ 1', 2020),
(2, 'Học Kỳ 2', 2020),
(3, 'Học Kỳ 1', 2021),
(4, 'Học Kỳ 2', 2021),
(5, 'Học Kỳ 1', 2022),
(6, 'Học Kỳ 2', 2022),
(7, 'Học Kỳ 1', 2023),
(8, 'Học Kỳ 2', 2023),
(9, 'Học Kỳ 1', 2024),
(10, 'Học Kỳ 2', 2024);

-- --------------------------------------------------------

--
-- Table structure for table `hocsinh`
--

CREATE TABLE `hocsinh` (
  `maHS` varchar(10) NOT NULL,
  `hoTen` varchar(50) DEFAULT NULL,
  `ngaySinh` date DEFAULT NULL,
  `diaChi` varchar(100) DEFAULT NULL,
  `sdtPH` varchar(15) DEFAULT NULL,
  `maLop` int(11) DEFAULT NULL,
  `gioiTinh` enum('Nam','Nữ','Khác') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hocsinh`
--

INSERT INTO `hocsinh` (`maHS`, `hoTen`, `ngaySinh`, `diaChi`, `sdtPH`, `maLop`, `gioiTinh`) VALUES
('HS0001', 'Nguyễn Thị Mai', '2008-01-05', '34 Lý Thường Kiệt, Cần Thơ', '0912345678', 2, 'Nữ'),
('HS0002', 'Trần Minh Tuấn', '2008-06-08', '55 Nguyễn Thái Học, Ninh Kiều', '0987654321', 1, 'Nam'),
('HS0003', 'Nguyễn Hồng Hạnh', '2008-10-10', '3/2 Ninh Kiều, Cần Thơ', '0879727132', 2, 'Nữ'),
('HS0004', 'Trần Hoàng Huy', '2008-06-15', 'Cái Khế, Cần Thơ', '0937417578', 2, 'Nam'),
('HS0006', 'Trần Minh Hải', '2024-11-27', '4234234', '2342342342', 6, 'Nam'),
('HS0007', 'Trần Hải Hà', '2024-11-01', '3123', '2312312312', 10, 'Nam'),
('HS0008', 'Nguyễn Thị Thanh ', '2024-11-09', '123123', '2312312312', 9, 'Nữ');

--
-- Triggers `hocsinh`
--
DELIMITER $$
CREATE TRIGGER `before_delete_hocsinh` BEFORE DELETE ON `hocsinh` FOR EACH ROW BEGIN
    -- Sao lưu học sinh và niên khóa vào bảng hocsinh_deleted
    INSERT INTO hocsinh_deleted (maHS, hoTen, gioiTinh, maLop, nienKhoa, ngaySinh, sdtPH, diaChi)
    SELECT OLD.maHS, OLD.hoTen, OLD.gioiTinh, OLD.maLop, namhoc.nienKhoa, OLD.ngaySinh, OLD.sdtPH, OLD.diaChi
    FROM hocsinh
    JOIN lop ON hocsinh.maLop = lop.maLop
    JOIN namhoc ON lop.maNamHoc = namhoc.maNamHoc
    WHERE hocsinh.maHS = OLD.maHS;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hocsinh_deleted`
--

CREATE TABLE `hocsinh_deleted` (
  `maHS` varchar(20) NOT NULL,
  `hoTen` varchar(255) DEFAULT NULL,
  `gioiTinh` varchar(50) DEFAULT NULL,
  `maLop` varchar(20) DEFAULT NULL,
  `nienKhoa` varchar(20) DEFAULT NULL,
  `ngaySinh` date DEFAULT NULL,
  `sdtPH` varchar(20) DEFAULT NULL,
  `diaChi` varchar(255) DEFAULT NULL,
  `ngayXoa` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hocsinh_deleted`
--

INSERT INTO `hocsinh_deleted` (`maHS`, `hoTen`, `gioiTinh`, `maLop`, `nienKhoa`, `ngaySinh`, `sdtPH`, `diaChi`, `ngayXoa`) VALUES
('HS0020', 'Võ Công', 'Nam', '13', '2022-2023', '2008-01-01', '0909090909', 'vĩnh long', '2024-11-13 14:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `khoi`
--

CREATE TABLE `khoi` (
  `maKhoi` int(11) NOT NULL,
  `tenKhoi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khoi`
--

INSERT INTO `khoi` (`maKhoi`, `tenKhoi`) VALUES
(1, 'Khối 10'),
(2, 'Khối 11'),
(3, 'Khối 12');

-- --------------------------------------------------------

--
-- Table structure for table `log_deletions`
--

CREATE TABLE `log_deletions` (
  `id` int(11) NOT NULL,
  `maGV` varchar(50) DEFAULT NULL,
  `hoTen` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_deletions`
--

INSERT INTO `log_deletions` (`id`, `maGV`, `hoTen`, `deleted_at`) VALUES
(1, 'GV200', 'Nguyễn Hạnh', '2024-11-13 13:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `lop`
--

CREATE TABLE `lop` (
  `maLop` int(11) NOT NULL,
  `tenLop` varchar(50) DEFAULT NULL,
  `maNamHoc` int(11) DEFAULT NULL,
  `maKhoi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lop`
--

INSERT INTO `lop` (`maLop`, `tenLop`, `maNamHoc`, `maKhoi`) VALUES
(1, '10A1', 2020, 1),
(2, '10A2', 2020, 1),
(3, '10A3', 2020, 1),
(4, '10A4', 2020, 1),
(6, '11A1', 2021, 2),
(7, '11A2', 2021, 2),
(8, '11A3', 2021, 2),
(9, '12A1', 2022, 3),
(10, '12A2', 2022, 3),
(11, '12A3', 2022, 3),
(12, '12A4', 2022, 3),
(13, '12A5', 2022, 3);

-- --------------------------------------------------------

--
-- Table structure for table `namhoc`
--

CREATE TABLE `namhoc` (
  `maNamHoc` int(11) NOT NULL,
  `nienKhoa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `namhoc`
--

INSERT INTO `namhoc` (`maNamHoc`, `nienKhoa`) VALUES
(2020, '2020-2021'),
(2021, '2021-2022'),
(2022, '2022-2023'),
(2023, '2023-2024'),
(2024, '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `phonghoc`
--

CREATE TABLE `phonghoc` (
  `maPhong` varchar(10) NOT NULL,
  `soPhong` int(11) DEFAULT NULL,
  `soChoToiDa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phonghoc`
--

INSERT INTO `phonghoc` (`maPhong`, `soPhong`, `soChoToiDa`) VALUES
('P101', 101, 40),
('P102', 102, 40),
('P103', 103, 40),
('P104', 104, 40),
('P105', 105, 40),
('P106', 106, 40),
('P107', 107, 40),
('P108', 108, 40),
('P109', 109, 40),
('P110', 110, 40),
('P201', 201, 40),
('P202', 202, 40),
('P203', 203, 40),
('P204', 204, 40),
('P205', 205, 40),
('P206', 206, 40),
('P207', 207, 40),
('P208', 208, 40),
('P209', 209, 40),
('P210', 210, 40),
('P301', 301, 40),
('P302', 302, 40),
('P303', 303, 40),
('P304', 304, 40),
('P305', 305, 40),
('P306', 306, 40),
('P307', 307, 40),
('P308', 308, 40),
('P309', 309, 40),
('P310', 310, 40);

-- --------------------------------------------------------

--
-- Table structure for table `phonglop`
--

CREATE TABLE `phonglop` (
  `maPhong` varchar(10) NOT NULL,
  `maLop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phonglop`
--

INSERT INTO `phonglop` (`maPhong`, `maLop`) VALUES
('P101', 2),
('P102', 1),
('P102', 6),
('P103', 3),
('P104', 4),
('P105', 8),
('P204', 7),
('P301', 9);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `hovaten` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `taikhoan` varchar(50) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`hovaten`, `email`, `taikhoan`, `matkhau`, `role`) VALUES
('', '', '', '$2y$10$vWdVIHCD4WmAdL6Bg5GJ.uNVXF6T8hmE/bhYAw9sWn8nQY.R36vua', 1),
('Dương Hửu Tính', 'tinhb2111902@student.ctu.edu.vn', '123', '$2y$10$CmAQeMuUT3KkYIefG8K44uMITl4BEJcUli1WEqxyTfbTyXgW2V.5W', 1),
('Dương Hửu Tính', 'admin@gmail.com', 'admin', '$2y$10$O.MDF/Nags7ltD3zmJ5PLec0sPRWjYekXLc/czmSu76xsKSGE.jYi', 1),
('Châu Quách Định', 'duonghuutinh1408@gmail.com', 'b2111902', '$2y$10$YUTeYiFbZ7S8/E7kPZ3Xte1owrsX4GwnNn7kzqk4mfXUe/EZLZaM6', 1),
('Dương Hửu Tính', 'tinhb2111902@student.ctu.edu.vn', 'duongtc1233', '$2y$10$qlDjGTKieC/LFwVLtQRxa.Kqnc7TRnwN6Ys55RwkkuMBTxy.vkM0i', 1),
('Dương Hửu Tính', 'tinhb2111902@student.ctu.edu.vn', 'duongtc12332', '$2y$10$nyFTEx.ZZr3rNLbpw3/14O9OeSc5m8SCrbRM6pndvq.ORFg2IpIgS', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chunhiem`
--
ALTER TABLE `chunhiem`
  ADD PRIMARY KEY (`maGV`,`maLop`),
  ADD KEY `maLop` (`maLop`),
  ADD KEY `fk_chunhiem_namhoc` (`maNamHoc`);

--
-- Indexes for table `giaovien`
--
ALTER TABLE `giaovien`
  ADD PRIMARY KEY (`maGV`);

--
-- Indexes for table `hocky`
--
ALTER TABLE `hocky`
  ADD PRIMARY KEY (`maHocKy`),
  ADD KEY `maNamHoc` (`maNamHoc`);

--
-- Indexes for table `hocsinh`
--
ALTER TABLE `hocsinh`
  ADD PRIMARY KEY (`maHS`),
  ADD KEY `maLop` (`maLop`);

--
-- Indexes for table `hocsinh_deleted`
--
ALTER TABLE `hocsinh_deleted`
  ADD PRIMARY KEY (`maHS`);

--
-- Indexes for table `khoi`
--
ALTER TABLE `khoi`
  ADD PRIMARY KEY (`maKhoi`);

--
-- Indexes for table `log_deletions`
--
ALTER TABLE `log_deletions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`maLop`),
  ADD KEY `fk_namhoc_maNamHoc` (`maNamHoc`);

--
-- Indexes for table `namhoc`
--
ALTER TABLE `namhoc`
  ADD PRIMARY KEY (`maNamHoc`);

--
-- Indexes for table `phonghoc`
--
ALTER TABLE `phonghoc`
  ADD PRIMARY KEY (`maPhong`);

--
-- Indexes for table `phonglop`
--
ALTER TABLE `phonglop`
  ADD PRIMARY KEY (`maPhong`,`maLop`),
  ADD KEY `maLop` (`maLop`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`taikhoan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `khoi`
--
ALTER TABLE `khoi`
  MODIFY `maKhoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `log_deletions`
--
ALTER TABLE `log_deletions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lop`
--
ALTER TABLE `lop`
  MODIFY `maLop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `namhoc`
--
ALTER TABLE `namhoc`
  MODIFY `maNamHoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2026;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chunhiem`
--
ALTER TABLE `chunhiem`
  ADD CONSTRAINT `chunhiem_ibfk_1` FOREIGN KEY (`maGV`) REFERENCES `giaovien` (`maGV`),
  ADD CONSTRAINT `fk_chunhiem_namhoc` FOREIGN KEY (`maNamHoc`) REFERENCES `namhoc` (`maNamHoc`);

--
-- Constraints for table `hocky`
--
ALTER TABLE `hocky`
  ADD CONSTRAINT `hocky_ibfk_1` FOREIGN KEY (`maNamHoc`) REFERENCES `namhoc` (`maNamHoc`);

--
-- Constraints for table `lop`
--
ALTER TABLE `lop`
  ADD CONSTRAINT `fk_namhoc_maNamHoc` FOREIGN KEY (`maNamHoc`) REFERENCES `namhoc` (`maNamHoc`);

--
-- Constraints for table `phonglop`
--
ALTER TABLE `phonglop`
  ADD CONSTRAINT `phonglop_ibfk_1` FOREIGN KEY (`maPhong`) REFERENCES `phonghoc` (`maPhong`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
