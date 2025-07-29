-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 21, 2025 at 01:00 PM
-- Server version: 8.0.30
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
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `username`, `password`, `name`, `email`, `phone`, `role`) VALUES
(2, 'admin', '0192023a7bbd73250516f069df18b500', 'Admin Redaksi', 'admin@urbanmedia.com', '08123456789', 'admin'),
(3, 'admin_redaksi', '21232f297a57a5a743894a0e4a801fc3', 'Admin Redaksi', 'redaksiurbanmedia@gmail.com', '823098765431', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `caption_thumbnail` varchar(255) DEFAULT NULL,
  `summary` text,
  `category_id` int NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `author_id` int NOT NULL,
  `editor_id` int DEFAULT NULL,
  `content` text NOT NULL,
  `source_article` varchar(255) DEFAULT NULL,
  `source_thumbnail` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `status` enum('Published','Rejected','Revised','Pending') DEFAULT 'Pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `editor_comment` text,
  `reviewed_at` datetime DEFAULT NULL,
  `published_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `thumbnail`, `caption_thumbnail`, `summary`, `category_id`, `keywords`, `author_id`, `editor_id`, `content`, `source_article`, `source_thumbnail`, `tags`, `status`, `created_at`, `editor_comment`, `reviewed_at`, `published_at`) VALUES
(1, 'Kebakaran Kapuk Muara: Pramono Anung Janjikan Kemudahan Pengurusan Dokumen yang Terbakar', '6857c6758f73b.jpg', 'Gubernur DKI Jakarta, Pramono Anung', 'Kebakaran Kapuk Muara: Pramono Anung Janjikan Kemudahan Pengurusan Dokumen yang Terbakar', 4, 'Pramono Anung, Kapuk Muara', 1, 1, 'Gubernur DKI Jakarta, Pramono Anung, usai menyambangi korban kebakaran yang terjadi di Kampung Rawa Indah, Kapuk Muara, Penjaringan, Jakarta Utara, Minggu 8 Juni 2025.\r\n\r\nDalam kunjungannya itu, Anung menegaskan pentingnya percepatan pengurusan dokumen yang hilang akibat kebakaran.\r\n\r\n“Bagi korban yang ijazahnya, KTP-nya, atau apa pun yang terbakar, saya minta untuk segera dibuatkan, diselesaikan,” ujar Pramono di hadapan wartawan, Minggu 8 Juni 2025.\r\n\r\n“Mumpung ini masih pada waktu yang dekat, sehingga datanya ada, dengan demikian mudah-mudahan ini akan bisa menolong semua,” sambung dia.\r\n\r\nSelain soal dokumen, Pramono juga memerintahkan seluruh instansi untuk turun langsung membantu warga terdampak secara maksimal.\r\n\r\n“Seluruh dinas yang ada di Balai Kota all out turun tangan. Mulai dari dinas kesehatan, sosial, damkar, Satpol PP, pendidikan, kesehatan, dukcapil,” Pramono menegaskan.\r\n\r\nPerlu diketahui, kebakaran telah terjadi di kawasan itu pada Jumat 6 Juni 2025, tepatnya mulai pukul 12.18 WIB, dan berhasil dipadamkan sekitar pukul 21.00 WIB.', 'urbanbandung', 'instagram/pramonoanungw', '#PramonoAnung #dokumen #KebakaranKapukMuara', 'Published', '2025-06-09 22:21:35', 'Masih terindikasi plagiat beberapa persen. Mohon perbaiki lagi segera', '2025-06-30 14:31:28', '2025-06-30 14:31:28'),
(4, 'Pesona Kontroversial Bibir Pelacur, Bunga yang Memikat dan Terancam Punah di Hutan Tropis. Dapat Meningkatkan Rangsangan Seksual Hingga Mengobati Ketidaksuburan', '685d31a97fbfb.jpg', 'Tanaman Palicourea elata atau nama sebelumnya Psychotria elata yang dikenal dengan sebutan “Bunga Bibir Merah atau Bibir Pelacur” kini terancam punah', 'Artikel ini mengulas tentang Psychotria elata, tanaman eksotis yang dikenal dengan sebutan \"bibir pelacur\" karena bentuk dan warnanya yang menyerupai bibir merah menyala. Tanaman ini tumbuh di hutan hujan tropis Amerika Tengah dan Selatan. Artikel ini membahas keunikan morfologi, habitat, manfaat medis, dan ancaman kepunahan yang dihadapi tanaman ini akibat deforestasi.', 3, 'Bunga Bibir Merah Psychotria elata', 33, 1, 'URBANBANDUNG – Keanekaragaman hayati di Bumi menghadirkan berbagai spesies unik yang terus ditemukan oleh para ilmuwan. Salah satunya adalah Psychotria elata, yang lebih dikenal dengan sebutan \"bibir pelacur\" atau \"hooker lips.\" Tanaman ini memiliki bentuk yang sangat unik dan menarik perhatian, menjadikannya topik yang menarik untuk dibahas.\r\n\r\nPsychotria elata adalah tanaman berbunga yang tumbuh di hutan hujan tropis Amerika Tengah dan Selatan, termasuk negara-negara seperti Kolombia, Kosta Rika, Panama, dan Ekuador.\r\n\r\nTanaman ini memiliki ciri khas yang menonjol berupa bagian brachteola atau daun pelindung bunga yang menyerupai bibir merah menyala. Warna dan bentuknya yang mencolok dirancang untuk menarik serangga dan burung kolibri agar membantu penyerbukan.\r\n\r\nTanaman ini tumbuh di habitat yang kaya akan nutrisi dengan kondisi tanah yang lembap dan penuh serasah daun. Psikhotria elata tumbuh sebagai semak atau pohon kecil dengan daun hijau matte yang berurat tebal. \r\n\r\nBagian brachteola yang merah menyala akan membuka untuk memperlihatkan bunga kecil berwarna putih krem yang berbentuk seperti bintang, yang nantinya akan berubah menjadi buah beri berwarna hitam kebiruan.\r\n\r\nPsychotria elata berasal dari famili Rubiaceae, yang terdiri dari lebih dari 13.150 spesies herba, semak, dan pohon yang tersebar di daerah tropis. Tanaman ini juga berkerabat dengan spesies lain seperti Uncaria gambir (Gambir serawak) dan Mitragyna speciosa (Kratom).\r\n\r\nTanaman ini tidak hanya menarik secara visual tetapi juga memiliki berbagai manfaat medis. Psychotria elata mengandung senyawa dimethyltryptamine, yang diketahui memiliki sifat psikedelik. \r\n\r\nSelain itu, tanaman ini telah lama digunakan dalam pengobatan tradisional oleh masyarakat Amazon untuk mengobati berbagai penyakit seperti radang sendi, infertilitas (ketidaksuburan), dan impotensi. Tanaman ini juga diketahui memiliki sifat antimikroba dan anti-inflamasi.\r\n\r\nSayangnya, keindahan dan keunikan Psychotria elata tidak menjamin kelangsungan hidupnya. Deforestasi yang marak di daerah asalnya telah menyebabkan penurunan populasi yang signifikan. \r\n\r\nMeskipun IUCN mengkategorikan tanaman ini dalam status konservasi \'least concern\', tetap ada ancaman nyata terhadap kelangsungan hidupnya.\r\n\r\nDi Amerika Tengah, Psychotria elata sering dijadikan hadiah pada hari Valentine, mengingat bentuknya yang menyerupai bibir yang seksi. Ini menunjukkan bagaimana tanaman ini telah diadopsi dalam budaya setempat, menambah daya tariknya di luar fungsi ekologisnya.\r\n\r\nPsychotria elata tidak mengeluarkan aroma, tetapi mengandalkan penampilan visualnya untuk menarik penyerbuk seperti kupu-kupu, burung kolibri, dan penyengat. \r\n\r\nAdaptasi ini menunjukkan bagaimana tanaman dapat berevolusi untuk menarik penyerbuk melalui berbagai cara yang kreatif.\r\n\r\nDi balik keindahannya, Psychotria elata menyimpan ancaman yang mengintai. Deforestasi yang terjadi di hutan hujan tropis telah menyebabkan habitat asli tanaman ini semakin berkurang. Oleh karena itu, upaya konservasi sangat diperlukan untuk melindungi tanaman ini dari kepunahan.\r\n\r\nSelain itu, tanaman ini juga memiliki beberapa nama sinonim seperti Palicourea elata dan Cephaelis elata. Ini menunjukkan bagaimana satu spesies dapat dikenal dengan berbagai nama di berbagai daerah, menambah kompleksitas dalam penelitian dan konservasi.\r\n\r\nTanaman ini juga memiliki potensi besar dalam penelitian ilmiah dan medis, mengingat kandungan senyawa kimia yang dimilikinya. Dengan lebih banyak penelitian, mungkin kita bisa menemukan lebih banyak manfaat dari tanaman unik ini.\r\n\r\nPsychotria elata adalah contoh sempurna bagaimana alam dapat menciptakan keindahan yang luar biasa sekaligus menghadirkan tantangan dalam pelestariannya. \r\n\r\nTanaman ini mengingatkan kita akan pentingnya menjaga keanekaragaman hayati dan melindungi spesies yang terancam punah.\r\n\r\nSecara keseluruhan, Psychotria elata tidak hanya menarik secara estetika tetapi juga memiliki nilai ekologis dan medis yang signifikan. \r\n\r\nUpaya konservasi dan penelitian lebih lanjut sangat diperlukan untuk memastikan tanaman ini tetap eksis dan dapat dimanfaatkan secara berkelanjutan.\r\n\r\nDengan demikian, Psychotria elata bukan hanya \"bibir pelacur\" yang menarik perhatian, tetapi juga simbol dari keindahan dan kerentanan yang ada di hutan hujan tropis kita. Mari kita jaga dan lestarikan tanaman unik ini untuk generasi mendatang.', 'Berbagai Sumber', 'Instagram/@fastpapermag', '#PsychotriaElata #PalicoureaElata #BungaBibirPelacur #BungaBibirMerah #TanamanEksotis #HookerLips #BungaTropis #TanamanUnik #TanamanLangka #PengobatanTradisionalAmazon -#ManfaatMedisTanaman', 'Published', '2025-06-26 18:40:25', NULL, '2025-06-30 14:30:50', '2025-06-30 14:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `articles_published` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `avatar`, `name`, `email`, `phone`, `articles_published`) VALUES
(1, NULL, 'Author 1', 'author1@urbanmedia.com', '08123456781', 2),
(33, NULL, 'Darma Yunita', 'darmayunita@gmail.com', '083846072912', 2);

-- --------------------------------------------------------

--
-- Table structure for table `author_login`
--

CREATE TABLE `author_login` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `author_login`
--

INSERT INTO `author_login` (`id`, `username`, `password`, `name`, `email`, `phone`) VALUES
(1, 'author1', 'e22591bbe1941fcc4b78972d4c60281f', 'Author 1', 'author1@urbanmedia.com', '08123456781'),
(33, 'yunita', 'b7dfe9096cebb53152aa5ce78a1a61c9', 'Darma Yunita', 'darmayunita@gmail.com', '083846072912');

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
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`) VALUES
(1, 'Sains dan Teknologi', 'cat_6852e26542bed.png'),
(3, 'Featured', NULL),
(4, 'News', 'cat_6852daf4e3f5c.png');

