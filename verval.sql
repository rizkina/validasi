-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.10.2-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table verval.calonsiswa
CREATE TABLE IF NOT EXISTS `calonsiswa` (
  `NISN` varchar(10) NOT NULL,
  `NoRegistrasi` varchar(10) DEFAULT NULL,
  `Nama` varchar(100) DEFAULT NULL,
  `TempatLahir` varchar(100) DEFAULT NULL,
  `TanggalLahir` date DEFAULT NULL,
  `NamaIbu` varchar(100) DEFAULT NULL,
  `NpsnAsal` varchar(8) DEFAULT NULL,
  `StatusValidasi` set('Sudah','Belum') DEFAULT NULL,
  PRIMARY KEY (`NISN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table verval.calonsiswa: ~0 rows (approximately)
DELETE FROM `calonsiswa`;
/*!40000 ALTER TABLE `calonsiswa` DISABLE KEYS */;
/*!40000 ALTER TABLE `calonsiswa` ENABLE KEYS */;

-- Dumping structure for table verval.dokumen
CREATE TABLE IF NOT EXISTS `dokumen` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NISN` varchar(10) DEFAULT NULL,
  `JenisDocumentID` int(11) DEFAULT NULL,
  `StatusDokumen` set('Ada','Tidak') DEFAULT NULL,
  `Kesesuaian` set('Ya','Tidak') DEFAULT NULL,
  `Keterangan` text DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `NISN` (`NISN`),
  KEY `JenisDocumentID` (`JenisDocumentID`),
  CONSTRAINT `dokumen_ibfk_1` FOREIGN KEY (`NISN`) REFERENCES `calonsiswa` (`NISN`),
  CONSTRAINT `dokumen_ibfk_2` FOREIGN KEY (`JenisDocumentID`) REFERENCES `jenisdocument` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table verval.dokumen: ~0 rows (approximately)
DELETE FROM `dokumen`;
/*!40000 ALTER TABLE `dokumen` DISABLE KEYS */;
/*!40000 ALTER TABLE `dokumen` ENABLE KEYS */;

-- Dumping structure for table verval.jenisdocument
CREATE TABLE IF NOT EXISTS `jenisdocument` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DocNo` varchar(5) NOT NULL,
  `NamaDokumen` text NOT NULL,
  `StatusDok` set('Aktif','Tidak') NOT NULL DEFAULT 'Aktif',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table verval.jenisdocument: ~0 rows (approximately)
DELETE FROM `jenisdocument`;
/*!40000 ALTER TABLE `jenisdocument` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenisdocument` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
