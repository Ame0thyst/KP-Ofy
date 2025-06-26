-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 26, 2025 at 05:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urban_media_redaksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `username`, `password`, `name`, `email`, `phone`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'AdminRedaksi', 'admin@urbanmedia.com', '08123456789');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `caption_thumbnail` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `summary` text DEFAULT NULL,
  `source_article` varchar(255) DEFAULT NULL,
  `source_thumbnail` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `status` enum('Upload','Belum Upload','Pending') DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `thumbnail`, `caption_thumbnail`, `category_id`, `keywords`, `author_id`, `editor_id`, `content`, `summary`, `source_article`, `source_thumbnail`, `tags`, `status`, `created_at`) VALUES
(5, 'Apakah Protein Nabati Benar-benar Sehat? Fakta Mengejutkan yang Perlu Anda Ketahui!', '6848a9ee4b88c.jpg', 'Protein Nabati Berbasis Tanaman', 2, 'Protein Nabati, sumber protein berbasis tanaman', 1, NULL, 'Protein nabati sedang menjadi sorotan sebagai alternatif yang lebih sehat dari protein hewani. Dengan berbagai pilihan dari kacang-kacangan hingga biji-bijian, banyak yang mengklaim bahwa pola makan nabati lebih baik untuk tubuh dan lingkungan. Tapi, apakah semua klaim ini benar adanya? Mari kita kupas lebih dalam.\r\n\r\nKonsumsi protein dari tumbuhan dikatakan dapat menurunkan risiko penyakit kronis seperti penyakit jantung dan diabetes tipe 2. Namun, tidak semua jenis protein nabati menyediakan asam amino lengkap yang dibutuhkan tubuh. Untuk mendapatkan profil asam amino yang sempurna, kombinasi berbagai sumber protein nabati diperlukan.\r\n\r\nSalah satu protein nabati yang menonjol adalah quinoa. Quinoa dianggap sebagai salah satu dari sedikit sumber protein nabati lengkap. Selain proteinnya yang kaya, quinoa juga menawarkan serat, magnesium, dan antioksidan yang mendukung kesehatan tubuh secara keseluruhan. Namun, banyak orang tidak menyadari bahwa tidak semua biji-bijian memiliki keunggulan yang sama.\r\n\r\nKacang lentil dan kacang arab, dua sumber protein nabati populer, memiliki kandungan protein tinggi tetapi bukan protein lengkap. Untuk mengatasi kekurangan ini, kacang lentil sering dipadukan dengan biji-bijian seperti beras atau gandum. Sementara itu, kacang arab sering dikombinasikan dengan quinoa atau barley untuk mendapatkan asam amino esensial yang diperlukan.\r\n\r\nBiji chia dan biji rami, meskipun bukan protein lengkap, tetap menawarkan manfaat luar biasa. Biji chia, misalnya, kaya akan asam lemak omega-3 dan serat makanan. Untuk melengkapi profil proteinnya, biji chia bisa dicampur dengan kacang-kacangan atau biji-bijian utuh lainnya dalam diet sehari-hari.\r\n\r\nDi sisi lain, biji rami menyediakan protein lengkap dan mengandung rasio omega-6 dan omega-3 yang optimal untuk kesehatan manusia. Biji ini juga mengandung asam gamma-linolenat, sejenis asam lemak omega-6 yang dikenal dengan sifat antiperadangannya. Namun, biji ini masih kurang dikenal dan digunakan oleh banyak orang.\r\n\r\nKacang kedelai, dalam bentuk edamame atau tahu, adalah salah satu protein nabati lengkap yang sering direkomendasikan. Tidak hanya menyediakan semua asam amino esensial, kacang kedelai juga kaya akan serat, vitamin, dan mineral seperti folat dan vitamin K. Namun, perlu diingat bahwa produk olahan dari kedelai bisa saja kehilangan sebagian manfaat kesehatannya.\r\n\r\nBanyak orang yang beralih ke pola makan nabati mengalami masalah pencernaan pada awalnya, terutama karena peningkatan asupan serat. Ini bisa menjadi tantangan, tetapi dengan perencanaan yang tepat, masalah ini dapat diatasi. Misalnya, menambahkan protein nabati secara bertahap ke dalam diet bisa membantu tubuh menyesuaikan diri.\r\n\r\nMeski begitu, tidak semua protein nabati sama sehatnya. Beberapa produk nabati olahan, seperti nugget ayam berbahan dasar tanaman, bisa saja mengandung lemak jenuh dan bahan tambahan yang tidak baik untuk kesehatan. Penting untuk selalu membaca label dan memilih produk yang minim proses.\r\n\r\nRagi nutrisi adalah pilihan lain yang kaya protein dan diperkaya dengan vitamin B, termasuk B12, yang sering kurang dalam diet vegan. Rasa keju dan kacangnya membuat ragi nutrisi menjadi tambahan yang ideal untuk berbagai hidangan. Namun, produk ini masih jarang digunakan dalam diet sehari-hari.\r\n\r\nProtein nabati seperti kacang hitam dan kacang polong mungkin tidak lengkap, tetapi ketika dikombinasikan dengan biji-bijian lain, mereka dapat menyediakan semua asam amino esensial. Misalnya, kacang hitam bisa dipadukan dengan jagung untuk menciptakan hidangan yang seimbang.\r\n\r\nBiji labu juga menawarkan protein meski bukan protein lengkap. Menggabungkan biji labu dengan sumber protein lain seperti yogurt Yunani bisa menjadi cara yang lezat untuk meningkatkan asupan protein harian. Namun, banyak orang masih belum memanfaatkan biji-bijian ini dengan optimal dalam diet mereka.\r\n\r\nMeskipun protein nabati menawarkan banyak manfaat, tidak semua jenis protein nabati sama sehatnya. Penting untuk memahami bahwa kombinasi yang tepat diperlukan untuk mendapatkan profil nutrisi yang lengkap.', 'Artikel ini membahas kelebihan dan kekurangan protein nabati sebagai alternatif sehat dari protein hewani, serta pentingnya mengombinasikan sumber nabati untuk mendapatkan asam amino lengkap dan nutrisi optimal', '@popsugar.com', 'freepik.com/@freepik', '#ProteinNabati #Kesehatan #PolaMakanSehat #AsamAmino #VeganDiet #GayaHidupSehat #Nutrisi #ProteinTanaman', 'Pending', '2025-01-09 17:41:38'),
(6, 'Dilaporkan ke Bareskrim karena Barak Militer, Dedi Mulyadi: Mungkin Mau Cari Perhatian', '6848b1eeb14f5.jpg', 'Penyuluhan Stunting oleh Mahasiswa KKN Universitas Muhammadiyah Riau', 1, 'viral', 1, NULL, 'URBANBANDUNG - Gubernur Jawa Barat, Dedi Mulyadi, buka suara menanggapi laporan pidana terhadap dirinya yang diajukan oleh seorang wali murid, Adhel Setiawan. Alih-alih meradang, Dedi memilih merespons dengan tenang.\r\n\r\nLewat unggahan di akun Instagram pribadinya, pria yang akrab disapa Kang Dedi Mulyadi (KDM) itu menyebut bahwa kritik dan upaya hukum terhadap dirinya bukan sesuatu yang harus ditanggapi secara emosional.\r\n\r\n“Saya sampaikan ya kepada semuanya, berbagai upaya yang diarahkan pada diri saya baik kritik, saran, bully, nyinyir atau upaya mempidanakan diri saya, enggak usah ditanggapi dengan emosi,” ucap Dedi pada Sabtu 7 Juni 2025.\r\n\r\n“Mungkin mereka lagi mau mencari perhatian,” lanjutnya.', 'Dilaporkan ke Bareskrim karena Barak Militer, Dedi Mulyadi: Mungkin Mau Cari Perhatian', 'urbanbandung', 'Dokumen Pribadi', '#StuntingPrevention #EdukasiGizi #PemberdayaanMasyarakat #KesehatanAnak #GiziSeimbang #DesaSehat #KKN2024 #KKNUMRI #PengabdianMasyarakat', 'Pending', '2025-06-11 02:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `articles_published` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `avatar`, `name`, `email`, `phone`, `articles_published`) VALUES
(1, NULL, 'AuthorSatu', 'author1@urbanmedia.com', '', 0),
(2, NULL, 'Ofy Muhammad', 'ofy88997@urbanmedia.com', '', 0),
(11, NULL, 'Darma Yunita', 'darmayunita@gmail.com', '08387654233', 0);

-- --------------------------------------------------------

--
-- Table structure for table `author_login`
--

CREATE TABLE `author_login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author_login`
--

INSERT INTO `author_login` (`id`, `username`, `password`, `name`, `email`, `phone`) VALUES
(1, 'author1', 'e22591bbe1941fcc4b78972d4c60281f', 'AuthorSatu', 'author1@urbanmedia.com', '08123456781'),
(2, 'OfyMhd', '19deba2d873280845eb662a01ab93cbe', 'Ofy Muhammad', 'ofy88997@urbanmedia.com', '082165786523'),
(11, 'yunita', '$2y$10$C/i1Rhdid7N8rgGazvqJ5OhAUXRoTJY5AX0ueqYG1RkS.fDEvygq.', 'Darma Yunita', 'darmayunita@gmail.com', '08387654233');

--
-- Triggers `author_login`
--
DELIMITER $$
CREATE TRIGGER `after_delete_author_login` AFTER DELETE ON `author_login` FOR EACH ROW BEGIN
  DELETE FROM authors WHERE id = OLD.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_author_login` AFTER INSERT ON `author_login` FOR EACH ROW BEGIN
  INSERT INTO authors (id, name, email, phone)
  VALUES (NEW.id, NEW.name, NEW.email, NEW.phone);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_author_login` AFTER UPDATE ON `author_login` FOR EACH ROW BEGIN
  UPDATE authors
  SET name = NEW.name,
      email = NEW.email,
      phone = NEW.phone
  WHERE id = NEW.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`) VALUES
(1, 'Sains dan Teknologi', NULL),
(2, 'Featured', NULL),
(3, 'Lifestyle', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `editors`
--

CREATE TABLE `editors` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `articles_uploaded` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `editors`
--

INSERT INTO `editors` (`id`, `avatar`, `name`, `email`, `phone`, `articles_uploaded`) VALUES
(2, NULL, 'Maya Miya', 'myankji32765@gmail.com', '0897654321', 0);

-- --------------------------------------------------------

--
-- Table structure for table `editor_login`
--

CREATE TABLE `editor_login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `editor_login`
--

INSERT INTO `editor_login` (`id`, `username`, `password`, `name`, `email`, `phone`) VALUES
(1, 'editor1', '50116a1a3b67657572a00ea8c6680cb9', 'EditorSatu', 'editor1@urbanmedia.com', '08123456780'),
(2, 'mayaaa', '$2y$10$opdGMnOHLqZqvqWiHyUEye.phwsXPPVRYKI0s4fEz8iEeFkallqk.', 'Maya Miya', 'myankji32765@gmail.com', '0897654321');

--
-- Triggers `editor_login`
--
DELIMITER $$
CREATE TRIGGER `after_delete_editor_login` AFTER DELETE ON `editor_login` FOR EACH ROW DELETE FROM editors WHERE id = OLD.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_editor_login` AFTER INSERT ON `editor_login` FOR EACH ROW INSERT INTO editors (id, name, email, phone) 
VALUES (NEW.id, NEW.name, NEW.email, NEW.phone)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_editor_login` AFTER UPDATE ON `editor_login` FOR EACH ROW UPDATE editors SET name = NEW.name, email = NEW.email, phone = NEW.phone
WHERE id = NEW.id
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `editor_id` (`editor_id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `author_login`
--
ALTER TABLE `author_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editors`
--
ALTER TABLE `editors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `editor_login`
--
ALTER TABLE `editor_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `author_login`
--
ALTER TABLE `author_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `editors`
--
ALTER TABLE `editors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `editor_login`
--
ALTER TABLE `editor_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_ibfk_3` FOREIGN KEY (`editor_id`) REFERENCES `editors` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