-- --------------------------------------------------------

--
-- Table structure for table `editors`
--

CREATE TABLE `editors` (
  `id` int NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `articles_uploaded` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `editors`
--

INSERT INTO `editors` (`id`, `avatar`, `name`, `email`, `phone`, `articles_uploaded`) VALUES
(1, NULL, 'Editor 1', 'editor1@urbanmedia.com', '08123456780', 4),
(5, NULL, 'Keysa Tzyun', 'abcdhyuio23@gmail.com', '08956734256', 0);

-- --------------------------------------------------------

--
-- Table structure for table `editor_login`
--

CREATE TABLE `editor_login` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `editor_login`
--

INSERT INTO `editor_login` (`id`, `username`, `password`, `name`, `email`, `phone`) VALUES
(1, 'editor1', '50116a1a3b67657572a00ea8c6680cb9', 'Editor 1', 'editor1@urbanmedia.com', '08123456780'),
(5, 'keysah', '3503d99610f81cf8b57a0c24e8cc3dca', 'Keysa Tzyun', 'abcdhyuio23@gmail.com', '08956734256');

--
-- Triggers `editor_login`
--
DELIMITER $$
CREATE TRIGGER `after_delete_editor_login` AFTER DELETE ON `editor_login` FOR EACH ROW BEGIN
    DELETE FROM editors
    WHERE email = OLD.email;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_editor_login` AFTER INSERT ON `editor_login` FOR EACH ROW BEGIN
    INSERT INTO editors (name, email, phone, avatar, articles_uploaded)
    VALUES (NEW.name, NEW.email, NEW.phone, NULL, 0);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_editor_login` AFTER UPDATE ON `editor_login` FOR EACH ROW BEGIN
    UPDATE editors
    SET name = NEW.name,
        email = NEW.email,
        phone = NEW.phone
    WHERE email = OLD.email;
END
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
  ADD KEY `editor_id` (`editor_id`),
  ADD KEY `articles_ibfk_2` (`author_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `author_login`
--
ALTER TABLE `author_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `editors`
--
ALTER TABLE `editors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `editor_login`
--
ALTER TABLE `editor_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author_login` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_ibfk_3` FOREIGN KEY (`editor_id`) REFERENCES `editors` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
