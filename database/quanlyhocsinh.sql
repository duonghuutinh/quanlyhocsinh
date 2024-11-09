-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: quanlyhocsinh
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chunhiem`
--

DROP TABLE IF EXISTS `chunhiem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chunhiem` (
  `maGV` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `maLop` int NOT NULL,
  `maNamHoc` int DEFAULT NULL,
  PRIMARY KEY (`maGV`,`maLop`),
  KEY `maLop` (`maLop`),
  KEY `fk_chunhiem_namhoc` (`maNamHoc`),
  CONSTRAINT `chunhiem_ibfk_1` FOREIGN KEY (`maGV`) REFERENCES `giaovien` (`maGV`),
  CONSTRAINT `chunhiem_ibfk_2` FOREIGN KEY (`maLop`) REFERENCES `lop` (`maLop`),
  CONSTRAINT `fk_chunhiem_namhoc` FOREIGN KEY (`maNamHoc`) REFERENCES `namhoc` (`maNamHoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chunhiem`
--

LOCK TABLES `chunhiem` WRITE;
/*!40000 ALTER TABLE `chunhiem` DISABLE KEYS */;
INSERT INTO `chunhiem` VALUES ('GV101',101,NULL),('GV101',111,NULL),('GV101',121,NULL),('GV101',888,NULL),('GV102',102,NULL),('GV102',112,NULL),('GV102',122,NULL),('GV103',103,NULL),('GV103',113,NULL),('GV103',123,NULL),('GV104',103,NULL),('GV104',104,NULL),('GV104',114,NULL),('GV104',124,NULL),('GV105',105,NULL),('GV105',115,NULL),('GV105',125,NULL),('GV121',115,NULL),('GV121',888,NULL),('GV101',1,2020),('GV112',102,2020),('GV101',105,2021),('GV102',1,2021),('GV106',104,2021),('GV180',102,2021),('GV112',104,2022);
/*!40000 ALTER TABLE `chunhiem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `giaovien`
--

DROP TABLE IF EXISTS `giaovien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `giaovien` (
  `maGV` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `hoTen` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ngaySinh` date DEFAULT NULL,
  `diaChi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `SDT` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gioiTinh` enum('Nam','Nữ','Khác') COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`maGV`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `giaovien`
--

