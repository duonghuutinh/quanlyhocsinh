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
  CONSTRAINT `fk_chunhiem_namhoc` FOREIGN KEY (`maNamHoc`) REFERENCES `namhoc` (`maNamHoc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chunhiem`
--

LOCK TABLES `chunhiem` WRITE;
/*!40000 ALTER TABLE `chunhiem` DISABLE KEYS */;
INSERT INTO `chunhiem` VALUES ('GV105',1,2020),('GV110',2,2020);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
  KEY `maLop` (`maLop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hocsinh`
--

LOCK TABLES `hocsinh` WRITE;
/*!40000 ALTER TABLE `hocsinh` DISABLE KEYS */;
INSERT INTO `hocsinh` VALUES ('HS0001','Nguyễn Thị Mai','2008-01-05','34 Lý Thường Kiệt, Cần Thơ','0912345678',2,'Nữ'),('HS0002','Trần Minh Tuấn','2008-06-08','55 Nguyễn Thái Học, Ninh Kiều','0987654321',1,'Nam'),('HS0003','Nguyễn Hồng Hạnh','2008-10-10','3/2 Ninh Kiều, Cần Thơ','0879727132',2,'Nữ'),('HS0004','Trần Hoàng Huy','2008-06-15','Cái Khế, Cần Thơ','0937417578',2,'Nam'),('HS0006','Trần Minh Hải','2024-11-27','4234234','2342342342',6,'Nam'),('HS0007','Trần Hải Hà','2024-11-01','3123','2312312312',10,'Nam'),('HS0008','Nguyễn Thị Thanh ','2024-11-09','123123','2312312312',9,'Nữ');
/*!40000 ALTER TABLE `hocsinh` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `khoi`
--

DROP TABLE IF EXISTS `khoi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `khoi` (
  `maKhoi` int NOT NULL AUTO_INCREMENT,
  `tenKhoi` varchar(100) NOT NULL,
  PRIMARY KEY (`maKhoi`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `khoi`
--

LOCK TABLES `khoi` WRITE;
/*!40000 ALTER TABLE `khoi` DISABLE KEYS */;
INSERT INTO `khoi` VALUES (1,'Khối 10'),(2,'Khối 11'),(3,'Khối 12');
/*!40000 ALTER TABLE `khoi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lop`
--

DROP TABLE IF EXISTS `lop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lop` (
  `maLop` int NOT NULL AUTO_INCREMENT,
  `tenLop` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `maNamHoc` int DEFAULT NULL,
  `maKhoi` int DEFAULT NULL,
  PRIMARY KEY (`maLop`),
  KEY `fk_namhoc_maNamHoc` (`maNamHoc`),
  CONSTRAINT `fk_namhoc_maNamHoc` FOREIGN KEY (`maNamHoc`) REFERENCES `namhoc` (`maNamHoc`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lop`
--

LOCK TABLES `lop` WRITE;
/*!40000 ALTER TABLE `lop` DISABLE KEYS */;
INSERT INTO `lop` VALUES (1,'10A1',2020,1),(2,'10A2',2020,1),(3,'10A3',2020,1),(4,'10A4',2020,1),(6,'11A1',2021,2),(7,'11A2',2021,2),(8,'11A3',2021,2),(9,'12A1',2022,3),(10,'12A2',2022,3),(11,'12A3',2022,3),(12,'12A4',2022,3),(13,'12A5',2022,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=2026 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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
INSERT INTO `phonghoc` VALUES ('P101',101,40),('P102',102,40),('P103',103,40),('P104',104,40),('P105',105,40),('P106',106,40),('P107',107,40),('P108',108,40),('P109',109,40),('P110',110,40),('P201',201,40),('P202',202,40),('P203',203,40),('P204',204,40),('P205',205,40),('P206',206,40),('P207',207,40),('P208',208,40),('P209',209,40),('P210',210,40),('P301',301,40),('P302',302,40),('P303',303,40),('P304',304,40),('P305',305,40),('P306',306,40),('P307',307,40),('P308',308,40),('P309',309,40),('P310',310,40);
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
  PRIMARY KEY (`maPhong`,`maLop`),
  KEY `maLop` (`maLop`),
  CONSTRAINT `phonglop_ibfk_1` FOREIGN KEY (`maPhong`) REFERENCES `phonghoc` (`maPhong`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phonglop`
--

LOCK TABLES `phonglop` WRITE;
/*!40000 ALTER TABLE `phonglop` DISABLE KEYS */;
INSERT INTO `phonglop` VALUES ('P102',1),('P101',2),('P103',3),('P104',4),('P102',6),('P204',7),('P105',8),('P301',9);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
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

-- Dump completed on 2024-11-11 16:28:16
