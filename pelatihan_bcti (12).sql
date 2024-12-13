-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Okt 2024 pada 07.40
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pelatihan_bcti`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_agenda`
--

CREATE TABLE `tbl_agenda` (
  `id_agenda` int(11) NOT NULL,
  `tgl_agenda` date NOT NULL,
  `nama_agenda` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tujuan_tempat` varchar(255) NOT NULL,
  `status_agenda` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_agenda`
--

INSERT INTO `tbl_agenda` (`id_agenda`, `tgl_agenda`, `nama_agenda`, `deskripsi`, `tujuan_tempat`, `status_agenda`) VALUES
(1, '2024-08-01', 'Rapat Awal Bulan Tim BCTI', 'Rapat koordinasi untuk membahas progress proyek dan penjadwalan ulang kegiatan bulan Agustus', 'Kantor', 'done'),
(2, '2024-08-12', 'Brainstorming Tim BCTI', 'Brainstorming untuk persiapan bootcamp selanjutnya ataupun pelatihan selanjutnya', 'Kantor', 'postponed'),
(3, '2024-08-17', 'Outing Tim BCTI', 'Outing dan healing tim BCTI', 'Pantai Batakan', 'on going'),
(4, '2024-08-06', 'Visiting ke beberapa fakultas di UNISKA', 'Menawarkan kerjasama untuk BCTI GOES TO CAMPUS', 'UNISKA Adyaksa', 'done'),
(5, '2024-08-14', 'Mengantar proposal ke FISIP ULM', 'Pengiriman proposal BCTI GOES TO CAMPUS ke FISIP ULM', 'FISIP ULM', 'done'),
(6, '2024-08-21', 'Preparing Event', 'Persiapan Woman Sheroes', 'DEKORAMA', 'on going'),
(7, '2024-08-08', 'Meeting persiapan event', 'Meeting & brainstorming ide untuk persiapan Squidcamp', 'Kantor', 'done'),
(8, '2024-08-19', 'Visit Vendor & Sponsorship Woman Sheroes', 'Visiting dengan tim dibagi menjadi beberapa orang', 'Vendor & Sposnsor Woman Sheroes', 'on going'),
(9, '2024-08-27', 'Meeting persiapan 3 event', 'Persiapan Personal Branding, Public Speaking, MC On Stage Vol 2', 'Kantor', 'on going'),
(10, '2024-08-23', 'Rapat YHC', 'Rapat bulanan dengan YHC', 'Auditorium NHB', 'on going');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_evaluasi_pelatihan`
--

CREATE TABLE `tbl_evaluasi_pelatihan` (
  `id_evaluasi_pelatihan` int(11) NOT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `id_pelatihan` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `tgl_input_evaluasi_pelatihan` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating_materi` text NOT NULL,
  `rating_fasilitas` text NOT NULL,
  `rating_bcti` text NOT NULL,
  `feedback` text NOT NULL,
  `rekomendasi` varchar(255) NOT NULL,
  `testimoni` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_evaluasi_pelatihan`
--

INSERT INTO `tbl_evaluasi_pelatihan` (`id_evaluasi_pelatihan`, `id_kehadiran`, `id_pelatihan`, `id_peserta`, `tgl_input_evaluasi_pelatihan`, `rating_materi`, `rating_fasilitas`, `rating_bcti`, `feedback`, `rekomendasi`, `testimoni`) VALUES
(1, 1, 7, 1, '2024-08-13 02:44:52', '95, Materinya sangat mendalam dan relevan, disertai dengan contoh-contoh praktis yang mudah dipahami. Beberapa poin bisa ditambahkan untuk lebih detail.', '90, Fasilitas cukup lengkap dan mendukung kenyamanan selama pelatihan, namun AC kadang terasa kurang dingin saat sesi panjang.', '98, BCTI sangat profesional dalam mengorganisir pelatihan, dan tim sangat responsif terhadap kebutuhan peserta. Kualitas pelatihan sangat baik.', '\r\nSaya sangat puas dengan pelatihan ini, baik dari segi materi maupun penyelenggaraan. Mungkin bisa dipertimbangkan untuk menambah sesi Q&A yang lebih panjang agar peserta bisa lebih interaktif.', 'Saya merekomendasikan pelatihan seputar manajemen waktu dan produktivitas, serta sesi lanjutan dari Youth Leader Gathering yang lebih fokus pada strategi kepemimpinan.', 'Mengikuti pelatihan BCTI memberikan saya banyak wawasan baru tentang kepemimpinan. Materi yang disampaikan sangat aplikatif, dan fasilitatornya luar biasa dalam menjelaskan setiap topik. Saya merasa lebih siap menjadi pemimpin muda setelah mengikuti program ini. BCTI benar-benar tempat yang tepat untuk mengembangkan diri.'),
(2, 2, 1, 1, '2024-08-13 03:19:09', '93, Materinya sangat bermanfaat, terutama tips dan trik menjadi MC yang handal. Namun, mungkin perlu ditambahkan lebih banyak contoh situasi nyata untuk variasi acara yang berbeda.', '88, Fasilitas cukup memadai, meski ruangan terasa sedikit sempit saat sesi praktik. Namun, alat-alat pendukung seperti mikrofon dan sound system bekerja dengan baik.', '96, BCTI kembali menunjukkan kualitasnya dengan penyelenggaraan yang rapi dan terstruktur. Tim pendukung juga sangat ramah dan responsif terhadap kebutuhan peserta.', 'Pelatihan ini sangat menginspirasi dan memberikan banyak insight baru. Saya berharap di sesi berikutnya ada lebih banyak praktik langsung dengan feedback dari trainer, karena ini sangat membantu dalam meningkatkan kemampuan.', 'Saya merekomendasikan pelatihan tentang public speaking tingkat lanjut atau pelatihan khusus untuk MC dalam acara-acara formal seperti konferensi atau pernikahan.', 'Pelatihan MC On Stage dari BCTI sangat membuka wawasan saya tentang dunia MC. Dengan materi yang mendalam dan kesempatan praktik langsung, saya merasa lebih percaya diri untuk tampil di panggung. Pengalaman ini sangat berharga bagi saya, dan saya tidak sabar untuk mengikuti pelatihan BCTI berikutnya!'),
(3, 3, 8, 1, '2024-08-13 03:32:41', '98, Materi pelatihan sangat lengkap dan mendalam, mencakup berbagai teknik public speaking yang relevan dan terbaru. Penjelasan tentang cara menghadapi audiens dan mengelola kecemasan sangat bermanfaat.', '90, Fasilitas pelatihan cukup memadai, dengan ruang yang nyaman dan peralatan yang berfungsi dengan baik. Namun, pencahayaan di ruang latihan agak kurang optimal saat sesi presentasi.', '95, BCTI melakukan pekerjaan luar biasa dalam mengatur pelatihan ini. Penjadwalan yang tepat dan dukungan dari tim sangat memadai, membuat pengalaman pelatihan menjadi sangat profesional.', 'Pelatihan ini sangat bermanfaat bagi saya dalam meningkatkan keterampilan public speaking. Materi yang diberikan sangat aplikatif, dan kesempatan untuk berlatih langsung sangat membantu. Saya menyarankan agar sesi praktik ditingkatkan dengan memberikan lebih banyak kesempatan bagi peserta untuk berbicara di depan kelompok yang lebih besar.', 'Saya merekomendasikan pelatihan lanjutan tentang teknik presentasi tingkat lanjut atau pelatihan khusus untuk menghadapi berbagai jenis audiens dan situasi berbicara yang lebih kompleks.', 'Mengikuti pelatihan Public Speaking For Collage Vol 2 dari BCTI adalah pengalaman yang sangat berharga. Saya merasa lebih percaya diri dan siap untuk berbicara di depan umum berkat materi dan latihan yang diberikan. Trainer sangat kompeten dan suasana pelatihan sangat mendukung. Ini adalah investasi yang sangat baik untuk pengembangan keterampilan berbicara saya.'),
(4, 4, 4, 1, '2024-08-13 03:44:34', '94, Materinya sangat komprehensif dan relevan, memberikan panduan jelas tentang cara membangun personal brand yang kuat.', '90, Fasilitas cukup memadai, dengan suasana yang nyaman untuk belajar. Namun, sedikit peningkatan dalam kualitas sound system akan lebih baik.', '93, BCTI kembali memberikan pelatihan yang berkualitas dengan pengaturan yang baik dan dukungan yang solid dari tim.', 'Pelatihan ini sangat bermanfaat dan memberi wawasan baru tentang pentingnya personal branding. Akan lebih baik jika disediakan lebih banyak studi kasus dan contoh nyata untuk mendukung teori yang diajarkan.', 'Saya merekomendasikan pelatihan tentang digital marketing atau social media strategy sebagai lanjutan dari materi personal branding ini.', 'Pelatihan Personal Branding dari BCTI sangat membuka mata saya tentang betapa pentingnya memiliki citra diri yang kuat dan konsisten. Pengalaman ini membantu saya untuk lebih percaya diri dalam memproyeksikan diri saya di berbagai platform.'),
(5, 5, 3, 1, '2024-08-13 03:47:26', '97, Materinya sangat relevan dan inspiratif, memberikan panduan yang jelas tentang peran wanita sebagai pemimpin.', '92, Fasilitas sangat memadai, dengan ruang pelatihan yang nyaman dan dukungan teknologi yang baik.', '95, BCTI menyelenggarakan pelatihan ini dengan sangat profesional, mulai dari persiapan hingga pelaksanaan.', 'Pelatihan ini memberikan banyak wawasan baru dan menginspirasi saya untuk menjadi pemimpin yang lebih baik. Sedikit tambahan waktu untuk diskusi kelompok akan sangat bermanfaat.', 'Saya merekomendasikan pelatihan lanjutan tentang leadership untuk wanita atau workshop tentang public speaking khusus untuk wanita.', 'Mengikuti pelatihan Woman Sheroes adalah pengalaman yang sangat memperkaya. Saya mendapatkan banyak wawasan baru tentang kepemimpinan dan peran wanita di dunia profesional. Ini adalah pelatihan yang sangat berharga untuk semua wanita yang ingin menjadi pemimpin.'),
(6, 31, 5, 1, '2024-08-13 04:11:57', '100, Materinya sangat daging, semua informasi yang diberikan sangat relevan dan langsung dapat diterapkan di dunia nyata.', '93, Fasilitas sudah cukup baik, tetapi mungkin bisa ditingkatkan pada sisi akustik ruangan agar lebih mendukung pelatihan public speaking.', '95, BCTI sangat profesional dalam menyelenggarakan pelatihan ini, dari awal hingga akhir semuanya terorganisir dengan baik.', 'Pelatihan ini sangat berharga, memberikan banyak wawasan dan latihan praktis yang membantu meningkatkan kepercayaan diri saya sebagai MC. Sedikit tambahan pada sesi simulasi akan sangat membantu.', 'Rekomendasi pelatihan untuk BCTI selanjutnya adalah pelatihan Advanced Public Speaking atau Event Hosting for Professionals.', 'Mengikuti MC On Stage Vol.2 adalah pengalaman yang sangat berkesan. Saya merasa lebih siap dan percaya diri untuk tampil sebagai MC di berbagai acara. BCTI benar-benar memberikan yang terbaik!'),
(7, 67, 2, 1, '2024-08-13 04:18:29', '95, Materinya sangat bermanfaat dan relevan dengan kebutuhan public speaking, tetapi ada beberapa bagian yang bisa diperjelas lagi.', '85, Fasilitas cukup mendukung, namun akan lebih baik jika ruang pelatihan dilengkapi dengan lebih banyak alat bantu visual.', '90, BCTI telah menyelenggarakan pelatihan dengan baik, meskipun ada beberapa aspek teknis yang bisa ditingkatkan.', 'Pelatihan ini sangat memperluas wawasan saya tentang public speaking. Untuk ke depannya, mungkin bisa ditambahkan sesi tanya jawab yang lebih panjang agar peserta bisa lebih mendalami materi.', 'Saya merekomendasikan pelatihan Storytelling for Public Speaking agar peserta bisa lebih mahir dalam menyampaikan cerita yang kuat saat berbicara.', 'Pelatihan ini sangat membuka wawasan saya mengenai pentingnya komunikasi yang efektif. Dengan bimbingan trainer yang ahli, saya merasa lebih percaya diri dalam berbicara di depan publik.'),
(9, 6, 10, 2, '2024-08-13 05:06:58', '88, Materi relevan dan bermanfaat, tetapi beberapa bagian terasa kurang mendalam.', '82, Fasilitas cukup baik, namun ada beberapa kekurangan seperti kurangnya perangkat audio yang memadai.', '84, BCTI secara umum baik, namun ada beberapa aspek seperti komunikasi jadwal yang perlu diperbaiki.', 'Pelatihan memberikan wawasan berharga tentang public speaking. Akan lebih baik jika ada penjelasan lebih detail tentang teknik-teknik tertentu dan peningkatan dalam penyampaian materi.', 'Speech Crafting atau Presentation Skills Enhancement untuk melanjutkan perkembangan kemampuan berbicara di depan umum.', 'Pelatihan ini membantu saya untuk lebih percaya diri dalam berbicara di depan umum. Meskipun ada beberapa aspek yang bisa diperbaiki, saya merasa pengalaman ini sangat berharga.'),
(10, 7, 9, 2, '2024-08-13 05:18:01', '85, Materi relevan dan bermanfaat untuk membuat CV, namun beberapa topik penting seperti personal branding tidak dibahas mendalam.', '78, Fasilitas perlu perbaikan; terutama ruang yang terlalu sempit dan alat presentasi yang kurang memadai.', '80, BCTI sudah cukup baik, tetapi perlu peningkatan dalam koordinasi dan penyediaan informasi terkait pelatihan.', 'Pelatihan CV Breakdown memberikan informasi dasar yang baik. Namun, penambahan contoh nyata dan praktik langsung akan sangat membantu peserta dalam memahami materi dengan lebih baik.', 'Advanced CV Writing atau Personal Branding and Career Development untuk melengkapi keterampilan yang telah diperoleh.', 'Pelatihan ini berguna untuk memperbaiki CV saya, meskipun beberapa aspek seperti personal branding tidak dijelaskan secara mendalam. Pengalaman keseluruhan cukup positif dan saya mendapatkan banyak wawasan baru tentang cara menonjolkan diri dalam CV.'),
(11, 8, 6, 2, '2024-08-13 05:32:02', '88, Materi sangat informatif dan praktis, tetapi bisa lebih mendalam dalam beberapa topik spesifik.', '82, Fasilitas memadai namun beberapa peralatan perlu diperbarui untuk meningkatkan kenyamanan.', '85, BCTI memberikan pelatihan dengan baik, tetapi ada ruang untuk peningkatan dalam hal koordinasi dan penyampaian materi.', 'Pelatihan ini sangat membantu untuk pemahaman dasar. Perbaikan pada fasilitas dan penyediaan materi tambahan akan lebih meningkatkan kualitas pelatihan.', 'Advanced Techniques in Squid Operations untuk memperdalam keterampilan yang sudah diajarkan.', 'Squid Camp memberikan dasar yang kuat dan wawasan praktis yang berguna. Meskipun ada beberapa area yang bisa diperbaiki, pengalaman pelatihan secara keseluruhan sangat positif.'),
(12, 9, 5, 2, '2024-08-13 05:41:53', '92, Materi sangat relevan dan bermanfaat, tetapi beberapa topik bisa lebih mendalam.', '87, Fasilitas memadai, namun penambahan perlengkapan audio visual bisa meningkatkan pengalaman.', '90, BCTI memberikan pelayanan yang baik dan menyelenggarakan pelatihan dengan profesional.', 'Pelatihan sangat berguna dengan materi yang praktis. Fasilitas yang ada sudah baik, namun ada ruang untuk perbaikan dalam aspek teknis.', 'Kelas lanjutan mengenai teknik public speaking dan penggunaan teknologi dalam MC.', 'Pelatihan ini memperluas wawasan saya tentang teknik MC. Materi yang diberikan sangat aplikatif dan mendukung pengembangan keterampilan saya dalam dunia presentasi.'),
(13, 11, 7, 3, '2024-08-13 05:54:54', '88, Materi relevan dan bermanfaat, tapi ada beberapa bagian yang bisa lebih mendalam.', '85, Fasilitas cukup baik, namun ada beberapa aspek yang bisa ditingkatkan seperti ruang diskusi.', '90, BCTI memberikan pengalaman yang baik dengan pengorganisasian yang efektif.', 'Pelatihan ini sangat berguna untuk pengembangan kepemimpinan. Penjelasan materi jelas dan aplikatif, tetapi ada beberapa sesi yang terasa kurang mendalam.', 'Saran untuk pelatihan selanjutnya: tambahkan lebih banyak studi kasus atau simulasi untuk pengalaman lebih praktis.', 'Saya mendapatkan wawasan baru tentang kepemimpinan dan strategi yang bisa diterapkan langsung. Sesi diskusi sangat membantu untuk berbagi pengalaman dengan peserta lain.'),
(14, 12, 3, 3, '2024-08-13 05:59:41', '92, Materi sangat relevan dan bermanfaat. Namun, beberapa bagian bisa lebih mendalam.', '80, Fasilitas cukup memadai, tetapi ada beberapa area yang bisa diperbaiki untuk kenyamanan peserta.', '85, Pelayanan BCTI baik, tapi ada beberapa aspek logistik yang perlu diperbaiki untuk pengalaman peserta yang lebih baik.', 'Pelatihan \"Woman Sheroes\" sangat inspiratif dan memberikan wawasan berharga. Fasilitas pelatihan perlu peningkatan untuk mendukung kenyamanan peserta.', 'Pertimbangkan untuk menambah sesi lanjutan tentang kepemimpinan wanita atau networking.', 'Pelatihan ini memberi banyak inspirasi dan motivasi. Materinya sangat aplikatif untuk pengembangan pribadi dan profesional.'),
(15, 13, 8, 3, '2024-08-13 06:40:29', '92, Materi disajikan secara komprehensif dan relevan dengan kebutuhan peserta. Beberapa bagian bisa lebih mendalam.', '80, Fasilitas yang disediakan baik namun beberapa perlengkapan perlu diperbarui untuk kenyamanan peserta.', '85, BCTI menyelenggarakan pelatihan dengan baik, namun koordinasi antara panitia dan peserta bisa lebih ditingkatkan.', 'Pelatihan ini sangat bermanfaat dengan materi yang aplikatif dan relevan. Perlu peningkatan dalam hal fasilitas dan komunikasi.', 'Mungkin dapat mempertimbangkan pelatihan tambahan dalam public speaking untuk tingkat lanjutan atau workshop praktik langsung.', 'Pelatihan ini memberikan wawasan baru dan teknik yang berguna untuk meningkatkan keterampilan berbicara di depan umum. Saya merasa lebih percaya diri setelah mengikuti pelatihan ini.'),
(16, 14, 2, 3, '2024-08-13 06:53:42', '92, Materi yang disampaikan sangat relevan dan aplikatif, membantu meningkatkan keterampilan berbicara di depan umum.', '88, Fasilitas yang disediakan cukup memadai, namun perlu sedikit peningkatan dalam aspek kenyamanan.', '90, BCTI mengelola pelatihan dengan baik, memberikan pengalaman belajar yang berkualitas.', 'Pelatihan ini sangat bermanfaat, namun bisa lebih baik jika durasi lebih panjang untuk pendalaman materi.', 'Pelatihan mengenai pengembangan personal branding akan sangat membantu untuk karir.', 'Mengikuti pelatihan di BCTI memberikan pengalaman belajar yang berharga dan membuka wawasan baru tentang public speaking.'),
(17, 33, 5, 3, '2024-08-13 06:59:48', '92, Materinya cukup lengkap dan mudah diikuti, memberikan banyak tips praktis.', '85, Fasilitas sudah memadai namun masih ada ruang untuk peningkatan, seperti kenyamanan ruang pelatihan.', '90, BCTI menyelenggarakan pelatihan ini dengan sangat baik dan profesional.', 'Pelatihan ini sangat membantu dalam meningkatkan kemampuan MC, namun durasinya bisa diperpanjang sedikit.', 'ublic Speaking Advanced, MC untuk Event Besar.', 'Saya merasa lebih percaya diri menjadi MC setelah mengikuti pelatihan ini. Terima kasih BCTI!'),
(19, 16, 1, 4, '2024-08-13 07:10:57', '88, Materi yang diberikan cukup bermanfaat, namun beberapa topik bisa lebih diperdalam untuk pemahaman yang lebih baik.', '82, Fasilitas cukup mendukung, namun perlu beberapa peningkatan, terutama dalam hal kenyamanan ruangan.', '89, BCTI menyelenggarakan pelatihan ini dengan baik, meskipun ada beberapa area yang bisa lebih ditingkatkan, seperti waktu sesi yang lebih panjang.', 'Secara keseluruhan, pelatihan ini cukup baik, namun akan lebih efektif jika durasi diperpanjang untuk memberikan lebih banyak waktu latihan praktik.', 'Pelatihan MC untuk Acara Resmi, Pelatihan Teknik Vocal dan Diksi.', 'Pelatihan ini memberikan banyak wawasan baru yang berguna bagi saya sebagai seorang MC. Sangat direkomendasikan untuk mereka yang ingin mengasah kemampuan public speaking.'),
(20, 17, 6, 4, '2024-08-13 07:14:45', '85, Materi yang disampaikan cukup baik, namun ada beberapa topik yang bisa lebih dikembangkan dan diperjelas.', '80, Fasilitas yang disediakan cukup memadai, tetapi perlu ada peningkatan dalam hal kenyamanan dan aksesibilitas.', '88, BCTI sudah melakukan pekerjaan yang baik dalam menyelenggarakan pelatihan ini, meskipun masih ada beberapa area yang bisa ditingkatkan, seperti manajemen waktu dan koordinasi.', 'Pelatihan ini cukup memberikan banyak wawasan baru, tetapi akan lebih baik jika ada lebih banyak sesi praktis dan studi kasus untuk memperdalam pemahaman materi.', 'Pengembangan Diri untuk Pemimpin Muda, Bootcamp Teknologi Terbaru.', 'Squid Camp memberikan pengalaman yang berharga, membantu saya untuk lebih memahami topik yang diajarkan. BCTI menyelenggarakan pelatihan ini dengan baik, namun saya berharap ada lebih banyak kesempatan untuk praktek langsung.'),
(21, 32, 5, 4, '2024-08-13 07:18:49', '93, Materi yang disampaikan sangat relevan dan membantu, namun beberapa bagian bisa lebih detail untuk pemahaman yang lebih mendalam.', '86, Fasilitas yang disediakan cukup baik, tetapi ruang pelatihan bisa lebih nyaman dan dilengkapi dengan peralatan yang lebih memadai.', '91, BCTI menyelenggarakan pelatihan ini dengan sangat baik, namun ada beberapa area seperti manajemen waktu yang bisa lebih ditingkatkan.', 'Pelatihan ini sangat bermanfaat, terutama dalam meningkatkan keterampilan public speaking dan MC. BCTI perlu mempertimbangkan lebih banyak waktu untuk sesi praktek agar peserta bisa lebih terlatih.\r\n\r\n', 'Pelatihan MC untuk Event Formal, Advanced Public Speaking.', 'Pelatihan ini memberikan banyak wawasan baru yang sangat membantu dalam karier saya sebagai MC. Fasilitatornya kompeten dan materinya sangat aplikatif.'),
(22, 18, 7, 5, '2024-08-13 07:25:19', '90, Materinya sangat bermanfaat, meskipun ada beberapa bagian yang bisa lebih diperdalam.', '85, Fasilitas cukup baik, namun ruang pelatihan bisa lebih nyaman.', '88, BCTI menyelenggarakan pelatihan ini dengan baik, namun masih ada ruang untuk peningkatan dalam manajemen waktu.', 'Pelatihan ini sangat inspiratif, tetapi lebih banyak sesi interaktif akan membuatnya lebih efektif.', 'Pelatihan Kepemimpinan Tingkat Lanjut, Public Speaking untuk Pemimpin.', 'Pelatihan ini membantu saya memahami peran dan tanggung jawab sebagai pemimpin muda. Sangat bermanfaat dan membuka wawasan.'),
(23, 20, 8, 5, '2024-08-13 07:32:13', '92, Materi sangat komprehensif dan aplikatif, cocok untuk meningkatkan keterampilan public speaking.', '80, Fasilitas memadai, tetapi ada beberapa kekurangan dalam hal kenyamanan tempat duduk dan peralatan.', ' 87, BCTI menyelenggarakan pelatihan ini dengan baik, namun manajemen waktu bisa ditingkatkan.', 'Pelatihan ini sangat berguna dan memperkaya keterampilan public speaking. Akan lebih baik jika sesi praktek lebih diperbanyak dan fasilitas ditingkatkan.', 'Advanced Public Speaking, Teknik Presentasi untuk Pimpinan.', 'Pelatihan ini memberikan banyak wawasan baru dan teknik yang sangat membantu dalam public speaking. Saya merasa lebih percaya diri setelah mengikuti pelatihan ini.'),
(24, 21, 2, 5, '2024-08-13 07:37:23', '88, Materi yang diberikan sangat relevan dan bermanfaat, namun beberapa aspek bisa lebih diperluas.', '82, Fasilitas memadai tetapi ada beberapa kekurangan dalam hal kenyamanan dan peralatan.', '85, BCTI menyelenggarakan pelatihan dengan baik, namun ada beberapa aspek manajerial yang bisa ditingkatkan.', 'Pelatihan ini memberikan banyak informasi berguna, namun perlu ada peningkatan dalam hal fasilitas dan pengaturan waktu.', 'Teknik Presentasi Lanjutan, Pelatihan Komunikasi Efektif untuk Profesional.', 'Pelatihan ini sangat membantu dalam meningkatkan kemampuan berbicara di depan umum. Saya merasa lebih percaya diri dan siap menghadapi berbagai situasi presentasi.'),
(25, 34, 5, 5, '2024-08-13 07:40:13', '89, Materi yang diberikan sangat bermanfaat dan aplikatif, namun beberapa bagian bisa lebih mendalam untuk pemahaman yang lebih baik.', '83, Fasilitas cukup memadai tetapi ada beberapa kekurangan dalam hal kenyamanan dan peralatan teknis.', '88, BCTI mengelola pelatihan ini dengan baik, meski ada beberapa area seperti pengaturan waktu yang bisa diperbaiki.', ' Pelatihan ini sangat berguna untuk mengasah keterampilan MC, tetapi akan lebih baik dengan lebih banyak sesi praktek langsung dan peningkatan fasilitas.', 'Teknik MC untuk Event Besar, Advanced Public Speaking.', 'Pelatihan ini memberikan banyak wawasan dan keterampilan baru dalam menjadi MC. Materi dan teknik yang diajarkan sangat membantu dan relevan.'),
(26, 22, 1, 6, '2024-08-13 07:43:28', '87, Materi yang disampaikan relevan dan bermanfaat, tetapi ada beberapa topik yang bisa lebih diperjelas.', '78, Fasilitas yang disediakan cukup memadai, tetapi ada beberapa kekurangan dalam hal kenyamanan dan perlengkapan.', '84, BCTI menyelenggarakan pelatihan dengan baik, namun perlu perbaikan dalam hal manajemen acara dan pengaturan waktu.', 'Pelatihan ini memberikan wawasan yang berguna dalam menjadi MC, tetapi fasilitas dan manajemen acara bisa diperbaiki untuk pengalaman yang lebih baik.', 'Teknik MC untuk Acara Besar, Keterampilan Presentasi Profesional.', 'Pelatihan ini sangat membantu dalam mengasah kemampuan MC saya. Materinya bermanfaat dan relevan, meskipun fasilitas dan pengaturan acara bisa lebih baik.'),
(27, 24, 10, 6, '2024-08-13 07:46:47', '90, Materi sangat informatif dan relevan, namun akan lebih baik jika ada lebih banyak studi kasus praktis.', '80, Fasilitas memadai tetapi perlu perbaikan dalam hal kebersihan dan kenyamanan tempat duduk.', '85, BCTI menyelenggarakan pelatihan dengan baik, namun ada beberapa kendala dalam koordinasi yang perlu diperbaiki.', 'Pelatihan ini memberikan pengetahuan yang solid dan teknik yang berguna. Namun, perbaikan dalam fasilitas dan pengaturan acara akan meningkatkan pengalaman peserta.', 'Teknik Presentasi Lanjutan, Public Speaking untuk Profesional.', 'Pelatihan ini sangat membantu dalam meningkatkan keterampilan public speaking saya. Materinya relevan dan bermanfaat, walaupun fasilitas pelatihan bisa lebih baik.'),
(28, 25, 4, 6, '2024-08-13 07:50:40', '87, Materi sangat relevan dan berguna, tetapi beberapa topik bisa lebih diperluas dengan studi kasus praktis.\r\n\r\n', '75, Fasilitas cukup baik, namun perlu ada peningkatan dalam hal kenyamanan dan peralatan yang digunakan.', '82, BCTI mengelola pelatihan dengan cukup baik, meski ada beberapa aspek pengaturan acara yang bisa diperbaiki.', 'Pelatihan ini memberikan wawasan berharga tentang personal branding. Akan lebih baik jika ada lebih banyak contoh praktis dan perbaikan dalam fasilitas pelatihan.', 'Strategi Branding Digital, Pengembangan Kepemimpinan Pribadi.', 'Pelatihan ini sangat membantu dalam memahami dan membangun personal branding. Materinya relevan dan bermanfaat, meskipun fasilitas pelatihan bisa diperbaiki untuk meningkatkan pengalaman peserta.'),
(29, 35, 5, 6, '2024-08-13 07:55:43', '88, Materi sangat bermanfaat dan memberikan wawasan baru tentang menjadi MC. Namun, beberapa bagian bisa lebih mendalam.', '77, Fasilitas cukup baik, tetapi ada beberapa area yang memerlukan perbaikan, seperti kebersihan dan kenyamanan kursi.', '81, BCTI mengatur pelatihan dengan baik tetapi ada beberapa aspek yang bisa diperbaiki dalam hal koordinasi dan manajemen waktu.', 'Pelatihan ini sangat membantu dalam meningkatkan keterampilan MC. Perbaikan pada fasilitas dan manajemen acara akan lebih meningkatkan pengalaman pelatihan.', 'Pelatihan Teknik MC untuk Acara Besar, Workshop Keterampilan Presentasi.\r\n\r\n', 'Pelatihan ini memberikan banyak wawasan dan keterampilan praktis yang berguna untuk menjadi MC yang lebih baik. Walaupun fasilitas bisa lebih baik, materi yang diajarkan sangat bermanfaat.'),
(30, 37, 2, 6, '2024-08-13 08:02:09', '92, Materi sangat komprehensif dan relevan dengan kebutuhan public speaking. Beberapa sesi dapat diperluas dengan lebih banyak contoh praktis.', '78, Fasilitas cukup baik, tetapi perlu peningkatan pada area seperti akustik dan perlengkapan presentasi.\r\n\r\n', '83, BCTI mengelola acara dengan baik, namun ada beberapa aspek logistik yang perlu ditingkatkan untuk pengalaman peserta yang lebih baik.', 'Pelatihan ini memberikan pemahaman mendalam tentang public speaking dan sangat berguna. Peningkatan fasilitas dan penyempurnaan logistik akan membuat pelatihan lebih nyaman dan efisien.', 'Workshop Teknik Presentasi Lanjutan, Pelatihan Komunikasi Efektif.', 'Pelatihan ini sangat bermanfaat dalam meningkatkan keterampilan public speaking saya. Materi yang diajarkan sangat aplikatif, dan meskipun fasilitas pelatihan perlu sedikit perbaikan, pengalaman keseluruhan sangat positif.'),
(31, 26, 6, 7, '2024-08-13 12:58:08', '92, Materi yang disampaikan sangat komprehensif dan relevan dengan kebutuhan peserta. Namun, bisa lebih ditingkatkan dengan studi kasus yang lebih mendalam.', '85, Fasilitas cukup memadai dan mendukung proses pelatihan, tetapi perlu ada peningkatan pada kualitas ruang belajar dan koneksi internet.', '90, BCTI telah menyelenggarakan pelatihan dengan sangat baik dan terorganisir. Namun, pengelolaan waktu bisa lebih diperhatikan untuk memaksimalkan sesi pelatihan.', 'BCTI telah melakukan pekerjaan yang luar biasa dengan program ini. Akan sangat baik jika ada lebih banyak sesi hands-on untuk mengaplikasikan materi yang dipelajari.', 'Pelatihan tentang manajemen proyek dan pengembangan soft skills bisa menjadi tambahan yang bermanfaat.', 'Mengikuti Squid Camp memberikan wawasan baru dan keterampilan praktis yang dapat langsung diterapkan. Program ini sangat bermanfaat untuk pengembangan profesional.'),
(32, 27, 5, 7, '2024-08-13 13:01:33', '92, Materinya komprehensif dan disampaikan dengan sangat jelas, meskipun ada beberapa topik yang bisa lebih mendalam.', '85, Fasilitas yang disediakan sudah cukup memadai, meskipun beberapa peralatan bisa ditingkatkan untuk mendukung kenyamanan peserta.\r\n\r\n', '90, BCTI sangat profesional dalam menyelenggarakan pelatihan ini, dengan persiapan dan pengorganisasian yang baik.\r\n\r\n', 'Pelatihan ini sangat bermanfaat, namun akan lebih baik jika ada sesi tambahan untuk latihan praktek secara langsung.', 'Saya merekomendasikan pelatihan seputar teknik presentasi visual dan storytelling.', 'Pelatihan ini memberikan banyak wawasan baru dan meningkatkan kepercayaan diri saya dalam berbicara di depan umum. Terima kasih kepada BCTI yang telah menyelenggarakan acara ini dengan baik.'),
(33, 28, 8, 7, '2024-08-13 13:08:16', '92, Materi yang disampaikan sangat relevan dan aplikatif, membuat saya lebih percaya diri dalam berbicara di depan umum.', '88, Fasilitas sudah cukup memadai, namun ada ruang untuk perbaikan pada area audio visual.', '95, BCTI sangat profesional dalam penyelenggaraan pelatihan ini, dari awal hingga akhir proses berjalan dengan lancar.', 'Pelatihan ini sangat bermanfaat, tetapi akan lebih baik jika disertakan lebih banyak sesi praktik agar peserta lebih terlatih.', 'Saya merekomendasikan adanya pelatihan lanjutan untuk Public Speaking dengan fokus pada teknik presentasi visual.', 'Mengikuti pelatihan ini sangat mengubah cara pandang saya dalam berbicara di depan umum. Materinya praktis dan langsung bisa diterapkan. Saya merasa lebih siap dan percaya diri dalam menyampaikan ide-ide saya.'),
(34, 29, 2, 7, '2024-08-13 13:12:28', '95, Materi yang disampaikan sangat komprehensif dan praktis, langsung dapat diterapkan dalam kehidupan sehari-hari.', ' 88, Fasilitas pelatihan sudah cukup memadai, namun ada beberapa aspek yang bisa ditingkatkan seperti kualitas audio dan visual.', '92, BCTI telah menyelenggarakan pelatihan dengan baik, mulai dari pendaftaran hingga pelaksanaan sangat terorganisir.\r\n', 'Pelatihan ini sangat bermanfaat, terutama dalam meningkatkan kemampuan berbicara di depan umum. Mungkin dapat ditambahkan sesi praktek lebih banyak agar peserta lebih percaya diri.', 'Saya merekomendasikan pelatihan lanjutan tentang teknik presentasi profesional dan manajemen stres saat berbicara di depan umum.', 'Mengikuti pelatihan di BCTI adalah pengalaman yang luar biasa. Materi yang disampaikan relevan dan aplikatif, serta disajikan dengan cara yang menarik dan mudah dipahami. Saya merasa lebih siap dan percaya diri dalam berbicara di depan umum setelah mengikuti pelatihan ini.'),
(35, 30, 4, 7, '2024-08-13 13:14:53', '88, Materi cukup komprehensif dan relevan dengan kebutuhan personal branding, tetapi bisa lebih mendalam dalam aspek praktik langsung.\r\n\r\n', '80, Fasilitas baik namun beberapa peralatan seperti proyektor dan mikrofon memerlukan pemeliharaan lebih untuk meningkatkan kualitas sesi.', '85, BCTI memberikan dukungan yang baik selama pelatihan dengan layanan yang memadai, namun ada ruang untuk peningkatan dalam hal komunikasi pra-pelatihan.\r\n\r\n', 'Pelatihan Personal Branding sangat bermanfaat dan memberikan wawasan baru tentang cara membangun citra diri. Akan lebih baik jika ada lebih banyak sesi interaktif dan studi kasus nyata untuk mengaplikasikan materi yang dipelajari.', 'Disarankan untuk menyertakan workshop atau sesi lanjutan tentang media sosial dan strategi digital yang dapat mendukung personal branding secara lebih efektif.', 'Pelatihan ini memberikan banyak informasi berharga dan praktik langsung yang membantu saya memahami dan mengembangkan personal branding. Pengalaman saya sangat positif dan saya merasa lebih percaya diri dalam membangun citra profesional saya.'),
(36, 75, 3, 7, '2024-08-13 13:17:13', '95, Materi sangat relevan dan mendalam, memberikan wawasan yang berharga tentang kepemimpinan wanita.', '90, Fasilitas sangat mendukung dengan ruang yang nyaman dan perlengkapan yang memadai.', '92, BCTI menyelenggarakan acara dengan sangat baik, semua aspek organisasi dan logistik berjalan lancar.', 'Pelatihan ini sangat inspiratif dan mengedukasi. Penyampaian materi yang interaktif dan fasilitator yang berpengalaman membuat pelatihan ini sangat bermanfaat. Perlu sedikit peningkatan dalam manajemen waktu agar semua topik bisa dibahas lebih mendalam.\r\n\r\n', 'Pertimbangkan untuk menambah sesi lanjutan atau workshop dengan topik yang lebih spesifik seperti mentoring atau networking.', 'Pelatihan ini membuka banyak wawasan baru dan memberi saya kepercayaan diri lebih dalam memimpin. Metodologi yang digunakan sangat sesuai dengan kebutuhan dan tantangan yang dihadapi wanita dalam kepemimpinan.'),
(37, 38, 9, 8, '2024-08-13 13:19:56', '85, Materi CV Breakdown sangat informatif dan aplikatif. Membantu peserta memahami elemen-elemen kunci dalam membuat CV yang efektif, meski ada beberapa area yang bisa lebih detail.', '80, Fasilitas pelatihan memadai namun ada beberapa kekurangan seperti kurangnya materi cetak dan alat bantu visual yang bisa memperkaya sesi.', '87, BCTI memberikan dukungan yang solid dengan materi yang terstruktur dan jelas. Namun, beberapa sesi bisa diperbaiki dalam hal waktu alokasi dan pembagian kelompok.', 'Pelatihan ini sangat bermanfaat untuk meningkatkan keterampilan dalam membuat CV yang menarik dan profesional. Namun, penambahan lebih banyak contoh kasus dan template bisa meningkatkan efektivitas pelatihan.', 'Pelatihan tambahan tentang teknik wawancara dan pengembangan profil LinkedIn bisa menjadi pelatihan yang relevan untuk melengkapi skill set peserta.', 'Pelatihan ini memberikan wawasan yang berharga tentang cara menonjolkan pengalaman dan keahlian dalam CV. Struktur yang jelas dan tips praktis sangat membantu untuk mempersiapkan aplikasi pekerjaan dengan lebih percaya diri.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(38, 39, 10, 8, '2024-08-13 13:30:12', '85, materi sangat relevan dengan kebutuhan presentasi, mencakup teknik-teknik penting yang aplikatif dalam berbagai situasi.', '80, fasilitas baik dan mendukung, meskipun ada beberapa kendala teknis kecil yang perlu diperbaiki.', '82, pelatihan berjalan dengan baik, namun ada beberapa aspek logistik yang perlu ditingkatkan untuk pengalaman yang lebih lancar.', 'Materi dan metode pelatihan sangat membantu dalam mengasah keterampilan public speaking. Namun, akan lebih baik jika ada lebih banyak sesi praktik langsung untuk memantapkan pemahaman.', 'Pelatihan tentang teknik presentasi lanjutan atau storytelling untuk meningkatkan kemampuan berbicara di depan umum.', 'Pelatihan ini sangat membantu dalam meningkatkan kemampuan berbicara di depan umum. Materi yang diberikan sangat relevan dan aplikatif, meskipun ada beberapa kendala teknis, keseluruhan pelatihan sangat memuaskan.'),
(39, 40, 7, 8, '2024-08-13 13:32:34', '90, Materi sangat relevan dan memberikan wawasan mendalam tentang kepemimpinan. Materi disajikan dengan jelas dan aplikatif untuk pemimpin muda.\r\n\r\n', '90, Materi sangat relevan dan memberikan wawasan mendalam tentang kepemimpinan. Materi disajikan dengan jelas dan aplikatif untuk pemimpin muda.\r\n\r\n', '85, BCTI memberikan dukungan yang solid selama pelatihan. Koordinasi dan komunikasi yang baik, meskipun ada ruang untuk perbaikan dalam hal penyediaan materi tambahan.', 'Pelatihan ini sangat bermanfaat untuk pengembangan kepemimpinan. Materi yang diberikan sangat berkualitas dan sesuai dengan kebutuhan peserta. Fasilitas dan dukungan BCTI sudah baik, tetapi peningkatan di area fasilitas akan menambah kenyamanan peserta.\r\n\r\n', 'Pertimbangkan untuk menambahkan modul tentang manajemen konflik dan komunikasi efektif untuk pemimpin, yang dapat melengkapi materi yang sudah ada.', 'Pelatihan ini memberikan banyak wawasan dan alat yang berguna untuk menjadi pemimpin yang lebih baik. Interaksi dengan peserta lain dan materi yang disampaikan sangat berharga dalam mengembangkan keterampilan kepemimpinan.'),
(40, 41, 6, 8, '2024-08-13 13:36:58', '90, materi yang disajikan sangat relevan dan komprehensif, mencakup semua aspek penting. Namun, penjelasan beberapa topik bisa diperluas lebih lanjut.', '80, fasilitas yang disediakan memadai, namun beberapa peralatan atau ruang pelatihan bisa lebih ditingkatkan untuk kenyamanan peserta.', '85, BCTI memberikan dukungan yang baik dalam pelatihan, tetapi ada beberapa area yang bisa diperbaiki untuk memaksimalkan pengalaman peserta.', 'Pelatihan ini sangat informatif dengan materi yang relevan dan aplikatif. Fasilitas perlu ditingkatkan untuk memastikan kenyamanan peserta. Dukungan BCTI cukup baik, namun ada ruang untuk peningkatan dalam aspek operasional.', 'Pertimbangkan pelatihan tambahan dalam pengembangan keterampilan praktis dan aplikasi langsung dari materi yang telah dipelajari.', 'Pelatihan Bootcamp: Squid Camp sangat bermanfaat dalam memberikan pemahaman mendalam tentang topik yang dibahas. Pengalaman ini meningkatkan keterampilan praktis saya dan membuka peluang baru untuk pengembangan profesional.'),
(41, 47, 5, 8, '2024-08-13 13:42:02', '88, materi pelatihan informatif dan relevan, dengan banyak teknik yang berguna untuk MC. Namun, beberapa topik bisa dikembangkan lebih mendalam.', '85, fasilitas yang disediakan memadai dan nyaman, namun ada sedikit kendala teknis yang mempengaruhi pengalaman.', '90, BCTI menunjukkan dukungan yang baik selama pelatihan, dengan koordinasi yang efisien dan dukungan materi.', 'Pelatihan memberikan banyak wawasan berharga tentang teknik MC, namun ada ruang untuk memperbaiki beberapa aspek teknis dan menambah materi praktik.', 'Pelatihan lanjutan tentang teknik berbicara di depan umum atau manajemen acara bisa sangat bermanfaat.', 'Pelatihan ini sangat membantu dalam mengasah keterampilan MC saya, terutama dalam hal improvisasi dan keterampilan komunikasi. Pengalaman praktis yang diberikan sangat berguna.'),
(42, 43, 3, 9, '2024-08-13 13:48:40', '85, materi pelatihan relevan dan bermanfaat dengan fokus yang jelas pada pengembangan kepemimpinan wanita, namun beberapa topik bisa diperluas lebih lanjut untuk kedalaman yang lebih baik.', '80, fasilitas yang disediakan cukup memadai tetapi ada beberapa kekurangan dalam peralatan yang mendukung kenyamanan peserta.', '88, BCTI menunjukkan manajemen pelatihan yang baik dengan struktur yang jelas dan dukungan yang memadai selama bootcamp.', 'Pelatihan memberikan wawasan berharga dan motivasi tinggi untuk wanita yang ingin memimpin. Beberapa penyesuaian pada fasilitas dan penambahan materi akan meningkatkan pengalaman pelatihan.\r\n\r\n', 'Disarankan untuk menambahkan sesi praktik langsung dan workshop interaktif untuk meningkatkan keterlibatan peserta.', 'Pelatihan ini memberikan saya dorongan besar dan keterampilan baru yang sangat berguna dalam perjalanan kepemimpinan saya. Program ini penuh inspirasi dan sangat bermanfaat.'),
(43, 44, 10, 9, '2024-08-13 13:57:49', '80, materi disampaikan dengan baik, namun bisa lebih mendalam dan aplikatif untuk kebutuhan praktis.', '85, fasilitas mendukung namun beberapa peralatan perlu pembaruan untuk pengalaman yang lebih optimal.', '82, BCTI memberikan pengalaman yang solid, tetapi ada beberapa area yang bisa ditingkatkan seperti waktu alokasi untuk praktik.', 'Pelatihan ini memberikan dasar yang kuat untuk public speaking, namun penambahan sesi praktik lebih banyak dan feedback langsung akan sangat membantu.', 'Pelatihan tambahan tentang teknik berbicara di depan kamera dan presentasi virtual.', 'Pelatihan ini memberikan pemahaman yang baik tentang public speaking, namun saya merasa lebih banyak latihan praktik dan tips langsung dari pelatih akan sangat bermanfaat.'),
(44, 45, 4, 9, '2024-08-13 14:04:47', '92, materi sangat relevan dan terstruktur dengan baik, memberikan wawasan mendalam tentang personal branding.', '80, fasilitas memadai namun beberapa alat presentasi bisa diperbarui untuk pengalaman yang lebih baik.', '85, pelatihan berlangsung lancar dengan koordinasi yang baik, tapi ada ruang untuk perbaikan dalam aspek administrasi.', 'Pelatihan ini menawarkan materi yang sangat bermanfaat dan aplikatif. Namun, akan lebih baik jika ada lebih banyak sesi praktek langsung.\r\n\r\n', 'Disarankan untuk mengadakan pelatihan lanjutan tentang strategi digital branding untuk mendalami lebih jauh tentang tren dan teknik terbaru.', 'Pelatihan ini sangat membantu dalam membangun dan memasarkan merek pribadi saya. Materinya aplikatif dan pengajaran yang jelas membuat proses pembelajaran menjadi sangat produktif.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(45, 46, 2, 9, '2024-08-13 14:15:40', ' 92, materi sangat informatif dan relevan dengan kebutuhan public speaking, mencakup berbagai teknik dan strategi yang berguna.', '80, fasilitas cukup baik, namun ada beberapa peralatan yang perlu diperbarui atau ditingkatkan.', '87, BCTI menyelenggarakan pelatihan dengan standar tinggi, tetapi ada beberapa area yang bisa lebih ditingkatkan untuk pengalaman peserta.', 'Pelatihan sangat membantu dalam meningkatkan keterampilan public speaking. Materi yang disajikan sangat aplikatif, namun beberapa sesi terasa terlalu padat. Pengaturan waktu yang lebih baik akan sangat membantu.', 'Pelatihan sangat membantu dalam meningkatkan keterampilan public speaking. Materi yang disajikan sangat aplikatif, namun beberapa sesi terasa terlalu padat. Pengaturan waktu yang lebih baik akan sangat membantu.', 'Pelatihan sangat membantu dalam meningkatkan keterampilan public speaking. Materi yang disajikan sangat aplikatif, namun beberapa sesi terasa terlalu padat. Pengaturan waktu yang lebih baik akan sangat membantu.'),
(46, 48, 5, 10, '2024-08-13 14:23:21', '90, materi disajikan dengan jelas dan relevan, memberikan wawasan mendalam tentang keterampilan MC.', '80, fasilitas memadai, namun ada beberapa area yang bisa ditingkatkan seperti akses internet dan peralatan audio.', '85, pelatihan terorganisir dengan baik dan instruktur kompeten, tetapi ada ruang untuk perbaikan dalam hal interaksi peserta.\r\n\r\n', 'Pelatihan sangat bermanfaat dan materi yang disajikan sesuai dengan kebutuhan. Namun, ada beberapa masalah kecil dengan fasilitas yang perlu perhatian.', 'Pelatihan lanjutan tentang teknik presentasi yang lebih mendalam dan strategi engagement audiens.', 'Pelatihan ini memberikan banyak insight praktis yang sangat berguna untuk meningkatkan keterampilan MC. Pengalaman belajar yang positif meski ada beberapa aspek teknis yang bisa diperbaiki.'),
(47, 50, 1, 10, '2024-08-13 14:26:22', '92, materi sangat relevan dan komprehensif, memberikan wawasan mendalam tentang teknik MC yang efektif.', '85, fasilitas memadai dengan peralatan yang cukup baik, namun perlu perbaikan pada beberapa aspek teknis.', '88, BCTI berhasil menyelenggarakan pelatihan dengan baik, meskipun ada sedikit kekurangan dalam penjadwalan.\r\n\r\n', 'Pelatihan sangat bermanfaat dan terstruktur dengan baik. Fasilitas bisa lebih ditingkatkan untuk mendukung kenyamanan peserta.', 'Pertimbangkan pelatihan lanjutan tentang teknik presentasi dan manajemen acara.', 'Pelatihan ini memberikan pengetahuan yang sangat berharga tentang menjadi MC yang efektif, dengan materi yang aplikatif dan instruktur yang berpengalaman.'),
(48, 51, 6, 10, '2024-08-13 14:52:49', ' 85, materi sangat relevan dan informatif, tetapi beberapa topik bisa lebih mendalam.', '80, fasilitas cukup memadai, namun ada beberapa area yang perlu perbaikan, seperti alat bantu yang kurang.', '82, BCTI memberikan dukungan yang baik, namun beberapa proses administrasi bisa lebih efisien.\r\n\r\n', 'Pelatihan memberikan wawasan yang berguna dan praktik langsung yang bermanfaat. Perlu ditingkatkan pada fasilitas dan proses administrasi untuk pengalaman yang lebih baik.', 'Pertimbangkan menambahkan modul tambahan tentang tren terbaru dalam industri untuk menambah wawasan peserta.', 'Pelatihan ini sangat berguna untuk meningkatkan keterampilan praktis. Meskipun ada beberapa kendala dengan fasilitas, materi dan instruksi yang diberikan sangat membantu dalam pengembangan keterampilan saya.'),
(49, 52, 8, 10, '2024-08-13 15:01:55', '92, materi sangat komprehensif dan aplikatif untuk public speaking di tingkat lanjut.', '88, fasilitas memadai dan mendukung pelatihan, meski ada beberapa area yang perlu perbaikan.', ' 90, BCTI memberikan dukungan yang baik dan proses pelatihan berjalan lancar.', 'Pelatihan menawarkan materi yang sangat bermanfaat dan relevan. Fasilitas nyaman, meski ada sedikit kekurangan. BCTI efektif dalam mendukung proses pelatihan.', 'Pertimbangkan pelatihan lanjutan tentang teknik presentasi dan komunikasi bisnis.\r\n\r\n', 'Pelatihan ini sangat membantu dalam meningkatkan kemampuan public speaking saya, dengan materi yang relevan dan dukungan yang memadai dari BCTI.'),
(50, 53, 9, 11, '2024-08-13 15:05:09', '85, materi sangat relevan dan aplikatif untuk pembuatan CV yang efektif, meskipun ada beberapa topik yang bisa lebih mendalam.', '85, materi sangat relevan dan aplikatif untuk pembuatan CV yang efektif, meskipun ada beberapa topik yang bisa lebih mendalam.', ' 88, BCTI memberikan dukungan yang baik selama pelatihan, namun perlu peningkatan dalam komunikasi jadwal.', 'Pelatihan sangat bermanfaat dengan materi yang praktis untuk pengembangan CV. Fasilitas memadai tetapi ada beberapa kendala teknis yang perlu diatasi. Dukungan BCTI secara keseluruhan baik.', ' Pelatihan tentang teknik wawancara atau strategi pencarian kerja bisa sangat berguna.', 'Pelatihan ini memberikan wawasan yang jelas dan berguna untuk memperbaiki CV saya. Pendekatan praktisnya membantu saya memahami cara menyusun CV yang menarik.'),
(51, 54, 2, 11, '2024-08-13 15:06:55', '85, materi disajikan dengan baik dan relevan, tetapi beberapa topik bisa lebih mendalam.', '80, fasilitas yang disediakan cukup memadai, namun ada beberapa area yang perlu diperbaiki seperti ruang pertemuan yang lebih nyaman.', '87, BCTI menunjukkan kinerja yang baik dalam penyelenggaraan pelatihan, tetapi bisa lebih terorganisir dalam hal jadwal dan komunikasi.', 'Pelatihan ini secara keseluruhan bermanfaat dan menyajikan materi yang relevan untuk pengembangan keterampilan berbicara di depan umum. Beberapa aspek, seperti fasilitas, bisa ditingkatkan untuk memberikan pengalaman yang lebih nyaman.', 'Pelatihan lanjutan tentang teknik presentasi lanjutan atau manajemen panggung akan sangat bermanfaat untuk peserta yang ingin memperdalam keterampilan mereka.', 'Mengikuti pelatihan ini sangat membantu dalam meningkatkan kepercayaan diri saya dalam berbicara di depan umum. Materi yang disajikan relevan dan aplikatif, serta pelatihannya memberikan banyak wawasan praktis yang berguna dalam situasi nyata.'),
(52, 55, 6, 11, '2024-08-13 15:08:42', '90, Materi pelatihan sangat relevan dan mendalam, mencakup berbagai aspek penting dalam topik yang dibahas. Penyampaian materi dilakukan dengan jelas dan terstruktur.', '80, Fasilitas yang disediakan memadai dan mendukung proses pelatihan, namun beberapa peralatan teknis perlu diperbaiki agar tidak mengganggu sesi pelatihan.\r\n\r\n', '85, BCTI memberikan dukungan yang baik selama pelatihan dengan komunikasi yang jelas dan responsif. Namun, beberapa aspek administratif dapat ditingkatkan.', 'Pelatihan ini sangat bermanfaat dengan materi yang aplikatif dan pembimbing yang berpengalaman. Fasilitas perlu sedikit perbaikan, terutama dalam hal peralatan teknis. Secara keseluruhan, pengalaman belajar sangat positif.', 'Pelatihan lanjutan dalam topik terkait, seperti \"Advanced Techniques in [specific area]\" atau \"Leadership Skills in [relevant field]\" dapat sangat bermanfaat untuk melengkapi pengetahuan dan keterampilan yang diperoleh.', 'Pelatihan ini sangat memuaskan dan memberikan wawasan yang mendalam dalam bidang yang dibahas. Metodologi yang digunakan memungkinkan peserta untuk benar-benar memahami dan mengaplikasikan konsep yang dipelajari.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(53, 57, 4, 11, '2024-08-13 15:12:21', '90, Materi sangat relevan dan mendalam, memberikan wawasan yang jelas tentang bagaimana membangun dan mengelola personal branding. Contoh nyata dan studi kasus sangat membantu dalam pemahaman konsep.', '80, Fasilitas yang disediakan baik dan memadai untuk pelatihan. Namun, ada beberapa kekurangan kecil, seperti koneksi internet yang kadang tidak stabil dan ruang yang terasa agak sesak saat sesi interaktif.', ' 85, Program BCTI terorganisir dengan baik dan mendukung pengalaman belajar secara keseluruhan. Pendaftaran dan administrasi berjalan lancar, meskipun beberapa informasi awal bisa lebih jelas.', 'Pelatihan ini sangat bermanfaat dengan materi yang relevan dan aplikasi praktis yang kuat. Meskipun fasilitas bisa sedikit diperbaiki, pengalaman belajar secara keseluruhan sangat positif.', 'Pelatihan tentang teknik presentasi dan komunikasi efektif dapat menjadi pilihan baik berikutnya, untuk melengkapi keterampilan personal branding dengan kemampuan berbicara di depan umum.\r\n\r\n', 'Mengikuti pelatihan ini memberikan saya pemahaman yang lebih dalam tentang personal branding dan cara membangunnya secara efektif. Metode pembelajaran yang digunakan sangat aplikatif, dan saya merasa lebih percaya diri dalam mengelola citra profesional saya setelah mengikuti program ini.'),
(54, 58, 10, 11, '2024-08-13 15:14:21', '92, Materi sangat komprehensif dan relevan dengan kebutuhan presentasi profesional, namun beberapa topik bisa diperdalam lagi.\r\n\r\n', '88, Fasilitas yang disediakan sangat memadai, namun beberapa perangkat teknis perlu perawatan untuk optimalisasi.', '90, BCTI menunjukkan standar tinggi dalam penyelenggaraan pelatihan dengan dukungan yang solid dan pengelolaan yang efisien.', 'Pelatihan ini memberikan wawasan mendalam dan praktik yang bermanfaat untuk keterampilan berbicara di depan umum. Peningkatan pada beberapa alat teknis bisa lebih mendukung pengalaman belajar.', 'Pelatihan lanjutan mengenai teknik presentasi lanjutan atau public speaking dalam situasi berbeda bisa sangat bermanfaat.', 'Pelatihan ini telah memperkuat kemampuan saya dalam berbicara di depan umum dengan teknik yang mudah dipahami dan diterapkan. Saya merasa lebih percaya diri dan siap menghadapi audiens dengan cara yang lebih efektif.'),
(55, 59, 3, 12, '2024-08-13 15:20:28', '92, Materi yang disajikan sangat relevan dan mendalam, memberikan wawasan yang berharga mengenai kepemimpinan wanita dan keterampilan yang dibutuhkan.', '85, Fasilitas memadai dan mendukung proses belajar, namun beberapa peralatan perlu pembaruan untuk meningkatkan kenyamanan peserta.', '88, BCTI secara keseluruhan memberikan dukungan yang baik dalam pelatihan ini, dengan proses administrasi yang lancar dan responsif terhadap kebutuhan peserta.', 'Pelatihan ini sangat inspiratif dan memberikan banyak informasi praktis. Menyediakan lebih banyak sesi praktik dan studi kasus nyata akan lebih membantu peserta dalam penerapan langsung.', 'Pelatihan lebih lanjut tentang manajemen konflik dan strategi komunikasi untuk pemimpin wanita akan sangat bermanfaat.\r\n\r\n', 'Pelatihan ini memberikan saya banyak perspektif baru tentang kepemimpinan wanita. Saya merasa lebih percaya diri dan siap menghadapi tantangan sebagai pemimpin di masa depan.'),
(56, 60, 9, 12, '2024-08-13 15:22:57', '85, Materi yang diberikan sangat informatif dan relevan dengan penulisan CV profesional. Penjelasan mendetail tentang elemen-elemen CV yang efektif sangat membantu.', '80, Fasilitas yang disediakan memadai namun ada beberapa kekurangan dalam hal peralatan presentasi yang perlu diperbaiki untuk meningkatkan pengalaman pelatihan.', '87, BCTI menyelenggarakan pelatihan dengan sangat baik, namun beberapa area seperti interaksi dan dukungan tambahan bisa ditingkatkan lebih lanjut.', 'Pelatihan ini memberikan wawasan yang sangat berguna dalam memperbaiki CV dan menyusun aplikasi kerja yang efektif. Namun, sesi praktikal yang lebih intensif akan sangat bermanfaat.', 'Pertimbangkan untuk menambahkan modul tentang teknik wawancara dan persiapan pekerjaan yang lebih mendalam untuk melengkapi keterampilan yang diajarkan dalam pelatihan CV.', 'Pelatihan CV Breakdown sangat membantu dalam menyusun CV yang lebih profesional dan menarik. Saya merasa lebih percaya diri dalam proses aplikasi pekerjaan setelah mengikuti pelatihan ini.');
INSERT INTO `tbl_evaluasi_pelatihan` (`id_evaluasi_pelatihan`, `id_kehadiran`, `id_pelatihan`, `id_peserta`, `tgl_input_evaluasi_pelatihan`, `rating_materi`, `rating_fasilitas`, `rating_bcti`, `feedback`, `rekomendasi`, `testimoni`) VALUES
(57, 61, 10, 12, '2024-08-13 15:24:56', '92, Materi sangat relevan dan mendalam, mencakup semua aspek penting dari public speaking dengan contoh yang aplikatif. Beberapa topik bisa dijelaskan lebih rinci.', '88, Fasilitas yang disediakan memadai dan mendukung proses pelatihan. Namun, beberapa alat presentasi perlu diperbarui untuk mendukung sesi yang lebih interaktif.', '90, BCTI berhasil menyediakan platform pelatihan yang efektif dengan dukungan yang baik. Sistem pelatihan berjalan lancar, meskipun ada ruang untuk perbaikan dalam koordinasi acara.', 'Pelatihan ini memberikan wawasan berharga dan strategi praktis untuk public speaking. Fasilitas yang disediakan sudah sangat baik, namun ada beberapa area yang bisa ditingkatkan untuk pengalaman peserta yang lebih optimal.', 'Pertimbangkan menambahkan sesi lanjutan atau workshop tentang teknik presentasi tingkat lanjut dan pengembangan keterampilan berbicara di depan publik yang lebih mendalam.\r\n\r\n', 'Pelatihan ini sangat membantu saya dalam meningkatkan keterampilan public speaking. Saya merasa lebih percaya diri dan siap untuk berbicara di depan audiens berkat materi yang diberikan dan praktik yang dilakukan selama pelatihan.'),
(58, 62, 7, 12, '2024-08-13 15:31:07', '90, materi sangat relevan dan mendalam, dengan konten yang bermanfaat untuk mengembangkan kepemimpinan remaja. Beberapa bagian dapat diperdalam lebih lanjut.', '85, fasilitas yang disediakan cukup memadai, namun ada beberapa aspek yang bisa diperbaiki, seperti ruang breakout yang lebih nyaman dan peralatan yang lebih lengkap.', '88, BCTI menunjukkan kemampuan yang baik dalam mengelola acara dan pelatihan. Proses pendaftaran dan administrasi bisa ditingkatkan untuk pengalaman yang lebih mulus.', 'Program ini sangat baik dalam membekali peserta dengan keterampilan kepemimpinan dan strategi untuk menghadapi tantangan. Penyampaian materi yang interaktif dan studi kasus yang relevan sangat membantu. Namun, waktu alokasi untuk beberapa sesi tampak terburu-buru.', 'Pertimbangkan menambahkan sesi lanjutan tentang manajemen tim dan konflik, serta workshop praktis untuk memperdalam keterampilan yang telah diajarkan.', 'Pelatihan ini memberikan wawasan yang berharga dan keterampilan praktis dalam kepemimpinan. Saya merasa lebih siap untuk mengambil peran kepemimpinan dan menerapkan strategi yang dipelajari. Pengalaman belajar yang sangat positif dan bermanfaat.'),
(59, 63, 8, 12, '2024-08-13 15:40:17', '85, materi sangat relevan dan bermanfaat, meskipun beberapa topik bisa lebih mendalam.\r\n\r\n', '80, fasilitas memadai namun ada beberapa peralatan yang tidak berfungsi dengan baik.', '88, BCTI memberikan dukungan yang baik dengan jadwal yang terstruktur dan komunikasi yang efektif.', 'Pelatihan ini sangat berguna untuk meningkatkan kemampuan berbicara di depan umum. Akan lebih baik jika ada lebih banyak sesi praktek untuk memperkuat teori yang disampaikan.', 'Mengadakan workshop lanjutan tentang teknik berbicara di depan umum atau pelatihan intensif untuk public speaking.', 'Mengikuti pelatihan ini memberikan saya kepercayaan diri tambahan dalam berbicara di depan umum dan memberikan wawasan baru tentang cara menyampaikan pesan dengan lebih efektif.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(60, 65, 4, 12, '2024-08-13 15:44:54', '92, materi sangat relevan dengan kebutuhan personal branding saat ini dan disampaikan dengan jelas.', '85, fasilitas yang disediakan memadai dan mendukung proses belajar, namun ada beberapa area yang bisa ditingkatkan seperti penyediaan materi tambahan.', '88, BCTI memberikan dukungan yang baik selama pelatihan, dengan komunikasi yang lancar dan responsif terhadap kebutuhan peserta.', 'Pelatihan ini sangat bermanfaat untuk mengembangkan strategi personal branding. Materi yang disajikan lengkap dan aplikatif. Akan lebih baik jika ada lebih banyak contoh kasus nyata dan sesi praktik langsung.', 'Pertimbangkan untuk menambah pelatihan tentang pengembangan konten digital dan strategi media sosial sebagai kelanjutan dari personal branding.', 'Pelatihan ini memberikan wawasan yang mendalam dan praktis tentang personal branding. Saya merasa lebih percaya diri dalam membangun citra profesional dan menerapkan strategi yang telah dipelajari.'),
(61, 69, 9, 13, '2024-08-13 16:08:27', '85, materi CV breakdown cukup komprehensif dan relevan, namun beberapa topik bisa diperluas untuk memberikan pemahaman yang lebih mendalam.', '88, fasilitas yang disediakan memadai dengan ruang yang nyaman dan peralatan yang berfungsi dengan baik, tetapi ada beberapa kekurangan pada perlengkapan teknis.', '90, BCTI secara keseluruhan memberikan dukungan yang baik dalam pelatihan ini, dengan komunikasi yang jelas dan waktu respon yang cepat.', 'Pelatihan ini memberikan wawasan yang bermanfaat tentang cara menyusun CV yang efektif. Penjelasan yang jelas dan struktur materi yang logis memudahkan pemahaman. Perlu ada sedikit perbaikan pada penyampaian materi agar lebih interaktif dan disertai contoh nyata.', 'Pertimbangkan untuk menambahkan sesi tentang strategi wawancara atau penulisan surat lamaran untuk melengkapi proses pencarian kerja.', 'Pelatihan ini membantu saya memahami cara membuat CV yang lebih menarik dan profesional. Materinya praktis dan langsung bisa diterapkan, membuat saya merasa lebih siap untuk melamar pekerjaan.'),
(62, 70, 1, 13, '2024-08-13 16:11:12', '90, materi pelatihan sangat komprehensif dengan pembahasan mendalam mengenai teknik MC dan strategi panggung yang aplikatif.', '85, fasilitas yang disediakan mendukung proses belajar dengan baik, meski ada beberapa area yang bisa diperbaiki seperti pencahayaan dan akustik.', '88, BCTI telah memberikan pengalaman pelatihan yang memadai, tetapi beberapa aspek administratif dapat ditingkatkan untuk proses yang lebih lancar.', 'Pelatihan memberikan wawasan yang sangat berguna dan praktis bagi calon MC. Materi yang disampaikan sangat relevan dan diterapkan langsung dalam simulasi. Namun, penambahan lebih banyak latihan praktis dan umpan balik langsung bisa lebih meningkatkan efektivitas pelatihan.', 'elatihan lanjutan dalam bidang public speaking dan manajemen acara bisa menjadi pilihan yang baik untuk memperluas keterampilan yang sudah dipelajari.\r\n\r\n', 'Pelatihan ini sangat bermanfaat untuk memahami teknik MC secara mendalam. Saya merasa lebih percaya diri dan siap untuk tampil di depan umum setelah mengikuti pelatihan ini.'),
(63, 71, 10, 13, '2024-08-13 16:15:27', '85, materi disampaikan dengan jelas dan mencakup topik-topik penting dalam public speaking. Namun, beberapa bagian bisa diperluas dengan contoh dan studi kasus yang lebih relevan.', '80, fasilitas yang disediakan cukup memadai tetapi ada beberapa kekurangan dalam hal peralatan presentasi yang membuat pengalaman belajar sedikit terganggu.\r\n\r\n', '87, BCTI memberikan dukungan yang baik selama pelatihan, namun ada ruang untuk peningkatan dalam hal koordinasi dan pengaturan jadwal.\r\n\r\n', 'Pelatihan ini sangat bermanfaat dalam meningkatkan keterampilan berbicara di depan umum, dengan materi yang relevan dan instruktur yang berpengalaman. Namun, ada beberapa kendala teknis yang perlu diperbaiki agar pengalaman belajar lebih optimal.', 'Pertimbangkan untuk menambahkan modul tambahan tentang teknik berbicara yang lebih canggih dan sesi latihan praktis yang lebih intensif.', 'Mengikuti pelatihan ini sangat membantu dalam mengasah keterampilan berbicara di depan umum saya. Materinya relevan dan instruktur sangat kompeten, meskipun fasilitas perlu sedikit perbaikan.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(64, 72, 5, 13, '2024-08-13 16:18:07', ' 92, materi sangat komprehensif dan aplikatif untuk MC, dengan banyak contoh praktis yang relevan.', '80, fasilitas cukup memadai, namun ada beberapa kekurangan dalam peralatan yang mempengaruhi kenyamanan.\r\n\r\n', '85, BCTI memberikan dukungan yang baik selama pelatihan, tetapi ada ruang untuk perbaikan dalam hal komunikasi dan koordinasi.', 'Pelatihan ini sangat membantu untuk meningkatkan keterampilan MC. Materi yang diberikan sangat relevan dan up-to-date. Penambahan beberapa latihan langsung dapat meningkatkan pemahaman lebih lanjut.', 'Pertimbangkan untuk menambah sesi praktik langsung dan studi kasus untuk lebih memperdalam pemahaman peserta.', 'Pelatihan ini sangat bermanfaat untuk saya. Saya merasa lebih percaya diri dan siap untuk menghadapi berbagai situasi sebagai MC setelah mengikuti sesi ini.\r\n\r\n\r\n\r\n\r\n\r\n'),
(65, 73, 2, 13, '2024-08-13 16:23:05', ' 92, materi yang disampaikan sangat komprehensif dan relevan dengan kebutuhan peserta. Setiap topik dibahas dengan detail yang memadai.', '80, fasilitas yang disediakan cukup baik namun ada beberapa area yang bisa diperbaiki, seperti alat bantu visual yang perlu diperbarui.', '87, pelatihan dikelola dengan baik dengan perhatian pada detail dan kepuasan peserta. Namun, ada ruang untuk peningkatan dalam hal koordinasi dan penyampaian materi.', 'Pelatihan ini sangat bermanfaat dengan materi yang disampaikan dengan jelas dan mendalam. Namun, fasilitas yang digunakan perlu diperhatikan lebih lanjut untuk meningkatkan pengalaman belajar. Penjadwalan dan koordinasi juga bisa lebih diperbaiki.\r\n\r\n', 'Pelatihan tambahan tentang teknik presentasi lanjutan dan keterampilan komunikasi interpersonal bisa sangat bermanfaat untuk melengkapi pelatihan ini.', 'Saya sangat menikmati pelatihan ini karena materi yang disampaikan sangat relevan dan praktis. Pengalaman belajar saya meningkat secara signifikan, meski ada beberapa aspek yang bisa ditingkatkan untuk pelatihan mendatang.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(66, 84, 2, 15, '2024-09-21 05:26:26', '90, materi sangat relevan dan langsung bisa diterapkan. Pembicara juga sangat menginspirasi.', '80, fasilitas cukup baik, tetapi beberapa kursi kurang nyaman. Ruangan cukup mendukung suasana belajar.', '95, pelayanan tim BCTI sangat baik dan acara terorganisir dengan rapi. Sesi-sesi berjalan lancar.', 'Pelatihan ini bermanfaat, namun lebih baik jika ada lebih banyak sesi praktik untuk menerapkan materi.', 'Rekomendasi untuk pelatihan \"Effective Communication\" dan \"Team Building\".', 'Pelatihan ini sangat membantu saya dalam mengatasi rasa gugup saat berbicara di depan umum. Banyak tips berguna yang saya terapkan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_evaluasi_trainer`
--

CREATE TABLE `tbl_evaluasi_trainer` (
  `id_evaluasi_trainer` int(11) NOT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `id_trainer` int(11) NOT NULL,
  `id_pelatihan` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `tgl_input_evaluasi_trainer` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating_penguasaan_materi` text NOT NULL,
  `rating_metode_pengajaran` text NOT NULL,
  `rating_interaksi` text NOT NULL,
  `feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_evaluasi_trainer`
--

INSERT INTO `tbl_evaluasi_trainer` (`id_evaluasi_trainer`, `id_kehadiran`, `id_trainer`, `id_pelatihan`, `id_peserta`, `tgl_input_evaluasi_trainer`, `rating_penguasaan_materi`, `rating_metode_pengajaran`, `rating_interaksi`, `feedback`) VALUES
(1, 1, 7, 7, 1, '2024-08-13 03:11:45', '98, Trainer sangat menguasai materi, memberikan penjelasan yang mendalam dan menyeluruh. Semua pertanyaan peserta dijawab dengan baik dan jelas.', '95, Metode pembelajaran sangat efektif, menggabungkan teori dengan studi kasus yang relevan. Mungkin bisa ditambahkan lebih banyak simulasi untuk meningkatkan pengalaman belajar.', '100, Interaksi trainer sangat luar biasa, beliau selalu melibatkan peserta dalam diskusi dan memberikan kesempatan bagi semua untuk berpartisipasi.', 'Trainer sangat profesional dan karismatik. Saya merasa sangat terbantu dengan cara beliau menjelaskan materi yang rumit menjadi lebih sederhana. Sesi training ini sangat berkesan dan bermanfaat untuk pengembangan kepemimpinan saya.'),
(2, 2, 1, 1, 1, '2024-08-13 03:25:54', '95, Trainer sangat menguasai materi dengan detail yang memadai, memberikan penjelasan yang komprehensif tentang teknik-teknik MC. Pengetahuan mendalam tentang berbagai jenis acara sangat membantu.', '92, Metode pembelajaran yang digunakan sangat baik, menggabungkan teori dengan latihan praktis yang relevan. Namun, beberapa sesi mungkin bisa dibuat lebih interaktif dengan lebih banyak role-playing.', '97, Interaksi trainer sangat positif dan mendukung. Trainer aktif menjawab pertanyaan dan memberikan umpan balik konstruktif selama latihan. Trainer juga mampu menciptakan suasana yang nyaman dan terbuka.', 'Widya Wardhanie menyampaikan materi dengan sangat baik dan membuat suasana pelatihan menjadi sangat dinamis. Saya sangat menghargai cara trainer memfasilitasi sesi latihan dan memberikan umpan balik yang berguna. Saran untuk pelatihan mendatang adalah menambahkan lebih banyak simulasi real-time dan kasus studi untuk lebih mendalami penerapan teknik MC.'),
(3, 3, 8, 8, 1, '2024-08-13 03:43:14', '96, Trainer sangat menguasai materi dan memberikan penjelasan yang jelas dan mendalam. ', '92, Metode pembelajaran efektif dengan banyak praktik langsung, meskipun ada sedikit kekurangan dalam variasi teknik.', '94, Interaksi trainer sangat baik, responsif, dan mampu menciptakan suasana yang nyaman.', 'Nisrina Nuraini memberikan materi dengan sangat baik dan membuat sesi pelatihan menjadi sangat produktif. Lebih banyak latihan berbicara di depan audiens akan lebih membantu.'),
(4, 4, 4, 4, 1, '2024-08-13 03:46:22', '95, Trainer sangat menguasai materi dengan baik dan menyampaikan konsep-konsep personal branding dengan jelas.', '93, Metode pembelajaran yang digunakan cukup efektif, dengan kombinasi antara teori dan diskusi yang seimbang.', '97, Interaksi trainer sangat positif dan engaging, membuat peserta merasa nyaman dan terlibat aktif.', 'Akhmad Nurfidh sangat kompeten dalam membawakan materi. Sedikit tambahan contoh studi kasus nyata akan lebih memperkaya pemahaman.'),
(5, 5, 3, 3, 1, '2024-08-13 04:03:51', '98, Trainer sangat menguasai materi dengan baik dan memberikan banyak contoh yang aplikatif serta relevan.', '94, Metode pembelajaran yang digunakan sangat efektif, dengan kombinasi antara teori, diskusi, dan latihan praktis.', '96, Interaksi trainer sangat interaktif dan mendukung peserta untuk berpartisipasi aktif selama pelatihan.', 'Rojihah menyampaikan materi dengan sangat baik dan mampu membuat sesi pelatihan menjadi inspiratif. Mungkin bisa ditambahkan lebih banyak sesi diskusi untuk lebih memperdalam pemahaman.'),
(6, 31, 5, 5, 1, '2024-08-13 04:12:50', '100, Materinya sangat daging, disampaikan dengan sangat mendalam dan jelas oleh trainer.', '97, Metode pembelajaran yang digunakan sangat efektif, memadukan teori dengan latihan praktis yang nyata.', '95, Interaksi trainer sangat baik, Adi selalu mendorong peserta untuk aktif berpartisipasi dan memberikan feedback yang konstruktif.', 'Trainer sangat menginspirasi dan memberikan banyak tips praktis yang berguna. Mungkin bisa ditambahkan lebih banyak studi kasus atau contoh nyata untuk lebih memperkaya materi.'),
(7, 67, 2, 2, 1, '2024-08-13 04:21:05', '90, Materi dikuasai dengan baik, tapi ada topik yang perlu pendalaman.', '85, Metode interaktif, namun butuh lebih banyak contoh praktis.', '95, Trainer sangat komunikatif dan menciptakan suasana belajar yang nyaman.', 'Sangat kompeten, tapi lebih banyak studi kasus akan membantu.'),
(9, 6, 8, 10, 2, '2024-08-13 05:12:45', '92, Trainer menunjukkan penguasaan materi yang sangat baik, namun beberapa bagian dapat ditambahkan studi kasus lebih mendalam.', '88, Metode pembelajaran bermanfaat, tetapi bisa lebih menarik dengan variasi aktivitas dan media.', '90, Interaksi dengan peserta sangat baik dan mendukung, meskipun ada kalanya feedback peserta tidak langsung diakomodasi.', 'Trainer sangat berpengetahuan dan memberikan materi dengan jelas. Akan lebih baik jika metode pembelajaran lebih beragam dan memberi lebih banyak kesempatan untuk berlatih secara langsung.'),
(10, 7, 9, 9, 2, '2024-08-13 05:20:16', '95, Trainer sangat menguasai materi dan mampu menjelaskan dengan detail serta contoh-contoh yang relevan.\r\n\r\n', '93, Metode pembelajaran yang digunakan sangat interaktif dan mudah dipahami, termasuk penggunaan media yang tepat.', '97, Trainer sangat responsif dan mampu berinteraksi dengan baik, menjawab setiap pertanyaan dengan jelas dan sabar.', 'Secara keseluruhan, pelatihan ini sangat bermanfaat. Penguasaan materi dan metode pembelajaran dari trainer sangat efektif. Terus pertahankan kualitas seperti ini untuk pelatihan-pelatihan berikutnya.'),
(11, 8, 6, 6, 2, '2024-08-13 05:36:19', '90, Trainer sangat ahli dalam materi dan mampu menjelaskan dengan jelas. Namun, beberapa penjelasan bisa lebih terstruktur.', '85, Metode yang digunakan efektif, tetapi akan lebih baik jika ada variasi dalam cara penyampaian untuk menjaga perhatian peserta.', '88, Interaksi baik dan responsif terhadap pertanyaan peserta, tetapi lebih banyak diskusi kelompok akan meningkatkan pengalaman belajar.', 'Revaldy memiliki pengetahuan mendalam dan cara penyampaian yang baik. Meningkatkan variasi metode dan interaksi lebih lanjut dapat memperkaya pengalaman pelatihan.'),
(12, 9, 5, 5, 2, '2024-08-13 05:47:08', '95, Penguasaan materi sangat baik dan informatif, dengan contoh yang jelas dan relevan.', '90, Metode yang digunakan efektif dan mudah diikuti, tetapi bisa ditambah dengan lebih banyak latihan praktis.', '93, Interaksi dengan peserta sangat baik, trainer responsif dan membantu.', 'Trainer sangat menguasai materi dan mampu menjelaskan dengan jelas. Interaksi yang baik, namun menambahkan lebih banyak sesi latihan bisa sangat membantu.'),
(13, 11, 7, 7, 3, '2024-08-13 05:58:05', '90, Penguasaan materi sangat baik dan komprehensif. Trainer mampu menjelaskan konsep dengan jelas.', '85, Metode pembelajaran efektif, tetapi beberapa teknik interaktif dapat ditingkatkan untuk melibatkan peserta lebih aktif.', '88, Interaksi dengan peserta sangat baik. Trainer responsif terhadap pertanyaan dan memberikan feedback yang konstruktif.', 'Trainer Muhammad Zain Mahbuby menyampaikan materi dengan sangat baik dan mudah dipahami. Namun, penambahan lebih banyak kegiatan praktis atau diskusi kelompok dapat meningkatkan keterlibatan peserta.'),
(14, 12, 3, 3, 3, '2024-08-13 06:01:33', '90, Materi disampaikan dengan jelas dan mendalam, tapi beberapa topik bisa lebih diperluas.', '85, Metode yang digunakan efektif dan engaging, namun ada ruang untuk lebih banyak variasi dalam teknik penyampaian.', '88, Interaksi trainer sangat baik dan mendukung, tetapi terkadang terasa kurang interaktif dalam beberapa sesi.', 'Trainer Rojihah sangat menguasai materi dan mampu menyampaikannya dengan baik. Akan lebih baik jika ada lebih banyak kegiatan praktis untuk memperdalam pemahaman peserta.'),
(15, 13, 8, 8, 3, '2024-08-13 06:48:37', '95, Materi dikuasai dengan sangat baik oleh trainer, penyampaian yang jelas dan mendalam.', '90, Metode pembelajaran yang interaktif dan mudah dipahami, namun bisa lebih variatif untuk menjaga antusiasme peserta.', '93, Trainer sangat komunikatif dan responsif terhadap pertanyaan peserta, menciptakan suasana belajar yang nyaman.', 'Trainer sangat profesional dan mampu menjelaskan materi dengan baik. Interaksi yang dilakukan juga membantu pemahaman peserta secara maksimal.'),
(16, 14, 2, 2, 3, '2024-08-13 06:56:19', '95, Trainer sangat menguasai materi, memberikan pemahaman yang mendalam dan mudah dimengerti.', '90, Metode pembelajaran interaktif dan menarik, membuat materi lebih mudah dicerna.', '93, Interaksi dengan peserta sangat baik, trainer aktif dan responsif terhadap pertanyaan.', 'Pelatihan ini sangat inspiratif, trainer memberikan banyak insight yang praktis dan bermanfaat.'),
(17, 33, 5, 5, 3, '2024-08-13 07:04:22', '90, Trainer menguasai materi dengan baik, namun ada beberapa topik yang bisa lebih diperinci.', '88, Metode pembelajaran yang digunakan cukup efektif, namun bisa lebih interaktif dengan lebih banyak latihan langsung.', '92, Trainer sangat komunikatif dan mampu menciptakan suasana yang nyaman untuk bertanya dan berdiskusi.\r\n\r\n', 'Trainer sudah sangat baik dalam memberikan materi, namun akan lebih bagus jika ada lebih banyak simulasi nyata dalam sesi pembelajaran.'),
(18, 16, 1, 1, 4, '2024-08-13 07:12:45', '92, Trainer memiliki penguasaan materi yang baik, namun beberapa contoh bisa lebih konkret.', '87, Metode pembelajaran yang digunakan cukup baik, tetapi ada ruang untuk lebih banyak variasi dalam teknik penyampaian.', '90, Trainer interaktif dan mampu menjaga engagement peserta, meskipun ada beberapa momen yang bisa lebih dinamis.', 'Trainer sangat berpengalaman dan efektif dalam menyampaikan materi. Namun, akan lebih baik jika lebih banyak sesi praktek langsung dan contoh-contoh yang lebih mendalam untuk memperkuat pemahaman peserta.'),
(19, 17, 6, 6, 4, '2024-08-13 07:16:10', '90, Trainer memiliki pemahaman yang baik terhadap materi, namun ada beberapa konsep yang bisa lebih diperdalam.', '85, Metode pembelajaran yang digunakan cukup efektif, tetapi bisa lebih bervariasi untuk menjaga minat peserta.', '87, Trainer cukup interaktif dan mampu menjawab pertanyaan peserta dengan baik, namun bisa lebih proaktif dalam melibatkan semua peserta.', 'Trainer sudah melakukan pekerjaan yang baik, tetapi akan lebih baik jika ada lebih banyak sesi diskusi kelompok dan praktek langsung untuk memperkuat pemahaman materi.'),
(20, 32, 5, 5, 4, '2024-08-13 07:20:48', '94, Trainer sangat menguasai materi, namun ada beberapa bagian yang bisa lebih dijelaskan dengan contoh-contoh praktis.', '89, Metode pembelajaran cukup interaktif dan menarik, tetapi bisa lebih fokus pada praktek untuk meningkatkan keterampilan.', '91, Trainer berinteraksi dengan baik dan mampu menjaga energi kelas, namun ada ruang untuk lebih melibatkan semua peserta secara merata.', 'Trainer sudah sangat kompeten dan mampu menyampaikan materi dengan baik. Sesi praktek yang lebih banyak dan waktu diskusi yang lebih panjang akan sangat membantu dalam mengaplikasikan apa yang telah dipelajari.'),
(21, 18, 7, 7, 5, '2024-08-13 07:30:05', '87, Trainer cukup menguasai materi, tapi beberapa topik bisa lebih detail.', '84, Metode pembelajaran efektif, namun bisa lebih variatif.', '89, Trainer interaktif dan responsif, namun kadang kurang melibatkan semua peserta secara merata.', 'Trainer memiliki pengetahuan yang baik dan menyampaikan materi dengan jelas. Namun, akan lebih baik jika ada lebih banyak sesi diskusi kelompok dan latihan praktis.'),
(22, 20, 8, 8, 5, '2024-08-13 07:35:05', '89, Trainer menguasai materi dengan baik, tetapi beberapa bagian bisa lebih diperjelas dengan contoh lebih konkret.', '86, Metode pembelajaran cukup baik dan terstruktur, namun ada potensi untuk lebih banyak variasi dalam teknik pengajaran.', '91, Trainer sangat baik dalam berinteraksi dan menjawab pertanyaan, tetapi ada kesempatan untuk melibatkan semua peserta lebih aktif.', 'Trainer memberikan materi dengan jelas dan efektif. Namun, pelatihan akan lebih optimal dengan lebih banyak sesi praktek dan teknik berbicara langsung yang lebih bervariasi.'),
(23, 21, 2, 2, 5, '2024-08-13 07:38:44', '91, Trainer memiliki pemahaman materi yang mendalam dan menyampaikan dengan jelas, meski beberapa topik bisa lebih diperinci.', '84, Metode pembelajaran sudah efektif, namun variasi dalam teknik pengajaran bisa ditingkatkan untuk menjaga keterlibatan peserta.', '87, Trainer cukup baik dalam berinteraksi dan merespons peserta, tetapi ada ruang untuk lebih melibatkan peserta dalam diskusi.', 'Trainer memberikan materi dengan baik dan jelas. Akan lebih baik jika ada lebih banyak sesi praktek dan teknik berbicara yang lebih variatif untuk meningkatkan keterampilan peserta.'),
(24, 34, 5, 5, 5, '2024-08-13 07:41:19', '85, Trainer memiliki penguasaan materi yang baik tetapi beberapa topik penting bisa lebih mendalam.', '80, Metode yang digunakan efektif, namun bisa lebih inovatif dan beragam untuk meningkatkan keterlibatan peserta.', '88, Trainer berinteraksi dengan baik dan responsif terhadap pertanyaan, meskipun ada ruang untuk melibatkan semua peserta lebih aktif.', 'Trainer menyampaikan materi dengan jelas dan profesional. Pelatihan akan lebih optimal dengan lebih banyak sesi praktek dan teknik interaktif yang variatif.'),
(25, 22, 1, 1, 6, '2024-08-13 07:44:42', '88, Trainer sangat memahami materi dan menjelaskan dengan jelas, meskipun beberapa aspek bisa lebih dikembangkan dengan contoh lebih spesifik.', '82, Metode pembelajaran efektif tetapi bisa lebih bervariasi untuk meningkatkan keterlibatan peserta.', '85, Trainer interaktif dan responsif, namun melibatkan peserta dengan lebih aktif akan sangat bermanfaat.\r\n\r\n', 'Trainer menunjukkan penguasaan materi yang baik dan menyampaikannya dengan jelas. Namun, akan lebih baik jika ada lebih banyak variasi dalam metode pembelajaran dan lebih banyak kesempatan bagi peserta untuk berlatih.'),
(26, 24, 8, 10, 6, '2024-08-13 07:49:09', '92, Trainer sangat menguasai materi dan mampu menjelaskan konsep-konsep dengan jelas. Meskipun begitu, beberapa contoh praktis bisa lebih mendalam.', '84, Metode pembelajaran yang digunakan cukup baik, namun bisa ditingkatkan dengan menambahkan lebih banyak aktivitas praktis dan diskusi.', '89, Trainer sangat responsif dan interaktif dengan peserta, tetapi ada kesempatan untuk lebih melibatkan peserta dalam sesi diskusi.', 'Trainer menyampaikan materi dengan sangat baik dan efektif. Namun, penambahan sesi praktik yang lebih banyak dan metode pengajaran yang lebih bervariasi akan meningkatkan keterlibatan peserta.'),
(27, 25, 4, 4, 6, '2024-08-13 07:53:54', '90, Trainer memiliki penguasaan materi yang sangat baik dan menyampaikan informasi dengan jelas. Beberapa konsep bisa lebih diperluas dengan contoh nyata.', '80, Metode pembelajaran cukup efektif, namun akan lebih baik jika lebih banyak melibatkan peserta melalui aktivitas praktis dan studi kasus.', '85, Trainer berinteraksi dengan baik dan responsif terhadap pertanyaan peserta, tetapi bisa lebih aktif dalam mengajak diskusi dan feedback.', 'Trainer sangat kompeten dalam menyampaikan materi dan memberikan wawasan berharga tentang personal branding. Penambahan lebih banyak sesi praktik dan diskusi akan meningkatkan keterlibatan peserta.'),
(28, 35, 5, 5, 6, '2024-08-13 08:00:03', '85, Trainer sangat paham materi dan menjelaskan konsep dengan baik. Namun, beberapa bagian materi bisa lebih detail.', '80, Metode pembelajaran efektif, tetapi variasi dalam aktivitas dan metode bisa ditingkatkan untuk menjaga keterlibatan peserta.', '82, Trainer cukup interaktif dan responsif, namun lebih banyak kesempatan untuk berdiskusi dan praktek akan sangat membantu.', 'Trainer memiliki pengetahuan yang kuat dan menyampaikan materi dengan baik. Menambahkan lebih banyak aktivitas praktis dan diskusi akan membuat sesi lebih dinamis dan bermanfaat.'),
(29, 37, 2, 2, 6, '2024-08-13 08:03:14', '88, Trainer menunjukkan penguasaan materi yang baik dan mampu menjelaskan konsep dengan jelas. Namun, beberapa topik bisa lebih diperjelas dengan lebih banyak contoh nyata.', '79, Metode pembelajaran cukup efektif, tetapi penyampaian materi bisa lebih variatif dengan menggunakan lebih banyak alat bantu visual dan aktivitas interaktif.', '84, Trainer interaktif dan responsif terhadap peserta. Namun, kesempatan untuk tanya jawab dan feedback bisa ditingkatkan.\r\n\r\n', 'Trainer memiliki pengetahuan yang mendalam dan menyampaikan materi dengan baik. Namun, penggunaan metode pembelajaran yang lebih bervariasi dan peningkatan kesempatan diskusi akan meningkatkan efektivitas pelatihan.'),
(30, 26, 6, 6, 7, '2024-08-13 12:59:38', '95, Penguasaan materi sangat baik, dan penjelasannya mudah dipahami meskipun topiknya cukup kompleks.', '88, Metode pembelajaran cukup interaktif, namun ada beberapa bagian yang bisa lebih disederhanakan agar lebih mudah diikuti oleh semua peserta.', '90, Interaksi dengan peserta sangat positif dan terbuka untuk pertanyaan, meskipun kadang waktu diskusi terasa kurang panjang.', 'Trainer sangat kompeten dan mampu menjaga semangat peserta. Akan lebih baik jika ada lebih banyak contoh praktis yang diberikan selama pelatihan.'),
(31, 27, 5, 5, 7, '2024-08-13 13:05:37', '95, Materi yang disampaikan sangat mendalam dan menunjukkan pemahaman yang kuat dari trainer.', '90, Metode yang digunakan interaktif dan memudahkan peserta dalam memahami materi.', '93, Trainer sangat komunikatif dan responsif terhadap pertanyaan peserta.\r\n\r\n', 'Terus tingkatkan penggunaan contoh-contoh praktis untuk membantu peserta lebih memahami konsep yang diajarkan.'),
(32, 28, 8, 8, 7, '2024-08-13 13:11:20', '97, Trainer sangat menguasai materi dan mampu menjelaskan dengan sangat jelas dan mendalam.', '90, Metode pembelajaran yang digunakan interaktif dan membuat peserta lebih mudah memahami materi, meskipun beberapa sesi bisa lebih terstruktur.', '94, Trainer sangat ramah dan terbuka terhadap pertanyaan peserta, menciptakan suasana yang nyaman untuk belajar.', 'Trainer sangat berkompeten dan berhasil menciptakan suasana yang menyenangkan selama pelatihan. Akan lebih baik jika waktu diskusi diperpanjang agar peserta bisa lebih mengeksplorasi materi.'),
(33, 29, 2, 2, 7, '2024-08-13 13:13:41', '90, Trainer menunjukkan pemahaman yang mendalam tentang materi public speaking dan menyajikannya dengan jelas.', '85, Metode yang digunakan cukup efektif dan bervariasi, namun bisa lebih interaktif dengan lebih banyak latihan praktis.', '92, Interaksi dengan peserta sangat baik; trainer responsif terhadap pertanyaan dan memberikan umpan balik yang konstruktif.\r\n\r\n', 'Lani Wardani memiliki keahlian yang luar biasa dalam mengajar dan menyampaikan materi dengan cara yang menarik. Penambahan sesi praktikum lebih banyak akan semakin meningkatkan pengalaman pelatihan.'),
(34, 30, 4, 4, 7, '2024-08-13 13:16:00', '90, Trainer sangat menguasai materi dan memberikan insight yang mendalam tentang personal branding.', '85, Metode pembelajaran efektif dengan kombinasi teori dan praktik, namun beberapa sesi bisa lebih interaktif.', '88, Interaksi dengan peserta sangat baik, tetapi sedikit perbaikan dalam merespons pertanyaan yang lebih mendalam akan sangat membantu.', 'Trainer sangat kompeten dan mampu menjelaskan materi dengan jelas. Namun, memperbanyak studi kasus dan latihan praktis akan meningkatkan pengalaman pelatihan.'),
(35, 75, 3, 3, 7, '2024-08-13 13:18:17', '94, Penguasaan materi sangat kuat dan mendalam, memaparkan berbagai aspek kepemimpinan wanita dengan jelas.', '88, Metode pembelajaran variatif dan menarik, tetapi beberapa sesi bisa lebih interaktif untuk meningkatkan keterlibatan peserta.', '91, Interaksi dengan peserta sangat baik, responsif terhadap pertanyaan dan diskusi, menciptakan suasana yang mendukung.\r\n\r\n', 'Trainer sangat menguasai materi dan memberikan insight yang berharga. Meskipun metode pembelajaran sudah baik, ada ruang untuk meningkatkan keterlibatan peserta melalui teknik yang lebih interaktif. Sesi Q&A sangat membantu dan menambah nilai pada pelatihan.'),
(36, 38, 9, 9, 8, '2024-08-13 13:25:54', '90, Trainer sangat menguasai materi dan mampu menjelaskan konsep-konsep penting dalam CV Breakdown dengan jelas dan mendalam.', '85, Metode pembelajaran efektif dengan penggunaan slide presentasi dan diskusi interaktif. Namun, penambahan latihan langsung bisa meningkatkan pengalaman peserta.', '88, Trainer aktif berinteraksi dan menjawab pertanyaan peserta dengan sabar. Meskipun begitu, ada beberapa momen di mana waktu respon bisa lebih cepat.\r\n\r\n', 'Trainer menunjukkan pengetahuan mendalam tentang pembuatan CV dan memberikan umpan balik yang konstruktif. Penambahan sesi praktik dan studi kasus akan lebih memperkaya pengalaman belajar.'),
(37, 39, 8, 10, 8, '2024-08-13 13:31:22', '90, Trainer sangat menguasai materi dan memberikan penjelasan yang mendalam mengenai teknik-teknik public speaking yang penting.', '85, Metode pembelajaran yang digunakan sangat efektif dengan kombinasi teori dan praktik. Namun, beberapa metode bisa disesuaikan dengan kebutuhan peserta yang berbeda.', '88, Interaksi dengan trainer sangat baik. Trainer aktif dalam memberikan feedback dan menjawab pertanyaan, membuat peserta merasa didukung dan diperhatikan.', 'Trainer memiliki penguasaan materi yang sangat baik dan metode pembelajaran yang efektif. Interaksi yang baik membantu meningkatkan pemahaman. Namun, akan lebih baik jika ada lebih banyak sesi praktikum untuk aplikasi langsung dari materi yang diajarkan.'),
(38, 40, 7, 7, 8, '2024-08-13 13:33:31', '95, Trainer menunjukkan penguasaan materi yang sangat mendalam dan jelas. Penjelasan tentang kepemimpinan sangat terperinci dan aplikatif.', '85, Metode yang digunakan sangat efektif, dengan penggunaan berbagai teknik pembelajaran yang mendukung pemahaman peserta. Namun, variasi metode bisa lebih diperluas.', '90, Trainer sangat aktif berinteraksi dengan peserta, memberikan feedback konstruktif, dan memfasilitasi diskusi dengan baik.', 'Trainer sangat kompeten dalam menyampaikan materi dan berinteraksi dengan peserta. Penjelasan materi sangat jelas dan relevan. Saran untuk memperkenalkan lebih banyak studi kasus atau simulasi untuk lebih meningkatkan aplikasi praktis materi.'),
(39, 41, 6, 6, 8, '2024-08-13 13:40:08', '92, trainer menunjukkan penguasaan materi yang sangat baik dengan penjelasan yang mendalam dan akurat. Namun, beberapa bagian bisa diperjelas dengan lebih banyak contoh praktis.', '87, metode pembelajaran yang digunakan efektif dalam menyampaikan materi, tetapi bisa lebih interaktif untuk meningkatkan keterlibatan peserta.', '90, interaksi dengan peserta sangat baik, trainer responsif terhadap pertanyaan dan memberikan umpan balik yang konstruktif. Namun, ada kesempatan untuk meningkatkan sesi tanya jawab.', 'Trainer memiliki pemahaman yang mendalam tentang materi dan menyampaikannya dengan jelas. Metode pembelajaran sudah baik, namun lebih banyak interaksi dan aktivitas praktis dapat meningkatkan keterlibatan peserta.'),
(40, 47, 5, 5, 8, '2024-08-13 13:45:24', '92, trainer sangat menguasai materi dengan penjelasan yang jelas dan komprehensif, memberikan wawasan mendalam tentang teknik MC.\r\n\r\n', '88, metode pembelajaran efektif dengan kombinasi teori dan praktik, namun sedikit lebih banyak sesi praktik akan meningkatkan pemahaman.', '90, trainer aktif berinteraksi dengan peserta, memberikan umpan balik yang berguna dan membangun suasana yang positif.', 'Trainer menunjukkan keahlian yang tinggi dalam materi dan berkomunikasi dengan sangat baik. Akan lebih baik jika ada lebih banyak latihan langsung untuk menerapkan teknik yang diajarkan.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(41, 43, 3, 3, 9, '2024-08-13 13:53:48', '90, Trainer menunjukkan penguasaan materi yang sangat baik dan mampu menjelaskan konsep dengan detail serta relevansi tinggi terhadap kebutuhan peserta.', '85, metode yang digunakan efektif dan interaktif, namun beberapa sesi bisa lebih diperkaya dengan lebih banyak contoh praktis dan studi kasus.', '88, Trainer sangat responsif dan mendukung selama pelatihan, tetapi ada ruang untuk meningkatkan keterlibatan peserta dalam diskusi kelompok.', 'Trainer menunjukkan pengetahuan mendalam dan kemampuan menjelaskan materi dengan jelas. Menambahkan lebih banyak latihan praktis dan memperluas waktu untuk tanya jawab akan meningkatkan pengalaman belajar lebih jauh.'),
(42, 44, 8, 10, 9, '2024-08-13 14:02:26', '90, trainer sangat menguasai materi dengan detail yang memadai dan relevan.', '85, metode yang digunakan efektif namun ada beberapa teknik yang bisa diperlengkapi dengan cara yang lebih variatif.\r\n\r\n', '88, interaksi dengan peserta baik dan responsif, tetapi kesempatan untuk feedback lebih sering akan sangat membantu.\r\n\r\n', 'Trainer memiliki pengetahuan mendalam dan menyampaikan materi dengan jelas. Perlu penambahan lebih banyak sesi interaktif dan latihan praktis untuk meningkatkan pengalaman belajar.'),
(43, 45, 4, 4, 9, '2024-08-13 14:09:53', '90, trainer sangat menguasai materi dan memberikan wawasan mendalam mengenai personal branding.\r\n\r\n', '85, metode yang digunakan efektif, tetapi lebih banyak contoh praktis akan sangat membantu.', '88, interaksi dengan peserta cukup baik, tetapi ada kesempatan untuk meningkatkan keterlibatan.', 'Trainer menyampaikan materi dengan jelas dan penuh pengetahuan. Akan lebih bermanfaat jika ada lebih banyak sesi tanya jawab untuk mendalami topik lebih lanjut.'),
(44, 46, 2, 2, 9, '2024-08-13 14:16:42', '95, trainer sangat memahami materi dan menyampaikannya dengan detail yang mendalam.', '85, metode yang digunakan efektif, tetapi dapat lebih bervariasi untuk menjaga keterlibatan peserta.\r\n\r\n', '90, interaksi dengan peserta sangat baik, trainer terbuka untuk pertanyaan dan memberikan feedback yang konstruktif.', 'Trainer menyampaikan materi dengan sangat baik dan menjelaskan konsep-konsep kompleks dengan cara yang mudah dipahami. Namun, beberapa sesi bisa lebih dinamis untuk meningkatkan keterlibatan peserta.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(45, 48, 5, 5, 10, '2024-08-13 14:24:53', '95, trainer sangat memahami materi dan mampu menyampaikan informasi dengan detail dan jelas.', '88, metode yang digunakan efektif dengan kombinasi teori dan praktik, meskipun ada beberapa teknik yang bisa lebih inovatif.', '90, trainer sangat responsif dan interaktif, tetapi ada ruang untuk lebih melibatkan peserta secara aktif.', 'Trainer sangat kompeten dan memberikan materi yang mendalam. Sesi interaksi sangat membantu, namun ada kesempatan untuk memperbaiki dinamika kelompok.'),
(46, 50, 1, 1, 10, '2024-08-13 14:42:27', '94, trainer sangat menguasai materi dan menjelaskan dengan jelas serta mendalam.\r\n\r\n', '88, metode pembelajaran efektif dengan banyak praktik langsung, namun ada ruang untuk variasi dalam teknik pengajaran.', '90, interaksi dengan peserta sangat baik, trainer responsif dan memfasilitasi diskusi dengan baik.', 'Trainer sangat kompeten dan berpengalaman dalam MC. Metode pengajaran sangat membantu, namun penambahan beberapa studi kasus akan lebih memperkaya pengalaman belajar.'),
(47, 51, 6, 6, 10, '2024-08-13 14:58:20', '90, trainer sangat menguasai materi dan memberikan penjelasan yang jelas.', '85, metode pembelajaran efektif dengan banyak contoh praktis, namun bisa ditambah dengan lebih banyak latihan.', '88, interaksi sangat baik, trainer responsif dan mendukung, tetapi waktu tanggap bisa lebih cepat.\r\n\r\n', 'Trainer menunjukkan penguasaan materi yang kuat dan metode pembelajaran yang bermanfaat. Interaksi baik, namun ada ruang untuk perbaikan dalam hal respons dan keterlibatan peserta.'),
(48, 52, 8, 8, 10, '2024-08-13 15:02:41', '95, trainer sangat menguasai materi dan memberikan wawasan mendalam.', '88, metode pembelajaran praktis dan mudah dipahami, tetapi bisa lebih variatif.', '90, interaksi trainer sangat baik, responsif terhadap pertanyaan dan feedback.', 'Trainer sangat kompeten dan berpengetahuan luas. Metode pembelajaran cukup efektif, namun ada ruang untuk variasi lebih lanjut. Interaksi sangat mendukung proses belajar.'),
(49, 53, 9, 9, 11, '2024-08-13 15:06:07', '90, trainer menunjukkan pemahaman mendalam tentang pembuatan CV dan dapat menjelaskan konsep dengan jelas.', '85, metode yang digunakan efektif dengan kombinasi teori dan praktik, tetapi ada ruang untuk lebih banyak contoh langsung.', '88, interaksi dengan peserta sangat baik, responsif terhadap pertanyaan, dan memberikan umpan balik yang konstruktif.\r\n\r\n', 'Trainer sangat kompeten dan komunikatif. Metode pembelajaran yang diterapkan membantu pemahaman, meskipun lebih banyak studi kasus akan menambah nilai.'),
(50, 54, 2, 2, 11, '2024-08-13 15:07:37', '90, Trainer menunjukkan penguasaan materi yang sangat baik dengan penjelasan yang mendalam dan relevan. Setiap konsep disampaikan dengan jelas dan didukung oleh contoh praktis.', '85, Metode pembelajaran interaktif digunakan dengan baik, termasuk latihan dan simulasi. Namun, beberapa sesi bisa lebih bervariasi untuk meningkatkan keterlibatan peserta.', '88, Trainer sangat komunikatif dan responsif terhadap pertanyaan. Interaksi dengan peserta baik, meskipun kadang perlu lebih banyak waktu untuk menjawab semua pertanyaan secara mendalam.', 'Trainer memberikan penjelasan yang komprehensif dan aplikatif. Sesi yang interaktif membantu peserta lebih memahami materi. Perlu sedikit penyesuaian dalam metode untuk mencakup variasi gaya belajar yang berbeda.'),
(51, 55, 6, 6, 11, '2024-08-13 15:09:40', '92, Trainer sangat menguasai materi dengan penjelasan yang mendalam dan akurat. Kemampuan untuk menjawab pertanyaan dan menjelaskan konsep-konsep kompleks sangat memadai.', '85, Metode pembelajaran yang digunakan efektif dan variatif, mencakup presentasi, diskusi, dan studi kasus. Namun, beberapa sesi bisa lebih interaktif untuk meningkatkan keterlibatan peserta.', '88, Trainer memiliki interaksi yang baik dengan peserta, terbuka untuk pertanyaan dan memberikan umpan balik yang konstruktif. Beberapa peserta merasa lebih banyak waktu untuk diskusi kelompok akan sangat membantu.', 'Trainer sangat kompeten dan mampu menjelaskan materi dengan jelas. Metode pembelajaran sudah baik, tetapi sedikit peningkatan dalam interaksi dan sesi praktikal dapat meningkatkan pengalaman belajar. Secara keseluruhan, pelatihan sangat berharga dan bermanfaat.\r\n'),
(52, 57, 4, 4, 11, '2024-08-13 15:13:31', '88, Trainer menunjukkan pemahaman yang mendalam tentang personal branding dengan penjelasan yang terperinci dan relevan.', '85, Metode pembelajaran interaktif yang diterapkan sangat efektif, meski beberapa teknik bisa lebih diperjelas dengan contoh tambahan.', '90, Trainer sangat responsif dan aktif dalam menjawab pertanyaan serta memberikan umpan balik yang membangun.', 'Trainer memiliki penguasaan materi yang kuat dan menyampaikan informasi dengan cara yang menarik. Interaksi dengan peserta sangat baik, tetapi penambahan lebih banyak studi kasus bisa meningkatkan pemahaman lebih lanjut.'),
(53, 58, 8, 10, 11, '2024-08-13 15:17:20', '95, Trainer menunjukkan penguasaan materi yang sangat baik, dengan penjelasan yang mendalam dan relevansi yang tinggi terhadap public speaking.', '90, Metode pembelajaran yang digunakan sangat efektif dan interaktif, meskipun bisa ada variasi lebih dalam teknik pengajaran.', '88, Interaksi dengan peserta cukup baik, namun lebih banyak feedback langsung dan sesi tanya jawab akan lebih memperkaya pengalaman belajar.\r\n\r\n', 'Trainer sangat kompeten dalam menyampaikan materi dan memfasilitasi diskusi. Menambah sesi praktik dan simulasi akan lebih meningkatkan pemahaman dan keterampilan peserta.'),
(54, 59, 3, 3, 12, '2024-08-13 15:21:53', '90, Trainer memiliki penguasaan materi yang sangat baik. Informasi yang disampaikan sangat relevan dengan topik kepemimpinan wanita dan disampaikan dengan kejelasan dan keahlian yang mendalam.', '85, Metode pembelajaran yang digunakan sangat variatif dan menarik. Namun, lebih banyak aktivitas praktis atau role-play akan meningkatkan keterlibatan peserta dan pemahaman materi.', '88, Interaksi dengan trainer sangat baik, dengan banyak kesempatan bagi peserta untuk bertanya dan berdiskusi. Trainer terbuka untuk umpan balik dan sangat mendukung dalam menjawab pertanyaan peserta.\r\n\r\n', 'Trainer menyampaikan materi dengan cara yang inspiratif dan memotivasi. Akan lebih baik jika ada lebih banyak contoh kasus dan latihan praktis untuk memperkuat pemahaman peserta dan keterampilan yang diajarkan.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(55, 60, 9, 9, 12, '2024-08-13 15:23:49', '90, Trainer sangat menguasai materi terkait CV dan cara membuatnya efektif. Penjelasan yang diberikan jelas dan mendalam.', '85, Metode pembelajaran interaktif dan penggunaan studi kasus sangat membantu. Namun, beberapa sesi masih bisa diperbaiki untuk meningkatkan pemahaman peserta.', '88, Trainer terbuka untuk diskusi dan memberikan umpan balik yang konstruktif. Interaksi yang dilakukan membantu peserta merasa lebih terlibat.\r\n\r\n', 'trainer menyampaikan materi dengan sangat baik dan memfasilitasi diskusi yang bermanfaat. Meskipun ada beberapa bagian yang perlu lebih banyak waktu untuk mendalami, keseluruhan pelatihan sangat memuaskan.'),
(56, 61, 8, 10, 12, '2024-08-13 15:30:09', '95, Trainer menunjukkan penguasaan materi yang sangat mendalam dengan penjelasan yang jelas dan relevan. Materi disampaikan dengan cara yang mudah dipahami dan aplikatif.', '90, Metode pembelajaran yang digunakan sangat efektif, dengan kombinasi teori dan praktik yang seimbang. Namun, beberapa sesi dapat lebih diperkaya dengan contoh kasus atau simulasi lebih lanjut.', '92, Interaksi dengan peserta sangat baik, trainer terbuka untuk pertanyaan dan memberikan umpan balik yang konstruktif. Namun, lebih banyak sesi tanya jawab bisa meningkatkan keterlibatan peserta.', 'Trainer menunjukkan keahlian yang luar biasa dalam menyampaikan materi public speaking. Pendekatan yang digunakan sangat membantu dalam memahami konsep dan aplikasi praktis. Disarankan untuk menambahkan lebih banyak kesempatan bagi peserta untuk berlatih berbicara secara langsung di depan kelompok.'),
(57, 62, 7, 7, 12, '2024-08-13 15:34:27', '92, trainer menunjukkan penguasaan yang mendalam dengan contoh yang relevan dan up-to-date.', '88, metode pembelajaran efektif dengan banyak aktivitas interaktif, tetapi beberapa sesi bisa dipersingkat untuk efisiensi.', '90, trainer sangat komunikatif dan responsif terhadap pertanyaan, menciptakan suasana belajar yang inklusif.', 'Trainer menyampaikan materi dengan sangat jelas dan memotivasi peserta. Penambahan sesi praktikal lebih banyak bisa meningkatkan pemahaman.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(58, 63, 8, 8, 12, '2024-08-13 15:41:20', '90, sangat baik dalam menguasai dan menjelaskan materi, dengan referensi yang relevan dan terkini.', '85, metode yang digunakan bervariasi dan efektif, meski beberapa sesi bisa lebih interaktif.', '88, sangat responsif terhadap pertanyaan dan memberikan umpan balik yang konstruktif.', 'Trainer menunjukkan pemahaman mendalam dan keterampilan komunikasi yang kuat. Mungkin bisa ditambahkan lebih banyak studi kasus atau simulasi langsung untuk meningkatkan pengalaman belajar.'),
(59, 65, 4, 4, 12, '2024-08-13 15:49:07', '95, trainer menunjukkan pemahaman yang mendalam tentang personal branding dan mampu menjelaskan konsep dengan sangat baik.', '89, metode yang digunakan efektif dengan kombinasi teori dan praktik, namun penambahan studi kasus lebih mendalam bisa meningkatkan pengalaman belajar.\r\n\r\n', '90, trainer sangat responsif terhadap pertanyaan dan aktif dalam diskusi, menciptakan suasana belajar yang menyenangkan.', 'Trainer sangat berpengetahuan dan menyampaikan materi dengan jelas serta penuh semangat. Interaksi yang baik membuat sesi lebih interaktif dan membantu memahami konsep dengan lebih baik. Namun, lebih banyak contoh nyata dari praktik di lapangan akan sangat membantu peserta.'),
(60, 69, 9, 9, 13, '2024-08-13 16:09:34', '87, trainer menunjukkan penguasaan materi yang baik dengan penjelasan yang detail dan informatif, namun beberapa aspek dapat diperdalam lebih lanjut.', '82, metode pembelajaran cukup efektif dengan penggunaan slide dan contoh kasus, tapi ada ruang untuk memperbaiki interaktivitas dan keterlibatan peserta.', '80, interaksi trainer cukup baik, tetapi bisa lebih banyak memberikan kesempatan untuk diskusi dan tanya jawab untuk meningkatkan pemahaman peserta.', 'Trainer memiliki pengetahuan yang kuat tentang penyusunan CV dan menyampaikan informasi dengan jelas. Namun, meningkatkan keterlibatan peserta dan memberikan lebih banyak contoh nyata bisa membuat sesi lebih dinamis dan bermanfaat.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(61, 70, 1, 1, 13, '2024-08-13 16:12:14', '92, trainer sangat menguasai materi dengan memberikan penjelasan yang mendalam dan contoh praktis yang relevan.', '89, metode pembelajaran yang digunakan efektif dengan kombinasi teori dan praktik, namun beberapa bagian bisa disajikan dengan lebih interaktif.', '90, interaksi trainer sangat baik, dengan keterlibatan peserta yang tinggi dan respons yang cepat terhadap pertanyaan dan diskusi.', 'Trainer menunjukkan pemahaman yang mendalam dan kemampuan menjelaskan materi dengan jelas. Pendekatan interaktif sangat membantu dalam memahami teknik MC. Mungkin bisa ditambahkan beberapa sesi praktik tambahan untuk meningkatkan keterampilan peserta lebih jauh.'),
(62, 71, 8, 10, 13, '2024-08-13 16:16:34', '90, materi disampaikan dengan sangat baik dan mendalam, mencakup berbagai aspek penting dalam public speaking.', '85, metode pembelajaran efektif dengan kombinasi teori dan praktik, namun beberapa bagian bisa diperjelas.\r\n\r\n', '88, interaksi dengan peserta sangat baik dan mendukung, dengan umpan balik yang konstruktif dan responsif.', 'Trainer sangat kompeten dan materi sangat bermanfaat. Penerapan metode yang lebih variatif bisa meningkatkan pengalaman belajar.'),
(63, 72, 5, 5, 13, '2024-08-13 16:20:11', '90, trainer menunjukkan pemahaman yang mendalam tentang materi dan mampu menjelaskan konsep-konsep dengan jelas.', '88, metode pembelajaran sangat baik dengan penggunaan berbagai teknik untuk memastikan peserta memahami materi. Namun, beberapa metode bisa lebih disesuaikan dengan kebutuhan peserta.', '85, trainer sangat aktif dalam berinteraksi dan memberikan umpan balik yang konstruktif. Akan tetapi, ada kesempatan untuk meningkatkan keterlibatan peserta melalui sesi tanya jawab lebih sering.', ' Trainer memiliki pengetahuan yang kuat dan mampu menyampaikan materi dengan cara yang menarik. Peningkatan dalam variasi metode pembelajaran dan interaksi dengan peserta akan membuat pelatihan ini semakin efektif.'),
(64, 73, 2, 2, 13, '2024-08-13 16:23:55', '90, trainer menunjukkan pemahaman yang mendalam tentang materi. Semua topik dijelaskan dengan jelas dan memberikan wawasan yang sangat berguna.', '85, metode pembelajaran yang digunakan efektif, namun ada beberapa sesi yang bisa lebih interaktif untuk meningkatkan keterlibatan peserta.', '88, interaksi dengan peserta sangat baik. Trainer terbuka terhadap pertanyaan dan memberikan umpan balik yang konstruktif, meski terkadang respon bisa lebih cepat.', 'Trainer memiliki penguasaan materi yang sangat baik dan cara penyampaian yang jelas. Namun, metode pembelajaran bisa sedikit lebih bervariasi untuk menjaga semangat peserta. Interaksi yang baik tapi ada ruang untuk perbaikan dalam hal responsivitas.\r\n\r\n\r\n\r\n\r\n\r\n\r\n'),
(65, 84, 2, 2, 15, '2024-09-21 05:29:01', '95, trainer sangat menguasai materi, penjelasan detail dan mudah dipahami.', '90, metode yang digunakan menarik dan interaktif, banyak contoh kasus yang relevan.', '92, trainer aktif berinteraksi dengan peserta, menjawab pertanyaan dengan jelas dan memberikan feedback yang membangun.', 'Trainer sangat profesional dan ramah. Akan lebih bagus jika lebih banyak waktu untuk sesi tanya jawab agar bisa lebih mendalami materi.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kehadiran`
--

CREATE TABLE `tbl_kehadiran` (
  `id_kehadiran` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `status_kehadiran` varchar(255) NOT NULL,
  `nilai` varchar(255) NOT NULL,
  `saran` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_kehadiran`
--

INSERT INTO `tbl_kehadiran` (`id_kehadiran`, `id_pendaftaran`, `status_kehadiran`, `nilai`, `saran`) VALUES
(1, 1, 'hadir', '85', 'Perkuat keterampilan kepemimpinan melalui lebih banyak pengalaman langsung dan latihan dalam pengambilan keputusan.'),
(2, 2, 'hadir', '85', 'Sudah sangat baik dalam memanage acara, tapi perlu meningkatkan improvisasi untuk menghadapi situasi tak terduga.\r\n'),
(3, 3, 'hadir', '86', 'Latihan lebih banyak dalam pengelolaan waktu saat berbicara untuk memastikan setiap poin tercover dengan baik tanpa terburu-buru.'),
(4, 4, 'hadir', '87', 'Kinerja sangat baik dengan citra diri yang kuat. Perhatikan konsistensi dalam pesan pribadi di berbagai platform.'),
(5, 5, 'hadir', '88', 'Penampilan sangat baik dan penuh percaya diri. Perhatikan penggunaan bahasa tubuh untuk meningkatkan daya tarik presentasi.'),
(6, 6, 'hadir', '80', 'Perbaiki pengaturan tempo berbicara. Berlatih untuk berbicara dengan lebih konsisten dalam kecepatan dan volume suara.'),
(7, 7, 'hadir', '85', 'Perbaiki format CV agar lebih konsisten dan mudah dibaca. Gunakan bullet points untuk mencantumkan pencapaian dan pengalaman agar lebih jelas.'),
(8, 8, 'hadir', '84', 'Tingkatkan keterampilan komunikasi dan kepemimpinan melalui latihan lebih intensif. Fokus pada pengembangan jaringan dan kolaborasi dengan peserta lain.'),
(9, 9, 'hadir', '78', 'Perlu lebih percaya diri dan latihan dalam mengatasi situasi tidak terduga di atas panggung. Kembangkan teknik berbicara yang lebih interaktif.'),
(10, 10, 'tidak hadir', '', ''),
(11, 11, 'hadir', '78', 'Fokus pada pengembangan keterampilan komunikasi dan presentasi. Latihan berbicara di depan umum dapat meningkatkan kepercayaan diri.'),
(12, 12, 'hadir', '82', 'Konten presentasi cukup kuat, tetapi perlu meningkatkan ca'),
(13, 13, 'hadir', '79', 'Tingkatkan penggunaan bahasa tubuh untuk mendukung pesan yang disampaikan. Latihan di depan cermin bisa membantu meningkatkan kepercayaan diri.'),
(14, 14, 'hadir', '79', 'Pahami materi lebih dalam dan latih kepercayaan diri. Latihan lebih sering akan membantu mengurangi kegugupan di panggung.'),
(15, 15, 'tidak hadir', '', ''),
(16, 16, 'hadir', '78', 'Keterampilan berbicara sudah bagus, namun latihan lebih sering dapat membantu memperbaiki kepercayaan diri di panggung.'),
(17, 17, 'hadir', '76', 'Perbaiki kemampuan presentasi dan kepercayaan diri saat berbicara di depan umum. Latihan lebih banyak untuk meningkatkan penguasaan materi.'),
(18, 18, 'hadir', '90', 'Kinerja yang sangat baik dalam memimpin diskusi dan mengorganisir kelompok. Perhatikan pengelolaan waktu dan penetapan prioritas.'),
(19, 19, 'tidak hadir', '', ''),
(20, 20, 'hadir', '92', 'Kinerja yang sangat baik dalam berkomunikasi dengan audiens. Cobalah untuk mengeksplorasi variasi gaya berbicara untuk meningkatkan dampak.'),
(21, 21, 'hadir', '92', 'Kinerja yang sangat mengesankan. Pertahankan gaya berbicara yang percaya diri dan terus tingkatkan interaksi dengan audiens.'),
(22, 22, 'hadir', '90', 'Kinerja sangat memuaskan. Pertahankan penggunaan teknik vocal yang kuat dan cobalah untuk lebih terlibat dengan audiens.'),
(23, 23, 'tidak hadir', '', ''),
(24, 24, 'hadir', '91', 'Penyampaian dan keterlibatan yang sangat baik. Cobalah menggunakan berbagai teknik retorika untuk menambah variasi dan kedalaman pada presentasi Anda.'),
(25, 25, 'hadir', '79', 'Perlu meningkatkan keterampilan komunikasi dan presentasi. Fokus pada pembuatan profil yang lebih menarik di media sosial.'),
(26, 26, 'hadir', '88', 'Kinerja yang sangat baik dalam memanfaatkan kesempatan dan beradaptasi dengan situasi. Perhatikan pengelolaan waktu dan prioritas proyek yang lebih baik.'),
(27, 27, 'hadir', '83', 'Bagus dalam penguasaan materi, tetapi perbaiki cara beradaptasi dengan perubahan situasi di atas panggung dan tangani masalah teknis dengan lebih baik.'),
(28, 28, 'hadir', '84', 'Perbaiki intonasi suara dan kejelasan ucapan. Berlatih dengan merekam diri sendiri dapat membantu mengidentifikasi area yang perlu diperbaiki.'),
(29, 29, 'hadir', '75', 'Fokus pada pengendalian suara dan gerakan tubuh. Latihan lebih banyak di depan audiens dapat membantu meningkatkan keterampilan.'),
(30, 30, 'hadir', '91', 'Citra pribadi sangat positif dan konsisten. Latih untuk mengelola umpan balik secara lebih efektif untuk membangun hubungan yang lebih baik.'),
(31, 31, 'hadir', '85', 'Performa yang baik dengan penguasaan materi yang solid. Tingkatkan improvisasi dan kemampuan beradaptasi dengan audiens.'),
(32, 32, 'hadir', '82', 'Kinerja memadai, namun perlu lebih banyak latihan dalam pengaturan tempo dan pengelolaan waktu di atas panggung.'),
(33, 33, 'hadir', '90', 'Sangat baik dalam memimpin acara dan berkomunikasi dengan audiens. Fokus pada pengembangan gaya pribadi yang lebih unik.'),
(34, 34, 'hadir', '88', ' Terampil dalam membawakan acara dan menjaga energi positif. Perhatikan teknik mikrofon dan penggunaan suara yang lebih bervariasi.'),
(35, 35, 'hadir', '88', 'Perlu meningkatkan keterampilan berbicara dengan lebih ekspresif dan memanfaatkan humor secara efektif untuk meningkatkan keterlibatan audiens.\r\n'),
(36, 36, 'tidak hadir', '', ''),
(37, 37, 'hadir', '83', 'Kinerja yang sangat mengesankan. Pertahankan gaya berbicara yang percaya diri dan terus tingkatkan interaksi dengan audiens.'),
(38, 38, 'hadir', '78', 'Sertakan ringkasan profesional di bagian atas CV untuk memberikan gambaran umum yang jelas tentang keahlian dan tujuan karier Anda.'),
(39, 39, 'hadir', '85', 'Fokus pada pengurangan kata pengisi seperti \"um\" dan \"eh\" untuk meningkatkan profesionalisme pidato Anda.'),
(40, 40, 'hadir', '82', 'Tingkatkan keterampilan dalam bekerja dalam tim dan menangani konflik. Perbanyak latihan dalam memfasilitasi pertemuan kelompok.'),
(41, 41, 'hadir', '80', 'Perlu meningkatkan kemampuan dalam berkolaborasi dengan tim dan menangani konflik. Latihan dalam manajemen proyek akan sangat membantu.'),
(42, 42, 'hadir', '', ''),
(43, 43, 'hadir', '77', 'Fokus pada pengendalian kegugupan dan struktur presentasi. Cobalah untuk berlatih lebih sering di depan orang lain.'),
(44, 44, 'hadir', '78', 'Bekerja pada tempo berbicara dan pastikan setiap poin kunci dikomunikasikan dengan jelas. Gunakan jeda secara efektif untuk menekankan informasi penting.\r\n'),
(45, 45, 'hadir', '83', 'Konten yang disampaikan solid, tetapi perlu meningkatkan cara mempresentasikan diri secara lebih percaya diri dan menarik.'),
(46, 46, 'hadir', '89', 'Penampilan solid dengan konten yang relevan. Perbaiki pengaturan waktu untuk memastikan seluruh materi tersampaikan dengan baik.'),
(47, 47, 'hadir', '77', 'Latihan lebih banyak untuk mengurangi kegugupan dan tingkatkan teknik pengelolaan acara untuk menghadapi situasi yang tidak terduga.\r\n'),
(48, 48, 'hadir', '81', 'Perlu meningkatkan kemampuan berkomunikasi dengan audiens yang lebih luas dan memperbaiki tempo berbicara agar lebih teratur.'),
(49, 49, 'tidak hadir', '', ''),
(50, 50, 'hadir', '82', 'Penampilan di panggung cukup solid, tetapi lebih banyak latihan pada pengaturan tempo acara akan meningkatkan kinerja.'),
(51, 51, 'hadir', '82', 'Bagus dalam menangani tugas individu. Perbaiki keterampilan berbicara di depan umum dan tingkatkan cara menyampaikan ide secara jelas.'),
(52, 52, 'hadir', '77', 'Fokus pada struktur pidato dan alur logis penyampaian materi. Menggunakan outline atau catatan dapat membantu menjaga alur pembicaraan.'),
(53, 53, 'hadir', '90', 'CV Anda sangat detail dan informatif. Pastikan untuk menyesuaikan pengalaman dan keterampilan dengan posisi yang dilamar untuk meningkatkan relevansi.\r\n'),
(54, 54, 'hadir', '81', 'Teknik berbicara sudah baik, namun perlu memperbaiki cara berinteraksi dengan audiens dan mengelola stres.'),
(55, 55, 'hadir', '91', 'Performa sangat baik dengan inovasi dan kreativitas yang tinggi. Fokus pada pengembangan strategi jangka panjang dan implementasi rencana.'),
(56, 56, 'tidak hadir', '', ''),
(57, 57, 'hadir', '88', 'Pengelolaan personal branding yang sangat baik. Fokus pada pengembangan konten yang lebih relevan dengan audiens target.'),
(58, 58, 'hadir', '90', 'Penggunaan bahasa tubuh dan kontak mata yang sangat baik. Pertimbangkan untuk menambahkan variasi nada suara untuk menekankan bagian-bagian tertentu dari pesan Anda.'),
(59, 59, 'hadir', '89', 'Penampilan solid dengan ide yang jelas. Latihan dalam menghadapi pertanyaan dari audiens untuk meningkatkan responsifitas.'),
(60, 60, 'hadir', '82', 'Perhatikan tata bahasa dan ejaan. Kesalahan kecil dapat mempengaruhi kesan profesional dari CV Anda.'),
(61, 61, 'hadir', '82', 'Tingkatkan struktur pidato Anda untuk memastikan alur ide yang mulus. Latihan transisi antar topik dengan lebih lancar.'),
(62, 62, 'hadir', '77', 'Perbaiki keterampilan dalam mengelola proyek dan beradaptasi dengan perubahan. Latihan dalam perencanaan dan eksekusi proyek akan bermanfaat.\r\n'),
(63, 63, 'hadir', '89', 'Sangat baik dalam menyampaikan pesan dengan percaya diri. Perhatikan penggunaan visual aids untuk meningkatkan daya tarik dan pemahaman.'),
(64, 64, 'tidak hadir', '', ''),
(65, 65, 'hadir', '80', 'Penampilan yang baik, tetapi perlu memperbaiki cara berkomunikasi dengan audiens dan memperkuat pesan branding pribadi.'),
(66, 66, 'tidak hadir', '', ''),
(67, 67, 'hadir', '87', 'Penampilan sangat baik dengan struktur yang jelas. Perbaiki intonasi suara untuk membuat presentasi lebih menarik.'),
(68, 68, 'hadir', '87', 'Tingkatkan interaksi dengan audiens untuk membuat presentasi lebih menarik. Cobalah menggunakan teknik tanya jawab untuk melibatkan audiens lebih banyak.'),
(69, 69, 'hadir', '88', 'Struktur CV sangat baik. Pertimbangkan untuk menambahkan proyek atau portofolio yang relevan untuk menunjukkan keterampilan praktis Anda.'),
(70, 70, 'hadir', '87', 'Komunikasi yang efektif, namun perlu sedikit perbaikan dalam penampilan non-verbal untuk menarik perhatian audiens lebih baik.'),
(71, 71, 'hadir', '88', 'Keterampilan presentasi yang kuat. Cobalah menambahkan lebih banyak anekdot menarik atau contoh kehidupan nyata agar poin Anda lebih mudah dipahami.\r\n'),
(72, 72, 'hadir', '89', 'Kinerja sangat baik dengan penguasaan acara yang kuat. Tingkatkan improvisasi untuk lebih fleksibel dalam menghadapi situasi yang berubah cepat di panggung.'),
(73, 73, 'hadir', '77', 'Perlu meningkatkan penguasaan materi dan teknik berbicara. Latihan tambahan dapat membantu meningkatkan kemampuan public speaking.'),
(74, 74, 'tidak hadir', '', ''),
(75, 75, 'hadir', '84', 'Latihan yang baik tetapi perbaiki pengaturan tempo dan manajemen waktu. Latihan presentasi dengan alat bantu visual dapat meningkatkan presentasi.'),
(76, 76, 'hadir', '', ''),
(77, 77, '', '', ''),
(78, 78, 'hadir', '', ''),
(79, 79, 'hadir', '82', 'bagus'),
(80, 80, '', '', ''),
(82, 82, '', '', ''),
(83, 85, '', '', ''),
(84, 86, 'hadir', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_keuangan`
--

CREATE TABLE `tbl_keuangan` (
  `id_keuangan` int(11) NOT NULL,
  `id_pelatihan` int(11) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `deskripsi` text NOT NULL,
  `kategori_transaksi` varchar(20) NOT NULL,
  `jml_transaksi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_keuangan`
--

INSERT INTO `tbl_keuangan` (`id_keuangan`, `id_pelatihan`, `tgl_transaksi`, `deskripsi`, `kategori_transaksi`, `jml_transaksi`) VALUES
(1, 10, '2024-07-30', 'Pembayaran Trainer dari pihak Universitas Sari Mulia', 'pendapatan', 1500000),
(2, 10, '2024-09-07', 'Fee Trainer a.n. Nisrina Nuraini', 'pengeluaran', 1000000),
(3, 10, '2024-08-03', 'Konsumsi trainer', 'pengeluaran', 55000),
(4, 7, '2024-07-03', 'Sewa workshop room WLS', 'pengeluaran', 550000),
(5, 7, '2024-07-15', 'Bantuan dana dari yayasan', 'pendapatan', 2000000),
(6, 7, '2024-07-09', 'Instagram ads', 'pengeluaran', 150000),
(7, 7, '2024-07-31', 'Konsumsi untuk peserta (snack)', 'pengeluaran', 390000),
(8, 7, '2024-08-07', 'Konsumsi untuk trainer (nasi kotak bunda)', 'pengeluaran', 47000),
(9, 7, '2024-08-10', 'Fee Trainer a.n. Zain Mahbuby', 'pengeluaran', 500000),
(10, 9, '2024-07-14', 'Beli Zoom premium', 'pengeluaran', 100000),
(11, 9, '2024-08-11', 'Fee Trainer a.n Muhammad Arif Rahman', 'pengeluaran', 450000),
(12, 6, '2024-07-29', 'Bantuan biaya dari IPP', 'pengeluaran', 3000000),
(13, 6, '2024-07-08', 'Sewa multipurpose hall WLS + 30 bangku tambahan ', 'pengeluaran', 6550000),
(14, 6, '2024-07-15', 'Dana dari yayasan', 'pendapatan', 2000000),
(15, 6, '2024-08-02', 'Konsumsi untuk peserta dan panitia', 'pengeluaran', 1800000),
(16, 6, '2024-08-02', 'Snack & minuman untuk coffee break', 'pengeluaran', 400000),
(17, 6, '2024-08-09', 'Konsumsi untuk trainer (nasi kotak rumah makan bunda)', 'pengeluaran', 48000),
(18, 6, '2024-08-06', 'Perlengkapan event (atk, karton, dll)', 'pengeluaran', 640000),
(19, 6, '2024-07-16', 'Biaya promosi (instagram adds)', 'pengeluaran', 200000),
(20, 6, '2024-08-12', 'Fee trainer a.n Rivaldy', 'pengeluaran', 750000),
(21, 1, '2024-07-10', 'Sewa workshop room WLS ', 'pengeluaran', 550000),
(22, 1, '2024-08-03', 'Konsumsi untuk peserta (30 snack di vendor A)', 'pengeluaran', 300000),
(23, 1, '2024-08-10', 'Konsumsi untuk trainer (1 kotak nasi ayam dari warung makan bunda)', 'pengeluaran', 48000),
(24, 1, '2024-08-13', 'Fee trainer a.n. Widya Wardhanie + admin (2.500)', 'pengeluaran', 1002500),
(25, 3, '2024-07-08', 'Sewa ruangan di DEKORAMA ', 'pengeluaran', 2700000),
(26, 3, '2024-07-01', 'Sponsorship wardah', 'pendapatan', 500000),
(27, 3, '2024-07-15', 'Sponsorship Jims Honey', 'pendapatan', 800000),
(28, 3, '2024-07-17', 'Biaya promosi (instagram adds)', 'pengeluaran', 150000),
(29, 3, '2024-08-15', 'Keperluan acara (atk, kertas hvs 1 rim, id card, tinta dll)', 'pengeluaran', 800000),
(30, 3, '2024-07-25', 'Sponsorship Lumiere ', 'pendapatan', 1500000),
(31, 3, '2024-08-15', 'Konsumsi untuk peserta & panitia (85 kotak makanan dari vendor B)', 'pengeluaran', 1275000),
(32, 3, '2024-08-20', 'Snack coffee break', 'pengeluaran', 470000),
(33, 3, '2024-08-22', 'Konsumsi untuk trainer (1 kotak nasi ayam warung makan bunda)', 'pengeluaran', 45000),
(34, 3, '2024-08-26', 'Fee trainer a.n. Rojihah + admin (2.500)', 'pengeluaran', 682500),
(35, 8, '2024-08-19', 'Pembayaran trainer dari pihak STIE Pancasetia', 'pendapatan', 1500000),
(36, 8, '2024-08-28', 'Fee trainer a.n. Nisrina Nuraini', 'pengeluaran', 500000),
(37, 8, '2024-08-25', 'Konsumsi untuk trainer (1 kotak nasi ayam warung makan bunda)', 'pengeluaran', 45000),
(38, 4, '2024-08-01', 'Beli zoom premium', 'pengeluaran', 100000),
(39, 4, '2024-09-02', 'Fee trainer a.n. Akhmad Nurfidh + admin (2.500)', 'pengeluaran', 552500),
(40, 2, '2024-08-14', 'Beli zoom premium ', 'pengeluaran', 100000),
(41, 2, '2024-09-03', 'Fee trainer a.n. Lani Wardani + admin (2.500)', 'pengeluaran', 802500),
(42, 5, '2024-08-01', 'Sewa workshop room WLS ', 'pengeluaran', 550000),
(43, 1, '2024-08-09', 'Perlengkapan event (atk)', 'pengeluaran', 230000),
(44, 5, '2024-08-30', 'Pelengkapan event (atk)', 'pengeluaran', 200000),
(45, 5, '2024-08-24', 'Konsumsi untuk peserta (35 kotak snack di vendor A)', 'pengeluaran', 350000),
(46, 5, '2024-08-31', 'Konsumsi untuk trainer (1 kotak nasi ayam dari warung makan bunda)', 'pengeluaran', 48000),
(47, 5, '2024-09-04', 'Fee trainer a.n. Adi Febrian Rahman', 'pengeluaran', 800000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pelatihan`
--

CREATE TABLE `tbl_pelatihan` (
  `id_pelatihan` int(11) NOT NULL,
  `id_trainer` int(11) NOT NULL,
  `tgl_pelatihan` date NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `nama_pelatihan` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `harga` int(255) NOT NULL,
  `jml_peserta` int(100) NOT NULL,
  `kategori_program` varchar(255) NOT NULL,
  `mitra` varchar(255) NOT NULL,
  `tipe_kegiatan` varchar(255) NOT NULL,
  `status_kegiatan` varchar(255) NOT NULL,
  `pelaksanaan` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `link_grub` varchar(255) NOT NULL,
  `materi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_pelatihan`
--

INSERT INTO `tbl_pelatihan` (`id_pelatihan`, `id_trainer`, `tgl_pelatihan`, `waktu`, `nama_pelatihan`, `deskripsi`, `tempat`, `harga`, `jml_peserta`, `kategori_program`, `mitra`, `tipe_kegiatan`, `status_kegiatan`, `pelaksanaan`, `poster`, `link_grub`, `materi`) VALUES
(1, 1, '2024-08-10', '09.00 - 13.00 WITA', 'MC On Stage', 'MC on Stage kali ini akan diadakan secara lebih private dengan coaching dan mentoring diri kamu biar naikin level MC mu!', 'Wetland Square', 150000, 20, 'level up', '-', 'eksternal', 'on going', 'offline', 'Screenshot 2024-08-12 143917.png', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'Naikin Level .pdf'),
(2, 2, '2024-08-30', '20.00 - 21.00 WITA', 'Public Speaking', 'Level Up Public Speaking kembali lagi, kali ini BCTI Bersama Kak Lani Wardana, CPSP mengajak kalian untuk Belajar lebih banyak lagi tentang public speaking. Dari A sampai Z, bikin pondasi bicaramu lebih Powerfull!!', 'Zoom Meeting', 50000, 50, 'level up', '-', 'eksternal', 'on going', 'online', 'Screenshot 2024-08-12 145135.png', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'pdf_20230526_054718_0000.pdf'),
(3, 3, '2024-08-22', '09.00 - 18.00 WITA', 'Woman Sheroes', 'Calling all women, come and be a part of Woman Sheroes 🌷🎀\r\n\r\nBCTI has collaboration with Fun Loving Friends to bring you this bootcamp exclusively for women. We have a variety of exciting activities for grow and shine.', 'DEKORAMA', 180000, 75, 'bootcamp', ' Fun Loving Friends', 'eksternal', 'on going', 'offline', 'Screenshot 2024-08-12 150311.png', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'pdf_20230526_054718_0000.pdf'),
(4, 4, '2024-08-29', '20.00 - 22.00 WITA', 'Personal Branding', 'Ada yang ngerasa karirnya stuck atau udah nyoba ngelamar kerja sana sini tapi masih belum dilirik juga?\r\n\r\nHmmmm, mungkin ini saat yang tepat buat kamu bangun Personal Branding yang bisa bantu kamu wujudkan karir impianmu?\r\n\r\nExtrovert atau introvert ga jadi masalah, semua orang mampu bangun Personal Brandingnya sendiri!', 'Zoom Meeting', 50000, 25, 'level up', '-', 'eksternal', 'on going', 'online', 'lu-personalbranding.png', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'Naikin Level .pdf'),
(5, 5, '2024-08-31', '14.30 - 18.30 WITA', 'MC On Stage Vol.2', 'Level Up: Communication Series!\r\nBCTI menghadirkan MC ON STAGE, pelatihan MC yang dirancang khusus untuk membantumu menjadi MC handal dan profesional.', 'Wetland Square', 75000, 25, 'level up', '-', 'eksternal', 'on going', 'offline', 'lu-mc.png', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'Naikin Level .pdf'),
(6, 6, '2024-08-09', '08.00 - 20.00 WITA', 'Squid Camp', 'BCTI berkolaborasi dengan KEMENPORA RI untuk membantu para pemuda dalam mengembangkan potensi dalam dirinya.', 'Wetland Square', 100000, 100, 'bootcamp', 'Indeks Pembangunan Pemuda', 'eksternal', 'done', 'offline', 'Screenshot 2024-08-04 200631.png', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'pdf_20230526_054718_0000.pdf'),
(7, 7, '2024-08-07', '14.00 - 17.00 WITA', 'Youth Leader Gathering', 'Are you ready to become a brilliant leader ??\r\n\r\nKeberlangsungan organisasi tidak lepas dari peran seorang Leaders, hambatan dan masalah kerap kali menjadi sebuah tantangan.\r\nSudahkah kalian menjadi sosok yang sigap dalam menghadapi tantangan kepemimpinan?\r\n\r\nBersama BCTI melalui Youth Leaders Gathering, persiapkan dirimu menjadi pemimpin masa depan✨👋🏻\r\n', 'Wetland Square', 50000, 39, 'ap', '-', 'eksternal', 'done', 'offline', 'Screenshot 2024-08-04 201709.png', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'Naikin Level .pdf'),
(8, 8, '2024-08-25', '14.00 WITA', 'Public Speaking For Collage Vol 2', 'BCTI GOES TO CAMPUS! \r\n\r\nOutline Materi:\r\n* Pentingnya soft skill bagi mahasiswa\r\n* Pentingnya kemampuan public speaking\r\n* Teknik Dasar Public Speaking\r\n* Public Speaking yang menarik perhatian audiens.\r\n* Berinteraksi dengan Audiens', 'STIE Pancasetia', 50000, 107, 'psc', 'STIE Pancasetia', 'eksternal', 'on going', 'offline', 'WhatsApp Image 2024-08-12 at 14.29.17.jpeg', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'FCC86027-E633-48BE-91C7-11483A93BA5A.pdf'),
(9, 9, '2024-08-08', '20.00 - 22.00 WITA', 'CV Breakdown', 'Mau ikut MSIB tapi bingung gimana cara bikin CV yang bagus🤔?\r\n\r\nBersama HR dari Yayasan Hasnur Centre (Mitra MSIB di Kalimantan Selatan), Kak Muhammad Arif Rahman, kita akan membahas tuntas mengenai CV yang baik🤩\r\n\r\nDalam Pelatihan ini, kami mendonasikan sepenuhnya biaya pendaftaran yang diberikan oleh peserta secara sukarela kepada UPZ Bakti Banua untuk disalurkan kepada masyarakat yang terkena musibah atas isu-isu kemanuasiaan, masyarakat kurang mampu, dll.', 'Zoom Meeting', 30000, 47, 'psc', 'UPZ Bakti Bersama', 'eksternal', 'done', 'online', 'Screenshot 2024-05-31 193246.png', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'pdf_20230526_054718_0000.pdf'),
(10, 8, '2024-08-03', '08.30 - 12.00 WITA', 'Public Speaking For Collage', 'Pelatihan ini dirancang untuk membantu mahasiswa mengasah kemampuan public speaking mereka. Melalui pelatihan ini, kamu akan belajar teknik dasar public speaking, cara mengatasi rasa gugup, hingga bagaimana caranya menarik perhatian audiens. Jadi, siap untuk menjadi pembicara yang lebih percaya diri?', 'Aula 1 Universitas Sari Mulia', 30000, 50, 'psc', 'Universitas Sari Mulia', 'eksternal', 'done', 'offline', 'WhatsApp Image 2024-08-12 at 14.29.16.jpeg', 'https://chat.whatsapp.com/BYsJqEnGIvAJ3uFEvw1JBS', 'FCC86027-E633-48BE-91C7-11483A93BA5A.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pendaftaran`
--

CREATE TABLE `tbl_pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_pelatihan` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `tgl_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `metode_pembayaran` varchar(255) NOT NULL,
  `jml_pembayaran` int(100) NOT NULL,
  `bukpem` varchar(255) NOT NULL,
  `status_pembayaran` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `kelas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_pendaftaran`
--

INSERT INTO `tbl_pendaftaran` (`id_pendaftaran`, `id_pelatihan`, `id_peserta`, `tgl_daftar`, `metode_pembayaran`, `jml_pembayaran`, `bukpem`, `status_pembayaran`, `keterangan`, `kelas`) VALUES
(1, 7, 1, '2024-08-12 14:07:40', 'tf', 50000, 'bukti_transfer__1689268347_030b194e_progressive.jpg', 'confirmed', '', 'Kelas A'),
(2, 1, 1, '2024-08-12 14:13:51', 'cash', 150000, 'Screenshot 2024-08-12 143917.png', 'confirmed', '', 'Kelas A'),
(3, 8, 1, '2024-08-12 14:14:35', 'tf', 50000, 'bukti_transfer__1689268347_030b194e_progressive.jpg', 'confirmed', '', 'Kelas A'),
(4, 4, 1, '2024-08-12 14:15:12', 'cash', 50000, 'Screenshot 2024-08-12 151318.png', 'confirmed', '', 'Kelas A'),
(5, 3, 1, '2024-08-12 14:15:37', 'tf', 180000, 'bukti_transfer__1689268347_030b194e_progressive.jpg', 'confirmed', '', 'Kelas A'),
(6, 10, 2, '2024-08-12 14:19:31', 'cash', 30000, 'WhatsApp Image 2024-08-12 at 14.29.16.jpeg', 'confirmed', '', 'Kelas A'),
(7, 9, 2, '2024-08-12 14:21:57', 'tf', 30000, '68eddcea02ceb29abde1b1c752fa29eb.jpg', 'confirmed', '', 'Kelas A'),
(8, 6, 2, '2024-08-12 14:22:25', 'cash', 100000, 'Screenshot 2024-08-04 200631.png', 'confirmed', '', 'Kelas A'),
(9, 5, 2, '2024-08-12 14:22:49', 'tf', 75000, '68eddcea02ceb29abde1b1c752fa29eb.jpg', 'confirmed', '', 'Kelas A'),
(10, 10, 3, '2024-08-12 14:34:06', 'cash', 30000, 'WhatsApp Image 2024-08-12 at 14.29.16.jpeg', 'confirmed', '', 'Kelas A'),
(11, 7, 3, '2024-08-12 14:34:48', 'tf', 50000, 'd63ce8e6ce72a6b55b0c78126e4136ab.jpg', 'confirmed', '', 'Kelas A'),
(12, 3, 3, '2024-08-12 14:35:11', 'cash', 180000, 'Screenshot 2024-08-12 150311.png', 'confirmed', '', 'Kelas A'),
(13, 8, 3, '2024-08-12 14:35:28', 'tf', 50000, 'd63ce8e6ce72a6b55b0c78126e4136ab.jpg', 'confirmed', '', 'Kelas A'),
(14, 2, 3, '2024-08-12 14:35:49', 'cash', 50000, 'Screenshot 2024-08-12 145135.png', 'confirmed', '', 'Kelas A'),
(15, 10, 4, '2024-08-12 14:40:49', 'tf', 30000, 'a0925f57a6685ebcaee32a698ba52e6d.jpg', 'confirmed', '', 'Kelas A'),
(16, 1, 4, '2024-08-12 14:41:17', 'cash', 150000, 'Screenshot 2024-08-12 143917.png', 'confirmed', '', 'Kelas A'),
(17, 6, 4, '2024-08-12 14:41:47', 'tf', 100000, 'a0925f57a6685ebcaee32a698ba52e6d.jpg', 'confirmed', '', 'Kelas A'),
(18, 7, 5, '2024-08-12 14:44:49', 'cash', 50000, 'Screenshot 2024-08-04 201709.png', 'confirmed', '', 'Kelas A'),
(19, 9, 5, '2024-08-12 14:45:32', 'tf', 30000, '4254c1d2bed6630fb28c3a68b1d72878.jpg', 'confirmed', '', 'Kelas A'),
(20, 8, 5, '2024-08-12 14:45:47', 'cash', 50000, 'WhatsApp Image 2024-08-12 at 14.29.17 (1).jpeg', 'confirmed', '', 'Kelas A'),
(21, 2, 5, '2024-08-12 14:46:22', 'tf', 50000, '4254c1d2bed6630fb28c3a68b1d72878.jpg', 'confirmed', '', 'Kelas A'),
(22, 1, 6, '2024-08-12 14:47:48', 'cash', 150000, 'Screenshot 2024-08-12 143917.png', 'confirmed', '', 'Kelas A'),
(23, 3, 6, '2024-08-12 14:48:16', 'tf', 180000, '8ad3f214246515a2d66a3b159ab6cdfd.jpg', 'confirmed', '', 'Kelas A'),
(24, 10, 6, '2024-08-12 14:48:34', 'cash', 30000, 'WhatsApp Image 2024-08-12 at 14.29.16.jpeg', 'confirmed', '', 'Kelas A'),
(25, 4, 6, '2024-08-12 14:48:46', 'tf', 50000, '8ad3f214246515a2d66a3b159ab6cdfd.jpg', 'confirmed', '', 'Kelas A'),
(26, 6, 7, '2024-08-12 14:50:27', 'cash', 100000, 'Screenshot 2024-08-04 200631.png', 'confirmed', '', 'Kelas A'),
(27, 5, 7, '2024-08-12 14:51:00', 'tf', 75000, 'e909c6467602f659a6c67a0e16ada573.jpg', 'confirmed', '', 'Kelas A'),
(28, 8, 7, '2024-08-12 14:51:23', 'tf', 50000, 'e909c6467602f659a6c67a0e16ada573.jpg', 'confirmed', '', 'Kelas A'),
(29, 2, 7, '2024-08-12 14:52:06', 'cash', 50000, 'Screenshot 2024-08-12 145135.png', 'confirmed', '', 'Kelas A'),
(30, 4, 7, '2024-08-12 14:52:19', 'tf', 50000, 'e909c6467602f659a6c67a0e16ada573.jpg', 'confirmed', '', 'Kelas A'),
(31, 5, 1, '2024-08-12 14:53:01', 'cash', 75000, 'lu-mc.png', 'confirmed', '', 'Kelas A'),
(32, 5, 4, '2024-08-12 14:53:28', 'tf', 75000, '8ad3f214246515a2d66a3b159ab6cdfd.jpg', 'confirmed', '', 'Kelas A'),
(33, 5, 3, '2024-08-12 14:53:49', 'tf', 75000, 'a0925f57a6685ebcaee32a698ba52e6d.jpg', 'confirmed', '', 'Kelas A'),
(34, 5, 5, '2024-08-12 14:54:26', 'tf', 75000, '8ad3f214246515a2d66a3b159ab6cdfd.jpg', 'confirmed', '', 'Kelas A'),
(35, 5, 6, '2024-08-12 14:55:18', 'cash', 75000, 'lu-mc.png', 'confirmed', '', 'Kelas A'),
(36, 8, 6, '2024-08-12 14:56:51', 'tf', 50000, 'e909c6467602f659a6c67a0e16ada573.jpg', 'confirmed', '', 'Kelas A'),
(37, 2, 6, '2024-08-12 14:57:07', 'cash', 50000, 'Screenshot 2024-08-12 145135.png', 'confirmed', '', 'Kelas A'),
(38, 9, 8, '2024-08-12 15:00:06', 'cash', 30000, 'Screenshot 2024-05-31 193246.png', 'confirmed', '', 'Kelas A'),
(39, 10, 8, '2024-08-12 15:00:40', 'tf', 30000, '198b9c740074de5da01d792881d5c562.jpg', 'confirmed', '', 'Kelas A'),
(40, 7, 8, '2024-08-12 15:00:59', 'tf', 50000, '198b9c740074de5da01d792881d5c562.jpg', 'confirmed', '', 'Kelas A'),
(41, 6, 8, '2024-08-12 15:01:24', 'cash', 100000, 'Screenshot 2024-08-04 200631.png', 'confirmed', '', 'Kelas A'),
(42, 5, 9, '2024-08-12 15:03:11', 'tf', 75000, 'da24d1a83d9d94ca162daf6710edc425.jpg', 'confirmed', '', 'Kelas A'),
(43, 3, 9, '2024-08-12 15:03:57', 'tf', 180000, 'da24d1a83d9d94ca162daf6710edc425.jpg', 'confirmed', '', 'Kelas A'),
(44, 10, 9, '2024-08-12 15:04:11', 'cash', 30000, 'WhatsApp Image 2024-08-12 at 14.29.16.jpeg', 'confirmed', '', 'Kelas A'),
(45, 4, 9, '2024-08-12 15:04:22', 'tf', 50000, 'da24d1a83d9d94ca162daf6710edc425.jpg', 'confirmed', '', 'Kelas A'),
(46, 2, 9, '2024-08-12 15:04:37', 'cash', 50000, 'Screenshot 2024-08-12 145135.png', 'confirmed', '', 'Kelas A'),
(47, 5, 8, '2024-08-12 15:05:03', 'cash', 75000, 'lu-mc.png', 'confirmed', '', 'Kelas A'),
(48, 5, 10, '2024-08-12 15:08:21', 'cash', 75000, 'lu-mc.png', 'confirmed', '', 'Kelas A'),
(49, 7, 10, '2024-08-12 15:08:44', 'tf', 50000, 'a08d29ddca83b39863495e57258fe0c3.jpg', 'confirmed', '', 'Kelas A'),
(50, 1, 10, '2024-08-12 15:09:03', 'tf', 150000, 'a08d29ddca83b39863495e57258fe0c3.jpg', 'confirmed', '', 'Kelas A'),
(51, 6, 10, '2024-08-12 15:09:17', 'tf', 100000, 'a08d29ddca83b39863495e57258fe0c3.jpg', 'confirmed', '', 'Kelas A'),
(52, 8, 10, '2024-08-12 15:09:29', 'tf', 50000, 'a08d29ddca83b39863495e57258fe0c3.jpg', 'confirmed', '', 'Kelas A'),
(53, 9, 11, '2024-08-12 15:19:20', 'tf', 30000, '2a3428ec0bc5034d3a3314041379401e.jpg', 'confirmed', '', 'Kelas A'),
(54, 2, 11, '2024-08-12 15:27:07', 'tf', 50000, '2a3428ec0bc5034d3a3314041379401e.jpg', 'confirmed', '', 'Kelas A'),
(55, 6, 11, '2024-08-12 15:28:40', 'tf', 100000, '2a3428ec0bc5034d3a3314041379401e.jpg', 'confirmed', '', 'Kelas A'),
(56, 7, 11, '2024-08-12 15:29:12', 'cash', 50000, 'Screenshot 2024-08-04 201709.png', 'confirmed', '', 'Kelas A'),
(57, 4, 11, '2024-08-12 15:29:26', 'cash', 50000, 'lu-personalbranding.png', 'confirmed', '', 'Kelas A'),
(58, 10, 11, '2024-08-12 15:30:30', 'tf', 30000, '2a3428ec0bc5034d3a3314041379401e.jpg', 'confirmed', '', 'Kelas A'),
(59, 3, 12, '2024-08-12 15:35:08', 'cash', 180000, 'Screenshot 2024-08-12 150311.png', 'confirmed', '', 'Kelas A'),
(60, 9, 12, '2024-08-12 15:35:27', 'cash', 30000, 'Screenshot 2024-05-31 193246.png', 'confirmed', '', 'Kelas A'),
(61, 10, 12, '2024-08-12 15:37:22', 'tf', 30000, 'a0925f57a6685ebcaee32a698ba52e6d.jpg', 'confirmed', '', 'Kelas A'),
(62, 7, 12, '2024-08-12 15:38:20', 'cash', 50000, 'Screenshot 2024-08-04 201709.png', 'confirmed', '', 'Kelas A'),
(63, 8, 12, '2024-08-12 15:39:10', 'cash', 50000, 'WhatsApp Image 2024-08-12 at 14.29.17 (1).jpeg', 'confirmed', '', 'Kelas A'),
(64, 2, 12, '2024-08-12 15:40:05', 'tf', 50000, '2fa0ca731e6150566c8610a1e81e115d.jpg', 'confirmed', '', 'Kelas A'),
(65, 4, 12, '2024-08-12 15:41:04', 'tf', 50000, '2fa0ca731e6150566c8610a1e81e115d.jpg', 'confirmed', '', 'Kelas A'),
(66, 9, 1, '2024-08-12 15:42:01', 'tf', 30000, '2fa0ca731e6150566c8610a1e81e115d.jpg', 'confirmed', '', 'Kelas A'),
(67, 2, 1, '2024-08-12 15:42:23', 'tf', 50000, '2fa0ca731e6150566c8610a1e81e115d.jpg', 'confirmed', '', 'Kelas A'),
(68, 10, 1, '2024-08-12 15:43:09', 'tf', 30000, '2fa0ca731e6150566c8610a1e81e115d.jpg', 'confirmed', '', 'Kelas A'),
(69, 9, 13, '2024-08-12 15:45:47', 'tf', 30000, 'd63ce8e6ce72a6b55b0c78126e4136ab.jpg', 'confirmed', '', 'Kelas A'),
(70, 1, 13, '2024-08-12 15:46:15', 'tf', 150000, 'da24d1a83d9d94ca162daf6710edc425.jpg', 'confirmed', '', 'Kelas A'),
(71, 10, 13, '2024-08-12 15:47:04', 'tf', 30000, 'e909c6467602f659a6c67a0e16ada573.jpg', 'confirmed', '', 'Kelas A'),
(72, 5, 13, '2024-08-12 15:47:31', 'tf', 75000, 'd63ce8e6ce72a6b55b0c78126e4136ab.jpg', 'confirmed', '', 'Kelas B'),
(73, 2, 13, '2024-08-12 15:48:06', 'tf', 50000, '68eddcea02ceb29abde1b1c752fa29eb.jpg', 'confirmed', '', 'Kelas A'),
(74, 6, 13, '2024-08-12 15:48:43', 'tf', 100000, '68eddcea02ceb29abde1b1c752fa29eb.jpg', 'confirmed', '', 'Kelas A'),
(75, 3, 7, '2024-08-12 15:50:23', 'tf', 180000, 'da24d1a83d9d94ca162daf6710edc425.jpg', 'confirmed', '', 'Kelas A'),
(76, 5, 14, '2024-08-15 09:21:42', 'cash', 75000, '2fa0ca731e6150566c8610a1e81e115d.jpg', 'confirmed', '', 'Kelas B'),
(77, 2, 14, '2024-08-15 09:30:59', 'cash', 50000, '4254c1d2bed6630fb28c3a68b1d72878.jpg', '', 'g', 'Kelas A'),
(78, 3, 14, '2024-08-26 03:59:24', 'tf', 180000, 'bukti tf sidang skripsi alya fakhraini.jpeg', 'confirmed', '', 'Kelas A'),
(79, 8, 14, '2024-08-26 04:14:27', 'tf', 50000, 'bukti tf sidang skripsi alya fakhraini.jpeg', 'confirmed', '', 'Kelas A'),
(80, 1, 2, '2024-09-06 06:54:12', 'tf', 150000, '198b9c740074de5da01d792881d5c562.jpg', '', '', 'Kelas A'),
(82, 5, 11, '2024-09-07 07:39:33', 'tf', 75000, '4254c1d2bed6630fb28c3a68b1d72878.jpg', 'confirmed', '', 'Kelas B'),
(85, 5, 15, '2024-09-19 10:00:45', 'tf', 75000, 'class of.png', '', '', 'Kelas B'),
(86, 2, 15, '2024-09-19 10:03:03', 'tf', 50000, 'foto alya.png', 'confirmed', '', 'Kelas B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengaduan`
--

CREATE TABLE `tbl_pengaduan` (
  `id_pengaduan` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `tgl_pengaduan` timestamp NOT NULL DEFAULT current_timestamp(),
  `isi_pengaduan` text NOT NULL,
  `status_pengaduan` varchar(255) NOT NULL,
  `tanggapan_admin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_pengaduan`
--

INSERT INTO `tbl_pengaduan` (`id_pengaduan`, `id_peserta`, `tgl_pengaduan`, `isi_pengaduan`, `status_pengaduan`, `tanggapan_admin`) VALUES
(1, 7, '2024-08-13 12:55:54', 'File materi untukLevel Up : Public Speaking tidak tersedia di platform, padahal saya hadir', 'done', 'Kami mohon maaf atas ketidaknyamanan ini. Materi untuk sesi Level Up: Public Speaking telah kami unggah ke platform. Silakan cek kembali di bagian materi. Jika masih ada masalah, harap hubungi kami.'),
(2, 7, '2024-08-13 12:56:58', 'file Bootcamp : Squid Camp pre-test & post-test belum muncul', 'done', 'Kami telah memperbaiki masalah ini, dan file pre-test & post-test kini sudah tersedia di platform. Mohon cek kembali dan selesaikan test yang diperlukan.'),
(3, 1, '2024-08-13 12:59:12', 'saya tidak bisa mengubah username', 'done', 'Terima kasih telah menghubungi kami. Masalah pengubahan username telah kami atasi. Silakan coba lagi sekarang, dan jika masih ada kendala, harap laporkan kepada kami.'),
(4, 1, '2024-08-13 13:00:55', 'setiap saya mengisi form pendaftaran, pasti website nya jadi 404', 'done', 'Kami mohon maaf atas masalah ini. Tim teknis kami sedang memperbaiki masalah 404 pada form pendaftaran. Kami akan menghubungi Anda segera setelah masalah ini terselesaikan.'),
(5, 1, '2024-08-13 13:03:26', 'materi woman sheroes tidak bisa dibuka', 'done', 'Materi Woman Sheroes kini telah diperbaiki dan dapat diakses kembali. Silakan coba membuka materi tersebut, dan jika ada kendala lain, jangan ragu untuk menghubungi kami.'),
(6, 2, '2024-08-13 13:04:52', 'form pendaftaran sudah ditutup padahal saya baru saja membayarnya tapi belum sempat mengisi form pendaftaran', 'done', 'Kami akan memeriksa pembayaran Anda dan membuka kembali akses ke form pendaftaran. Harap tunggu beberapa saat, dan Anda akan diberitahu segera setelah masalah ini diperbaiki.'),
(7, 2, '2024-08-13 13:05:13', 'Saya tidak bisa mengakses aplikasi setelah update terbaru, aplikasi langsung menutup sendiri.', 'done', 'Kami menyarankan Anda untuk memperbarui aplikasi ke versi terbaru di App Store atau Play Store. Jika masalah masih berlanjut, silakan hubungi tim support kami dengan rincian lebih lanjut.'),
(8, 2, '2024-08-13 13:06:31', 'Terdapat masalah saat mengupload bukti pembayaran, selalu muncul pesan \"File tidak didukung\" meskipun formatnya sudah sesuai.\r\n\r\n', 'done', 'Kami mohon maaf atas ketidaknyamanan ini. Silakan coba upload bukti pembayaran dalam format JPG atau PNG. Jika masalah tetap terjadi, kirimkan bukti pembayaran melalui email ke support kami.'),
(9, 1, '2024-08-13 13:07:33', 'Status pendaftaran saya masih pending padahal pendaftaran sudah ditutup', 'done', 'Kami telah memperbarui status pendaftaran Anda. Silakan cek kembali status pendaftaran Anda di akun Anda.'),
(10, 1, '2024-08-13 13:09:00', 'Saya kesulitan mengubah informasi profil di aplikasi, selalu muncul pesan \"Perubahan tidak dapat disimpan.\"', 'done', 'Kami telah memperbaiki masalah ini, dan Anda sekarang dapat mengubah informasi profil Anda. Silakan coba lagi, dan hubungi kami jika masih ada kendala.'),
(11, 1, '2024-08-13 13:09:18', 'Aplikasi tidak bisa memuat halaman pembayaran, saya tidak bisa menyelesaikan transaksi untuk pendaftaran kursus.', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_peserta`
--

CREATE TABLE `tbl_peserta` (
  `id_peserta` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_peserta` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telp_peserta` varchar(15) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `domisili` varchar(255) NOT NULL,
  `status_peserta` varchar(255) NOT NULL,
  `komunitas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_peserta`
--

INSERT INTO `tbl_peserta` (`id_peserta`, `id_user`, `nama_peserta`, `email`, `telp_peserta`, `gender`, `domisili`, `status_peserta`, `komunitas`) VALUES
(1, 12, 'Alya Fakhraini', 'alyafakhraini10@gmail.com', '0812345678', 'pr', 'Banjarmasin', 'Mahasiswa', '-'),
(2, 13, 'Daniel Katamandara', 'alyafakhraini10@gmail.com', '0812345678', 'lk', 'Banjabaru', 'Mahasiswa', 'FT UNISKA'),
(3, 14, 'Nia Aprilliani', 'alyafakhraini10@gmail.com', '0812345678', 'pr', 'Banjarmasin', 'Mahasiswa', 'ULM'),
(4, 15, 'Mahardika Ranjana Nadaputra', 'alyafakhraini10@gmail.com', '0812345678', 'lk', 'Banjabaru', 'Mahasiswa', 'UNISKA'),
(5, 16, 'Johan Narendra', 'alyafakhraini10@gmail.com', '0812345678', 'lk', 'Banjarmasin', 'Mahasiswa', 'UNISKA'),
(6, 17, 'Hafizah Asyifa', 'alyafakhraini10@gmail.com', '0812345678', 'pr', 'Banjarmasin', 'Mahasiswa', 'FISIP UNISKA'),
(7, 18, 'Clarisya Uniarti Mulia', 'alyafakhraini10@gmail.com', '0812345678', 'pr', 'Banjarmasin', 'Mahasiswa', 'UNHAS'),
(8, 19, 'Haris Aditya', 'alyafakhraini10@gmail.com', '0812345678', 'lk', 'Banjabaru', 'Mahasiswa', 'UNISKA'),
(9, 20, 'Amanda Putri', 'alyafakhraini10@gmail.com', '0812345678', 'pr', 'Banjarmasin', 'Mahasiswa', 'ULM'),
(10, 21, 'Mikhael Raka Ardana', 'alyafakhraini10@gmail.com', '0812345678', 'lk', 'Banjabaru', 'Mahasiswa', 'FT UNISKA'),
(11, 22, 'Joshua Harsa', 'alyafakhraini10@gmail.com', '0812345678', 'lk', 'Banjarmasin', 'Mahasiswa', 'UNISKA'),
(12, 23, 'Mitha Alya Wardana', 'alyafakhraini10@gmail.com', '0812345678', 'pr', 'Banjarmasin', 'Mahasiswa', 'UNISKA'),
(13, 24, 'Awan Sagara', 'alyafakhraini10@gmail.com', '0812345678', 'lk', 'Banjarmasin', 'Mahasiswa', 'UNISKA'),
(14, 25, 'Raini', 'alyafakhraini10@gmail.com', '08123456789', 'pr', 'Banjarmasin', 'Mahasiswa', 'UNISKA'),
(15, 27, 'Nisrina Nuraini', 'alyafakhraini10@gmail.com', '8989808', 'pr', 'jidij', 'nhnj', 'hnhu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_posttest`
--

CREATE TABLE `tbl_posttest` (
  `id_jawaban_post` int(11) NOT NULL,
  `id_pelatihan` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `jawaban1` text NOT NULL,
  `jawaban2` text NOT NULL,
  `jawaban3` text NOT NULL,
  `jawaban4` varchar(255) NOT NULL,
  `jawaban5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_posttest`
--

INSERT INTO `tbl_posttest` (`id_jawaban_post`, `id_pelatihan`, `id_peserta`, `jawaban1`, `jawaban2`, `jawaban3`, `jawaban4`, `jawaban5`) VALUES
(1, 5, 1, '5', '5', '4', '4', '3'),
(2, 1, 1, '5', '4', '5', '5', '4'),
(3, 2, 15, '5', '4', '5', '4', '4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pretest`
--

CREATE TABLE `tbl_pretest` (
  `id_jawaban_pre` int(11) NOT NULL,
  `id_pelatihan` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `jawaban1` text NOT NULL,
  `jawaban2` text NOT NULL,
  `jawaban3` text NOT NULL,
  `jawaban4` varchar(255) NOT NULL,
  `jawaban5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_pretest`
--

INSERT INTO `tbl_pretest` (`id_jawaban_pre`, `id_pelatihan`, `id_peserta`, `jawaban1`, `jawaban2`, `jawaban3`, `jawaban4`, `jawaban5`) VALUES
(1, 5, 2, '2', '3', '1', '2', '3'),
(4, 5, 1, '4', '4', '1', '2', '2'),
(5, 1, 1, '2', '3', '4', '4', '2'),
(6, 2, 15, '2', '3', '2', '2', '3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_sertifikat`
--

CREATE TABLE `tbl_sertifikat` (
  `id_sertifikat` int(11) NOT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `id_pelatihan` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `no_sertif` varchar(255) NOT NULL,
  `tgl_terbit_sertif` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_sertifikat`
--

INSERT INTO `tbl_sertifikat` (`id_sertifikat`, `id_kehadiran`, `id_pelatihan`, `id_peserta`, `no_sertif`, `tgl_terbit_sertif`) VALUES
(1, 68, 10, 1, '001/BCTI/PSC/VIII/2024', '2024-08-03'),
(2, 6, 10, 2, '002/BCTI/PSC/VIII/2024', '2024-08-03'),
(3, 24, 10, 6, '003/BCTI/PSC/VIII/2024', '2024-08-03'),
(4, 39, 10, 8, '004/BCTI/PSC/VIII/2024', '2024-08-03'),
(5, 44, 10, 9, '005/BCTI/PSC/VIII/2024', '2024-08-03'),
(6, 58, 10, 11, '006/BCTI/PSC/VIII/2024', '2024-08-03'),
(7, 61, 10, 12, '007/BCTI/PSC/VIII/2024', '2024-08-03'),
(8, 71, 10, 13, '008/BCTI/PSC/VIII/2024', '2024-08-03'),
(9, 1, 7, 1, '001/BCTI/AC/VIII/2024', '2024-08-07'),
(10, 11, 7, 3, '002/BCTI/AC/VIII/2024', '2024-08-07'),
(11, 18, 7, 5, '003/BCTI/AC/VIII/2024', '2024-08-07'),
(12, 40, 7, 8, '004/BCTI/AC/VIII/2024', '2024-08-07'),
(13, 62, 7, 12, '005/BCTI/AC/VIII/2024', '2024-08-07'),
(14, 7, 9, 2, '019/BCTI/PSC/VIII/2024', '2024-08-08'),
(15, 38, 9, 8, '020/BCTI/PSC/VIII/2024', '2024-08-08'),
(16, 53, 9, 11, '021/BCTI/PSC/VIII/2024', '2024-08-08'),
(17, 60, 9, 12, '022/BCTI/PSC/VIII/2024', '2024-08-08'),
(18, 69, 9, 13, '023/BCTI/PSC/VIII/2024', '2024-08-08'),
(19, 8, 6, 2, '001/BCTI/BOOTCAMP/VIII/2024', '2024-08-09'),
(20, 17, 6, 4, '002/BCTI/BOOTCAMP/VIII/2024', '2024-08-09'),
(21, 26, 6, 7, '003/BCTI/BOOTCAMP/VIII/2024', '2024-08-09'),
(22, 41, 6, 8, '004/BCTI/BOOTCAMP/VIII/2024', '2024-08-09'),
(23, 51, 6, 10, '005/BCTI/BOOTCAMP/VIII/2024', '2024-08-09'),
(24, 55, 6, 11, '006/BCTI/BOOTCAMP/VIII/2024', '2024-08-09'),
(25, 2, 1, 1, '001/BCTI/LU/VIII/2024', '2024-08-10'),
(26, 16, 1, 4, '002/BCTI/LU/VIII/2024', '2024-08-10'),
(27, 22, 1, 6, '003/BCTI/LU/VIII/2024', '2024-08-10'),
(28, 50, 1, 10, '004/BCTI/LU/VIII/2024', '2024-08-10'),
(29, 70, 1, 13, '005/BCTI/LU/VIII/2024', '2024-08-10'),
(30, 5, 3, 1, '016/BCTI/BOOTCAMP/VIII/2024', '2024-08-22'),
(31, 12, 3, 3, '017/BCTI/BOOTCAMP/VIII/2024', '2024-08-22'),
(32, 75, 3, 7, '018/BCTI/BOOTCAMP/VIII/2024', '2024-08-22'),
(33, 43, 3, 9, '019/BCTI/BOOTCAMP/VIII/2024', '2024-08-22'),
(34, 59, 3, 12, '020/BCTI/BOOTCAMP/VIII/2024', '2024-08-22'),
(35, 3, 8, 1, '033/BCTI/PSC/VIII/2024', '2024-08-25'),
(36, 13, 8, 3, '034/BCTI/PSC/VIII/2024', '2024-08-25'),
(37, 20, 8, 5, '035/BCTI/PSC/VIII/2024', '2024-08-25'),
(38, 28, 8, 7, '036/BCTI/PSC/VIII/2024', '2024-08-25'),
(39, 52, 8, 10, '037/BCTI/PSC/VIII/2024', '2024-08-25'),
(40, 63, 8, 12, '038/BCTI/PSC/VIII/2024', '2024-08-25'),
(41, 4, 4, 1, '015/BCTI/LU/VIII/2024', '2024-08-29'),
(42, 25, 4, 6, '016/BCTI/LU/VIII/2024', '2024-08-29'),
(43, 30, 4, 7, '017/BCTI/LU/VIII/2024', '2024-08-29'),
(44, 45, 4, 9, '018/BCTI/LU/VIII/2024', '2024-08-29'),
(45, 57, 4, 11, '019/BCTI/LU/VIII/2024', '2024-08-29'),
(46, 65, 4, 12, '020/BCTI/LU/VIII/2024', '2024-08-29'),
(47, 67, 2, 1, '030/BCTI/LU/VIII/2024', '2024-08-30'),
(48, 14, 2, 3, '031/BCTI/LU/VIII/2024', '2024-08-30'),
(49, 21, 2, 5, '032/BCTI/LU/VIII/2024', '2024-08-30'),
(50, 37, 2, 6, '033/BCTI/LU/VIII/2024', '2024-08-30'),
(51, 29, 2, 7, '034/BCTI/LU/VIII/2024', '2024-08-30'),
(52, 46, 2, 9, '035/BCTI/LU/VIII/2024', '2024-08-30'),
(53, 54, 2, 11, '036/BCTI/LU/VIII/2024', '2024-08-30'),
(54, 73, 2, 13, '037/BCTI/LU/VIII/2024', '2024-08-30'),
(55, 31, 5, 1, '038/BCTI/LU/VIII/2024', '2024-08-31'),
(56, 9, 5, 2, '039/BCTI/LU/VIII/2024', '2024-08-31'),
(57, 33, 5, 3, '040/BCTI/LU/VIII/2024', '2024-08-31'),
(58, 32, 5, 4, '041/BCTI/LU/VIII/2024', '2024-08-31'),
(59, 34, 5, 5, '042/BCTI/LU/VIII/2024', '2024-08-31'),
(60, 35, 5, 6, '043/BCTI/LU/VIII/2024', '2024-08-31'),
(61, 27, 5, 7, '044/BCTI/LU/VIII/2024', '2024-08-31'),
(62, 47, 5, 8, '045/BCTI/LU/VIII/2024', '2024-08-31'),
(63, 48, 5, 10, '046/BCTI/LU/VIII/2024', '2024-08-31'),
(64, 72, 5, 13, '047/BCTI/LU/VIII/2024', '2024-08-31'),
(65, 78, 3, 14, '', '0000-00-00'),
(66, 79, 8, 14, '', '0000-00-00'),
(67, 76, 5, 14, '048/BCTI/LU/VIII/2024', '2024-08-31'),
(68, 84, 2, 15, '', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_test`
--

CREATE TABLE `tbl_test` (
  `id_test` int(11) NOT NULL,
  `id_pelatihan` int(11) NOT NULL,
  `pertanyaan1` text NOT NULL,
  `pertanyaan2` text NOT NULL,
  `pertanyaan3` text NOT NULL,
  `pertanyaan4` text NOT NULL,
  `pertanyaan5` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_test`
--

INSERT INTO `tbl_test` (`id_test`, `id_pelatihan`, `pertanyaan1`, `pertanyaan2`, `pertanyaan3`, `pertanyaan4`, `pertanyaan5`) VALUES
(1, 5, 'Seberapa baik pemahamanmu tentang peran MC dalam sebuah acara?\r\n', 'Seberapa percaya diri kamu berbicara di depan umum?\r\n', 'Seberapa baik keterampilanmu dalam menjaga suasana acara tetap hidup sebagai MC?\r\n', 'Seberapa cepat kamu bisa beradaptasi dengan perubahan mendadak dalam acara?\r\n', 'Seberapa paham kamu dengan cara mengatasi rasa gugup saat menjadi MC?'),
(4, 2, 'Seberapa baik pemahamanmu tentang teknik dasar public speaking?', 'njevndvnwdlkvmwdlk', 'Seberapa baik keterampilanmu dalam menyampaikan pesan yang jelas dan meyakinkan?', 'Seberapa paham kamu tentang pentingnya body language dalam public speaking?', 'Seberapa sering kamu merasa gugup saat berbicara di depan audiens?'),
(6, 4, 'Seberapa jelas kamu memahami konsep Personal Branding?', 'Seberapa percaya diri kamu dalam memperkenalkan dirimu di lingkungan profesional?', 'Seberapa efektif kamu menggunakan media sosial untuk membangun Personal Branding?', 'Seberapa baik kamu menilai kemampuanmu dalam membuat konten yang mencerminkan keahlian dan nilai pribadi?', 'Seberapa sering kamu mengevaluasi dan memperbarui profil profesionalmu (seperti LinkedIn) untuk mencerminkan perkembangan karirmu?'),
(7, 8, 'Seberapa baik pemahamanmu tentang pentingnya public speaking bagi mahasiswa? ', 'Seberapa percaya diri kamu saat berbicara di depan umum?', 'Seberapa baik kamu menguasai teknik dasar public speaking?', 'Seberapa baik kamu mampu menarik perhatian audiens saat berbicara di depan umum? ', 'Seberapa baik kemampuanmu dalam berinteraksi dengan audiens saat presentasi atau public speaking?'),
(8, 3, 'Seberapa percaya diri kamu dalam mengembangkan potensi diri sebagai seorang wanita?', 'Seberapa sering kamu mengikuti kegiatan yang fokus pada pengembangan diri khusus untuk wanita?', 'Seberapa baik kamu mengenali kekuatan dan kemampuan unik yang kamu miliki sebagai seorang wanita? ', 'Seberapa aktif kamu dalam membangun jaringan (networking) dengan wanita-wanita lain untuk saling mendukung dalam pengembangan karir?', 'Seberapa besar kamu merasa kegiatan ini akan membantu pertumbuhan dan kesuksesan dirimu?'),
(9, 1, 'Seberapa percaya diri kamu saat menjadi MC di depan umum?', 'Seberapa baik kamu memahami peran dan tugas seorang MC?', 'Seberapa baik kamu dalam mengelola waktu dan alur acara saat menjadi MC?', 'Seberapa baik kemampuan kamu dalam berinteraksi dengan audiens saat menjadi MC?', 'Seberapa sering kamu mengevaluasi dan mengembangkan kemampuan MC-mu?'),
(10, 6, 'Seberapa baik kamu memahami potensi diri yang kamu miliki?', 'Seberapa percaya diri kamu dalam mengembangkan kemampuan dirimu di berbagai bidang?', 'Seberapa aktif kamu terlibat dalam kegiatan yang bertujuan untuk pengembangan diri?', 'Seberapa baik kamu dalam merencanakan langkah-langkah untuk mengembangkan karier atau potensi diri?', 'Seberapa besar kamu merasa program ini akan berdampak pada perkembangan dirimu?'),
(11, 9, 'Seberapa baik kamu memahami elemen-elemen yang penting dalam sebuah CV?', 'Seberapa percaya diri kamu dalam membuat CV yang menarik bagi HRD?', 'Seberapa sering kamu memperbarui dan menyesuaikan CV sesuai dengan pekerjaan yang dilamar?', 'Seberapa baik kamu memahami kesalahan umum yang harus dihindari saat membuat CV?', 'Seberapa besar kamu merasa bahwa pelatihan ini akan membantu kamu dalam membuat CV yang lebih efektif?'),
(12, 7, 'Seberapa baik kamu memahami peran dan tanggung jawab seorang pemimpin dalam sebuah organisasi?', 'Seberapa percaya diri kamu dalam mengambil keputusan sebagai pemimpin di situasi yang penuh tantangan?', 'Seberapa aktif kamu berkontribusi dalam memecahkan masalah di tim atau organisasi?', 'Seberapa baik kamu dalam membangun komunikasi dan kerjasama yang efektif dengan anggota tim sebagai seorang pemimpin?', 'Seberapa besar kamu merasa pelatihan ini akan meningkatkan kemampuan kepemimpinan kamu?'),
(13, 10, 'Seberapa percaya diri kamu saat berbicara di depan umum?', 'Seberapa baik kamu memahami teknik dasar dalam public speaking?', 'Seberapa sering kamu merasa gugup atau cemas saat berbicara di depan banyak orang?', 'Seberapa baik kamu mampu menarik perhatian audiens saat berbicara di depan umum?', 'Seberapa besar kamu merasa bahwa pelatihan ini akan membantu kamu dalam meningkatkan kemampuan public speaking?');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_trainer`
--

CREATE TABLE `tbl_trainer` (
  `id_trainer` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_trainer` varchar(255) NOT NULL,
  `keahlian` varchar(255) NOT NULL,
  `sertifikasi` varchar(255) NOT NULL,
  `npwp_trainer` int(20) NOT NULL,
  `fee_trainer` int(50) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `rekening` int(50) NOT NULL,
  `kontak_trainer` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_trainer`
--

INSERT INTO `tbl_trainer` (`id_trainer`, `id_user`, `nama_trainer`, `keahlian`, `sertifikasi`, `npwp_trainer`, `fee_trainer`, `bank`, `rekening`, `kontak_trainer`) VALUES
(1, 2, 'Widya Wardhanie', 'Public Speaking / Voice Over / MC', 'Praktisi', 123456789, 1000000, 'BNI', 123456789, '812345678'),
(2, 3, 'Lani Wardani', 'Public Speaking ', 'Praktisi Presenter TVRI Kalsel', 234567891, 850000, 'Bank Kalsel', 234567891, '8234567891'),
(3, 4, 'Rojihah', 'Psikolog', 'Akedemisi', 345678912, 500000, 'Mandiri', 345678912, '8345678912'),
(4, 5, 'Akhmad Nurfidh ', 'Personal Branding ', 'Praktisi 5+ Tahun', 456789123, 500000, 'BSI', 456789123, '8456789123'),
(5, 6, 'Adi Febrian Rahman', 'Voice Over, Penyiar Radio', 'Praktisi', 567891234, 700000, 'Mandiri', 567891234, '8567891234'),
(6, 7, 'Revaldy', 'Business Management', 'Praktisi', 678912345, 500000, 'Mandiri', 678912345, '8678912345'),
(7, 8, 'Muhammad Zain Mahbuby', 'Leadership', 'CETP, CLMA', 789123456, 500000, 'Mandiri', 789123456, '8789123456'),
(8, 9, 'Nisrina Nuraini', 'Public Speaking and Self Development', 'CPS', 891234567, 500000, 'BSI', 891234567, '8891234567'),
(9, 10, 'Muhammad Arif Rahman ', 'Bedah CV, Carrer planning, dan Interview Roleplay', 'Praktisi 5+ Tahun', 912345678, 500000, 'Mandiri', 912345678, '8912345678');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `level`, `profile`, `status`) VALUES
(1, 'admin', 'admin', 'admin', 'profile.png', 'aktif'),
(2, 'trainer1', 'trainer1', 'trainer', '', 'aktif'),
(3, 'trainer2', 'trainer2', 'trainer', '', 'aktif'),
(4, 'trainer3', 'trainer3', 'trainer', '', 'aktif'),
(5, 'trainer4', 'trainer4', 'trainer', '', 'aktif'),
(6, 'trainer5', 'trainer5', 'trainer', '', 'aktif'),
(7, 'trainer6', 'trainer6', 'trainer', '', 'aktif'),
(8, 'trainer7', 'trainer7', 'trainer', '', 'aktif'),
(9, 'trainer8', 'trainer8', 'trainer', '', 'aktif'),
(10, 'trainer9', 'trainer9', 'trainer', '', 'aktif'),
(11, 'staf1', 'staf1', 'panitia', '', 'aktif'),
(12, 'alya', 'alya', 'peserta', 'woman.png', 'aktif'),
(13, 'daniel', 'daniel', 'peserta', '', 'aktif'),
(14, 'nia', 'nia', 'peserta', '', 'aktif'),
(15, 'mahardika', 'dika', 'peserta', '', 'aktif'),
(16, 'johan', 'johan', 'peserta', '', 'aktif'),
(17, 'sipa', 'sipa', 'peserta', '', 'aktif'),
(18, 'ace', 'ace', 'peserta', '', 'aktif'),
(19, 'haris', 'haris', 'peserta', '', 'aktif'),
(20, 'manda', 'manda', 'peserta', '', 'aktif'),
(21, 'raka', 'raka', 'peserta', '', 'aktif'),
(22, 'joshua', 'joshua', 'peserta', '', 'aktif'),
(23, 'mitha', 'mitha', 'peserta', '', 'aktif'),
(24, 'awan', 'awan', 'peserta', '', 'aktif'),
(25, 'rain', 'rain', 'peserta', '', 'aktif'),
(27, 'rina', 'rina', 'peserta', '', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_agenda`
--
ALTER TABLE `tbl_agenda`
  ADD PRIMARY KEY (`id_agenda`);

--
-- Indeks untuk tabel `tbl_evaluasi_pelatihan`
--
ALTER TABLE `tbl_evaluasi_pelatihan`
  ADD PRIMARY KEY (`id_evaluasi_pelatihan`),
  ADD UNIQUE KEY `id_kehadiran` (`id_kehadiran`),
  ADD KEY `tbl_evaluasi_ibfk_1` (`id_pelatihan`),
  ADD KEY `id_peserta` (`id_peserta`);

--
-- Indeks untuk tabel `tbl_evaluasi_trainer`
--
ALTER TABLE `tbl_evaluasi_trainer`
  ADD PRIMARY KEY (`id_evaluasi_trainer`),
  ADD KEY `id_kehadiran` (`id_kehadiran`),
  ADD KEY `id_pelatihan` (`id_pelatihan`),
  ADD KEY `id_peserta` (`id_peserta`),
  ADD KEY `id_trainer` (`id_trainer`);

--
-- Indeks untuk tabel `tbl_kehadiran`
--
ALTER TABLE `tbl_kehadiran`
  ADD PRIMARY KEY (`id_kehadiran`),
  ADD UNIQUE KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indeks untuk tabel `tbl_keuangan`
--
ALTER TABLE `tbl_keuangan`
  ADD PRIMARY KEY (`id_keuangan`),
  ADD KEY `fk_pelatihan_id` (`id_pelatihan`);

--
-- Indeks untuk tabel `tbl_pelatihan`
--
ALTER TABLE `tbl_pelatihan`
  ADD PRIMARY KEY (`id_pelatihan`),
  ADD KEY `fk_trainer` (`id_trainer`);

--
-- Indeks untuk tabel `tbl_pendaftaran`
--
ALTER TABLE `tbl_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `id_pelatihan` (`id_pelatihan`,`id_peserta`),
  ADD KEY `id_peserta` (`id_peserta`);

--
-- Indeks untuk tabel `tbl_pengaduan`
--
ALTER TABLE `tbl_pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `id_peserta` (`id_peserta`);

--
-- Indeks untuk tabel `tbl_peserta`
--
ALTER TABLE `tbl_peserta`
  ADD PRIMARY KEY (`id_peserta`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tbl_posttest`
--
ALTER TABLE `tbl_posttest`
  ADD PRIMARY KEY (`id_jawaban_post`),
  ADD KEY `id_pelatihan` (`id_pelatihan`,`id_peserta`),
  ADD KEY `id_peserta` (`id_peserta`);

--
-- Indeks untuk tabel `tbl_pretest`
--
ALTER TABLE `tbl_pretest`
  ADD PRIMARY KEY (`id_jawaban_pre`),
  ADD KEY `id_pelatihan` (`id_pelatihan`,`id_peserta`),
  ADD KEY `id_peserta` (`id_peserta`);

--
-- Indeks untuk tabel `tbl_sertifikat`
--
ALTER TABLE `tbl_sertifikat`
  ADD PRIMARY KEY (`id_sertifikat`),
  ADD KEY `id_kehadiran` (`id_kehadiran`),
  ADD KEY `id_pelatihan` (`id_pelatihan`),
  ADD KEY `id_peserta` (`id_peserta`);

--
-- Indeks untuk tabel `tbl_test`
--
ALTER TABLE `tbl_test`
  ADD PRIMARY KEY (`id_test`),
  ADD KEY `id_pelatihan` (`id_pelatihan`);

--
-- Indeks untuk tabel `tbl_trainer`
--
ALTER TABLE `tbl_trainer`
  ADD PRIMARY KEY (`id_trainer`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `unique_username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_agenda`
--
ALTER TABLE `tbl_agenda`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_evaluasi_pelatihan`
--
ALTER TABLE `tbl_evaluasi_pelatihan`
  MODIFY `id_evaluasi_pelatihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT untuk tabel `tbl_evaluasi_trainer`
--
ALTER TABLE `tbl_evaluasi_trainer`
  MODIFY `id_evaluasi_trainer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `tbl_kehadiran`
--
ALTER TABLE `tbl_kehadiran`
  MODIFY `id_kehadiran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT untuk tabel `tbl_keuangan`
--
ALTER TABLE `tbl_keuangan`
  MODIFY `id_keuangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `tbl_pelatihan`
--
ALTER TABLE `tbl_pelatihan`
  MODIFY `id_pelatihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_pendaftaran`
--
ALTER TABLE `tbl_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengaduan`
--
ALTER TABLE `tbl_pengaduan`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_peserta`
--
ALTER TABLE `tbl_peserta`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tbl_posttest`
--
ALTER TABLE `tbl_posttest`
  MODIFY `id_jawaban_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_pretest`
--
ALTER TABLE `tbl_pretest`
  MODIFY `id_jawaban_pre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_sertifikat`
--
ALTER TABLE `tbl_sertifikat`
  MODIFY `id_sertifikat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `tbl_test`
--
ALTER TABLE `tbl_test`
  MODIFY `id_test` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tbl_trainer`
--
ALTER TABLE `tbl_trainer`
  MODIFY `id_trainer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_evaluasi_pelatihan`
--
ALTER TABLE `tbl_evaluasi_pelatihan`
  ADD CONSTRAINT `tbl_evaluasi_pelatihan_ibfk_1` FOREIGN KEY (`id_pelatihan`) REFERENCES `tbl_pelatihan` (`id_pelatihan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_evaluasi_pelatihan_ibfk_2` FOREIGN KEY (`id_peserta`) REFERENCES `tbl_peserta` (`id_peserta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_evaluasi_pelatihan_ibfk_3` FOREIGN KEY (`id_kehadiran`) REFERENCES `tbl_kehadiran` (`id_kehadiran`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_evaluasi_trainer`
--
ALTER TABLE `tbl_evaluasi_trainer`
  ADD CONSTRAINT `tbl_evaluasi_trainer_ibfk_1` FOREIGN KEY (`id_pelatihan`) REFERENCES `tbl_pelatihan` (`id_pelatihan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_evaluasi_trainer_ibfk_2` FOREIGN KEY (`id_kehadiran`) REFERENCES `tbl_kehadiran` (`id_kehadiran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_evaluasi_trainer_ibfk_3` FOREIGN KEY (`id_peserta`) REFERENCES `tbl_peserta` (`id_peserta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_evaluasi_trainer_ibfk_4` FOREIGN KEY (`id_trainer`) REFERENCES `tbl_trainer` (`id_trainer`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_kehadiran`
--
ALTER TABLE `tbl_kehadiran`
  ADD CONSTRAINT `tbl_pendaftaran_ibfk_3` FOREIGN KEY (`id_pendaftaran`) REFERENCES `tbl_pendaftaran` (`id_pendaftaran`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_keuangan`
--
ALTER TABLE `tbl_keuangan`
  ADD CONSTRAINT `fk_pelatihan_id` FOREIGN KEY (`id_pelatihan`) REFERENCES `tbl_pelatihan` (`id_pelatihan`);

--
-- Ketidakleluasaan untuk tabel `tbl_pelatihan`
--
ALTER TABLE `tbl_pelatihan`
  ADD CONSTRAINT `fk_trainer` FOREIGN KEY (`id_trainer`) REFERENCES `tbl_trainer` (`id_trainer`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_pendaftaran`
--
ALTER TABLE `tbl_pendaftaran`
  ADD CONSTRAINT `tbl_pendaftaran_ibfk_1` FOREIGN KEY (`id_pelatihan`) REFERENCES `tbl_pelatihan` (`id_pelatihan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pendaftaran_ibfk_2` FOREIGN KEY (`id_peserta`) REFERENCES `tbl_peserta` (`id_peserta`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_pengaduan`
--
ALTER TABLE `tbl_pengaduan`
  ADD CONSTRAINT `tbl_pengaduan_ibfk_1` FOREIGN KEY (`id_peserta`) REFERENCES `tbl_peserta` (`id_peserta`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_peserta`
--
ALTER TABLE `tbl_peserta`
  ADD CONSTRAINT `tbl_peserta_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_posttest`
--
ALTER TABLE `tbl_posttest`
  ADD CONSTRAINT `tbl_posttest_ibfk_2` FOREIGN KEY (`id_pelatihan`) REFERENCES `tbl_pelatihan` (`id_pelatihan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_posttest_ibfk_3` FOREIGN KEY (`id_peserta`) REFERENCES `tbl_peserta` (`id_peserta`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_pretest`
--
ALTER TABLE `tbl_pretest`
  ADD CONSTRAINT `tbl_pretest_ibfk_1` FOREIGN KEY (`id_pelatihan`) REFERENCES `tbl_pelatihan` (`id_pelatihan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pretest_ibfk_2` FOREIGN KEY (`id_peserta`) REFERENCES `tbl_peserta` (`id_peserta`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_sertifikat`
--
ALTER TABLE `tbl_sertifikat`
  ADD CONSTRAINT `tbl_sertifikat_ibfk_1` FOREIGN KEY (`id_kehadiran`) REFERENCES `tbl_kehadiran` (`id_kehadiran`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_sertifikat_ibfk_2` FOREIGN KEY (`id_pelatihan`) REFERENCES `tbl_pelatihan` (`id_pelatihan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_sertifikat_ibfk_3` FOREIGN KEY (`id_peserta`) REFERENCES `tbl_peserta` (`id_peserta`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_test`
--
ALTER TABLE `tbl_test`
  ADD CONSTRAINT `tbl_test_ibfk_1` FOREIGN KEY (`id_pelatihan`) REFERENCES `tbl_pelatihan` (`id_pelatihan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_trainer`
--
ALTER TABLE `tbl_trainer`
  ADD CONSTRAINT `tbl_trainer_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_user` (`id_user`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