LOCK TABLES `giaovien` WRITE;
/*!40000 ALTER TABLE `giaovien` DISABLE KEYS */;
INSERT INTO `giaovien` VALUES ('GV101','Nguyễn An','2021-02-10','hậu giang','0212123678','gv101@example.com','Nam'),('GV102','Trần Thị Bích','1982-05-20','Vĩnh Long','0987654321','gv102@example.com','Nữ'),('GV103','Lê Văn Cường','1975-11-25','Đồng Tháp','0934567890','gv103@example.com','Nam'),('GV104','Phạm Thị Duyên','1984-07-12','An Giang','0911223344','gv104@example.com','Nữ'),('GV105','Huỳnh Văn Hòa','1979-09-23','Sóc Trăng','0944332211','gv105@example.com','Nam'),('GV106','Nguyễn Thị Hương','1986-03-18','Tiền Giang','0901234567','gv106@example.com','Nữ'),('GV107','Trần Văn Tùng','1990-04-05','Bến Tre','0912345679','gv107@example.com','Nam'),('GV108','Lê Thị Hoa','1985-12-10','Hậu Giang','0923456780','gv108@example.com','Nữ'),('GV109','Phạm Minh Tuấn','1988-06-30','Kiên Giang','0931234568','gv109@example.com','Nam'),('GV110','Huỳnh Thị Hằng','1992-08-14','Cà Mau','0945678901','gv110@example.com','Nữ'),('GV111','Nguyễn Văn Phúc','1983-10-20','Vĩnh Long','0909876543','gv111@example.com','Nam'),('GV112','Trần Thị Như','1991-01-25','Đồng Tháp','0913456782','gv112@example.com','Nữ'),('GV113','Lê Văn Minh','1989-11-11','An Giang','0922345678','gv113@example.com','Nam'),('GV114','Phạm Thị Hạnh','1987-05-15','Hà Tiên','0934567891','gv114@example.com','Nữ'),('GV115','Nguyễn Thị Lan','1985-02-22','Sóc Trăng','0912345680','gv115@example.com','Nam'),('GV116','Trần Văn Hải','1981-09-09','Bạc Liêu','0945678910','gv116@example.com','Nữ'),('GV117','Lê Thị Bảo','1994-07-01','Cần Thơ','0908765432','gv117@example.com','Nam'),('GV118','Phạm Minh Quang','1993-03-20','Hậu Giang','0971831109','gv118@example.com','Nữ'),('GV119','Huỳnh Văn Duy','1980-08-14','Tiền Giang','0923456789','gv119@example.com','Nam'),('GV120','Nguyễn Văn Khải','1978-11-28','Bến Tre','0934567801','gv120@example.com','Nữ'),('GV121','Dương Hửu Tính','2024-11-17','qưewqe','2312323123','gv121@example.com','Nam'),('GV123','Phạm Minh Quang','2024-11-17','Cần thơ','1231231231','gv123@example.com','Nam'),('GV180','Cao Nguyễn Mỹ Quyên','2024-11-18','eeeeeeeee','0395549131','tinhb2111902@student.ctu.edu.vne','Nam');
/*!40000 ALTER TABLE `giaovien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hocky`
--

DROP TABLE IF EXISTS `hocky`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hocky` (
  `maHocKy` int NOT NULL,
  `tenHocKy` varchar(100) NOT NULL,
  `maNamHoc` int DEFAULT NULL,
  PRIMARY KEY (`maHocKy`),
  KEY `maNamHoc` (`maNamHoc`),
  CONSTRAINT `hocky_ibfk_1` FOREIGN KEY (`maNamHoc`) REFERENCES `namhoc` (`maNamHoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hocky`
--

LOCK TABLES `hocky` WRITE;
/*!40000 ALTER TABLE `hocky` DISABLE KEYS */;
INSERT INTO `hocky` VALUES (1,'Học Kỳ 1',2020),(2,'Học Kỳ 2',2020),(3,'Học Kỳ 1',2021),(4,'Học Kỳ 2',2021),(5,'Học Kỳ 1',2022),(6,'Học Kỳ 2',2022),(7,'Học Kỳ 1',2023),(8,'Học Kỳ 2',2023),(9,'Học Kỳ 1',2024),(10,'Học Kỳ 2',2024);
/*!40000 ALTER TABLE `hocky` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hocsinh`
--

DROP TABLE IF EXISTS `hocsinh`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hocsinh` (
  `maHS` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `hoTen` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ngaySinh` date DEFAULT NULL,
  `diaChi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sdtPH` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `maLop` int DEFAULT NULL,
  `gioiTinh` enum('Nam','Nữ','Khác') COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`maHS`),
  KEY `maLop` (`maLop`),
  CONSTRAINT `hocsinh_ibfk_1` FOREIGN KEY (`maLop`) REFERENCES `lop` (`maLop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hocsinh`
--

LOCK TABLES `hocsinh` WRITE;
/*!40000 ALTER TABLE `hocsinh` DISABLE KEYS */;
INSERT INTO `hocsinh` VALUES ('HS001','Dương Hửu Tính','2003-08-14','Ấp KosLa, xã Thanh Sơn, huyện Trà Cú, tỉnh Trà Vinh','0971831109',1,'Nam'),('HS004','Nguyễn Văn An','2008-03-12','An Giang','0911222333',101,NULL),('HS005','Trần Thị Bình','2007-04-10','Cà Mau','0944556677',101,NULL),('HS006','Lê Văn Cường','2008-09-08','Kiên Giang','0977889900',102,NULL),('HS007','Phạm Thị Duyên','2008-01-15','Bến Tre','0912345678',102,'Nam'),('HS008','Nguyễn Thị Hằng','2007-02-20','Hậu Giang','0944332211',103,NULL),('HS009','Trần Văn Hoàng','2008-03-25','Sóc Trăng','0901234567',103,NULL),('HS010','Lê Thị Lan','2008-04-30','Vĩnh Long','0912345679',104,NULL),('HS011','Phạm Minh Tuấn','2007-05-12','Đồng Tháp','0912345680',104,NULL),('HS012','Nguyễn Văn Hải','2008-06-10','Tiền Giang','0923456780',105,NULL),('HS013','Trần Thị Mai','2007-07-15','Hà Tiên','0931234568',106,'Nam'),('HS014','Lê Văn Kiệt','2008-08-20','Bạc Liêu','0945678901',111,NULL),('HS015','Phạm Thị Ngọc','2007-09-25','Cà Mau','0909876543',111,NULL),('HS016','Nguyễn Văn Thanh','2008-10-10','Vĩnh Long','0913456782',112,NULL),('HS017','Trần Văn Nam','2008-11-15','Đồng Tháp','0922345678',112,NULL),('HS018','Lê Thị Hương','2007-12-20','Hậu Giang','0934567891',113,NULL),('HS019','Phạm Minh Phúc','2008-01-30','Kiên Giang','0912345680',113,NULL),('HS020','Nguyễn Thị Như','2007-02-14','An Giang','0945678910',114,NULL),('HS021','Trần Văn Tú','2008-03-05','Bến Tre','0908765432',114,NULL),('HS022','Lê Văn Nghĩa','2008-04-18','Sóc Trăng','0911234567',115,NULL),('HS023','Phạm Thị Quỳnh','2007-05-30','Tiền Giang','0923456789',115,NULL),('HS024','Nguyễn Văn Đạt','2008-06-22','Hà Tiên','0934567801',121,NULL),('HS025','Trần Thị Lan','2007-07-19','Bạc Liêu','0901234567',121,NULL),('HS026','Lê Văn Phú','2008-08-14','Cà Mau','0912345678',122,NULL),('HS027','Phạm Thị Yến','2008-09-10','Vĩnh Long','0987654321',122,NULL),('HS028','Nguyễn Minh Khải','2007-10-25','Đồng Tháp','0934567890',123,NULL),('HS029','Trần Văn Cường','2008-11-30','Tiền Giang','0911222333',123,NULL),('HS031','Phạm Hiếu Văn','2009-01-05','Kiên Giang','0977889900',106,NULL),('HS032','Nguyễn Văn Ngọc Ngà','2009-02-28','An Giang','0912345678',106,NULL),('HS116','Cao','2024-11-16','ưeqweqwe','0678857856',103,'Nam'),('HS888','Cao Nguyễn Mỹ Quyên','2003-08-20','Hậu Giang','0678857856',111,'Nữ'),('HS902','Hồ Hoàng Hảo','2024-11-18','Cà mau','0678857856',101,'Khác');
/*!40000 ALTER TABLE `hocsinh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lop`
--

DROP TABLE IF EXISTS `lop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lop` (
  `maLop` int NOT NULL,
  `tenLop` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `maNamHoc` int DEFAULT NULL,
  PRIMARY KEY (`maLop`),
  KEY `fk_namhoc_maNamHoc` (`maNamHoc`),
  CONSTRAINT `fk_namhoc_maNamHoc` FOREIGN KEY (`maNamHoc`) REFERENCES `namhoc` (`maNamHoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lop`
--

LOCK TABLES `lop` WRITE;
/*!40000 ALTER TABLE `lop` DISABLE KEYS */;
INSERT INTO `lop` VALUES (1,'12A1',2021),(2,'12A2',2023),(4,'12A2',2024);
/*!40000 ALTER TABLE `lop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `namhoc`
--

DROP TABLE IF EXISTS `namhoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `namhoc` (
  `maNamHoc` int NOT NULL AUTO_INCREMENT,
  `nienKhoa` varchar(50) NOT NULL,
  PRIMARY KEY (`maNamHoc`)
) ENGINE=InnoDB AUTO_INCREMENT=2026 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `namhoc`
--

LOCK TABLES `namhoc` WRITE;
/*!40000 ALTER TABLE `namhoc` DISABLE KEYS */;
INSERT INTO `namhoc` VALUES (2020,'2020-2021'),(2021,'2021-2022'),(2022,'2022-2023'),(2023,'2023-2024'),(2024,'2024-2025');
/*!40000 ALTER TABLE `namhoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phonghoc`
--

DROP TABLE IF EXISTS `phonghoc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phonghoc` (
  `maPhong` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `soPhong` int DEFAULT NULL,
  `soChoToiDa` int DEFAULT NULL,
  PRIMARY KEY (`maPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phonghoc`
--

LOCK TABLES `phonghoc` WRITE;
/*!40000 ALTER TABLE `phonghoc` DISABLE KEYS */;
INSERT INTO `phonghoc` VALUES ('P101',101,40),('P102',102,35),('P103',103,45),('P104',104,50),('P105',105,30),('P106',106,40),('P107',107,45),('P108',108,38),('P109',109,32),('P110',110,48),('P888',88,152);
/*!40000 ALTER TABLE `phonghoc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phonglop`
--

DROP TABLE IF EXISTS `phonglop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phonglop` (
  `maPhong` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `maLop` int NOT NULL,
  `hocKyNamHoc` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`maPhong`,`maLop`,`hocKyNamHoc`),
  KEY `maLop` (`maLop`),
  CONSTRAINT `phonglop_ibfk_1` FOREIGN KEY (`maPhong`) REFERENCES `phonghoc` (`maPhong`),
  CONSTRAINT `phonglop_ibfk_2` FOREIGN KEY (`maLop`) REFERENCES `lop` (`maLop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phonglop`
--

LOCK TABLES `phonglop` WRITE;
/*!40000 ALTER TABLE `phonglop` DISABLE KEYS */;
INSERT INTO `phonglop` VALUES ('P101',101,'HK1_2023-2024'),('P102',102,'HK1_2023-2024'),('P103',103,'HK1_2022-2023'),('P104',104,'HK2_2023-2024'),('P105',105,'HK2_2023-2024'),('P106',111,'HK1_2023-2024'),('P888',111,'HK1_2023-2024'),('P107',112,'HK1_2023-2024'),('P108',113,'HK1_2023-2024'),('P109',114,'HK1_2023-2024'),('P110',115,'HK1_2023-2024');
/*!40000 ALTER TABLE `phonglop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taikhoan`
--

DROP TABLE IF EXISTS `taikhoan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taikhoan` (
  `hovaten` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `taikhoan` varchar(50) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `role` int NOT NULL,
  PRIMARY KEY (`taikhoan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taikhoan`
--

LOCK TABLES `taikhoan` WRITE;
/*!40000 ALTER TABLE `taikhoan` DISABLE KEYS */;
INSERT INTO `taikhoan` VALUES ('','','','$2y$10$vWdVIHCD4WmAdL6Bg5GJ.uNVXF6T8hmE/bhYAw9sWn8nQY.R36vua',1),('Dương Hửu Tính','tinhb2111902@student.ctu.edu.vn','123','$2y$10$CmAQeMuUT3KkYIefG8K44uMITl4BEJcUli1WEqxyTfbTyXgW2V.5W',1),('Dương Hửu Tính','admin@gmail.com','admin','$2y$10$O.MDF/Nags7ltD3zmJ5PLec0sPRWjYekXLc/czmSu76xsKSGE.jYi',1),('Châu Quách Định','duonghuutinh1408@gmail.com','b2111902','$2y$10$YUTeYiFbZ7S8/E7kPZ3Xte1owrsX4GwnNn7kzqk4mfXUe/EZLZaM6',1),('Dương Hửu Tính','tinhb2111902@student.ctu.edu.vn','duongtc1233','$2y$10$qlDjGTKieC/LFwVLtQRxa.Kqnc7TRnwN6Ys55RwkkuMBTxy.vkM0i',1),('Dương Hửu Tính','tinhb2111902@student.ctu.edu.vn','duongtc12332','$2y$10$nyFTEx.ZZr3rNLbpw3/14O9OeSc5m8SCrbRM6pndvq.ORFg2IpIgS',1);
/*!40000 ALTER TABLE `taikhoan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-09  9:51:22
