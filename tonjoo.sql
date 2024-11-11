-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Nov 2024 pada 04.48
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
-- Database: `tonjoo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('a6f155de15268698bea3ed1df3f9aab3', 'i:1;', 1730857368),
('a6f155de15268698bea3ed1df3f9aab3:timer', 'i:1730857368;', 1730857368);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_01_033353_create_personal_access_tokens_table', 1),
(5, '2024_10_01_033649_add_two_factor_columns_to_users_table', 1),
(6, '2024_10_08_021445_create_transaction_headers_table', 1),
(7, '2024_10_08_021519_create_ms_categories_table', 1),
(8, '2024_10_08_022012_create_transaction_details_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_categories`
--

CREATE TABLE `ms_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ms_categories`
--

INSERT INTO `ms_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Expense', NULL, NULL),
(2, 'Income', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JS8oZPV0QKvbHoUyfvuXmqTL1InxOoFfuTQkcsEK', 11, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiQmZodVFqc1Z1V3RndlB0SFhDVEgzTzdNNGs1YUZCVkgwaDc1R1hscSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdHJhbnNhY3Rpb25zL2NyZWF0ZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjExO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJDdUM3RYUmhxTXo1c3BxYTltVmN0MWVRbm1XdC4yTjVDbG9MWHBCUUxndU93Mk4wRnJkY0ltIjt9', 1730885666);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value_idr` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `transaction_category_id`, `name`, `value_idr`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Transaksi Expense TRX369', 589537, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(2, 2, 1, 'Transaksi Expense TRX113', 631211, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(3, 3, 2, 'Transaksi Income TRX801', 160616, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(4, 4, 1, 'Transaksi Expense TRX528', 108934, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(5, 5, 2, 'Transaksi Income TRX930', 637888, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(6, 6, 1, 'Transaksi Expense TRX918', 639497, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(7, 7, 1, 'Transaksi Expense TRX746', 451760, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(8, 8, 2, 'Transaksi Income TRX799', 903224, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(9, 9, 1, 'Transaksi Expense TRX549', 361231, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(10, 10, 2, 'Transaksi Income TRX931', 551299, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(11, 11, 2, 'Transaksi Income TRX681', 159830, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(12, 12, 2, 'Transaksi Income TRX939', 720009, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(13, 13, 1, 'Transaksi Expense TRX172', 986991, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(14, 14, 1, 'Transaksi Expense TRX390', 771241, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(15, 15, 1, 'Transaksi Expense TRX901', 997819, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(16, 16, 1, 'Transaksi Expense TRX012', 981889, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(17, 17, 1, 'Transaksi Expense TRX513', 216042, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(18, 18, 2, 'Transaksi Income TRX960', 395201, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(19, 19, 2, 'Transaksi Income TRX953', 386493, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(20, 20, 1, 'Transaksi Expense TRX256', 369782, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(21, 21, 1, 'Transaksi Expense TRX027', 461883, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(22, 22, 2, 'Transaksi Income TRX598', 150439, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(23, 23, 1, 'Transaksi Expense TRX660', 798551, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(24, 24, 1, 'Transaksi Expense TRX382', 318363, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(25, 25, 2, 'Transaksi Income TRX076', 887532, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(26, 26, 1, 'Transaksi Expense TRX335', 591552, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(27, 27, 1, 'Transaksi Expense TRX149', 182141, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(28, 28, 2, 'Transaksi Income TRX723', 847408, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(30, 30, 2, 'Transaksi Income TRX318', 170338, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(32, 32, 1, 'Transaksi Expense TRX595', 261016, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(33, 33, 2, 'Transaksi Income TRX827', 296509, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(34, 34, 1, 'Transaksi Expense TRX508', 820595, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(35, 35, 1, 'Transaksi Expense TRX690', 319662, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(36, 36, 1, 'Transaksi Expense TRX368', 819926, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(37, 37, 1, 'Transaksi Expense TRX585', 624488, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(38, 38, 2, 'Transaksi Income TRX713', 442127, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(39, 39, 1, 'Transaksi Expense TRX399', 888305, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(40, 40, 1, 'Transaksi Expense TRX053', 770649, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(41, 41, 2, 'Transaksi Income TRX218', 782915, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(42, 42, 2, 'Transaksi Income TRX777', 695458, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(43, 43, 1, 'Transaksi Expense TRX448', 503255, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(44, 44, 1, 'Transaksi Expense TRX863', 325348, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(45, 45, 2, 'Transaksi Income TRX912', 575130, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(46, 46, 1, 'Transaksi Expense TRX845', 516528, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(47, 47, 1, 'Transaksi Expense TRX166', 508737, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(48, 48, 1, 'Transaksi Expense TRX284', 638277, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(49, 49, 2, 'Transaksi Income TRX628', 280876, '2024-11-04 21:31:33', '2024-11-04 21:31:33'),
(58, 50, 1, 'Transaksi Expense TRX466', 549134, '2024-11-04 23:39:00', '2024-11-04 23:39:00'),
(59, 50, 2, 'Transaksi Expense TRX466', 4242424, '2024-11-04 23:39:00', '2024-11-04 23:39:00'),
(60, 50, 2, 'Transaksi Expense TRX466', 1000000, '2024-11-04 23:39:00', '2024-11-04 23:39:00'),
(67, 31, 1, 'Transaksi Expense TRX597', 523012, '2024-11-05 21:18:42', '2024-11-05 21:18:42'),
(68, 31, 1, 'Ariana Hooper', 53465533, '2024-11-05 21:18:42', '2024-11-05 21:18:42'),
(69, 31, 2, 'Quintessa Murray', 523532, '2024-11-05 21:18:42', '2024-11-05 21:18:42'),
(70, 31, 1, 'Thaddeus Rutledge', 8888232, '2024-11-05 21:18:42', '2024-11-05 21:18:42'),
(71, 31, 1, 'Dandy Surki', 234, '2024-11-05 21:18:42', '2024-11-05 21:18:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_headers`
--

CREATE TABLE `transaction_headers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `rate_euro` double NOT NULL,
  `date_paid` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_headers`
--

INSERT INTO `transaction_headers` (`id`, `description`, `code`, `rate_euro`, `date_paid`, `created_at`, `updated_at`) VALUES
(1, 'Earum dolorem et et tempore illum vero corporis.', 'TRX369', 16.79, '2024-09-30', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(2, 'Amet sed hic quos magnam dolor accusantium voluptatem.', 'TRX113', 15.75, '2024-05-16', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(3, 'Cumque rerum est ducimus ducimus cum voluptatem.', 'TRX801', 18.38, '2024-05-24', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(4, 'Quis voluptate perferendis est quis quia at.', 'TRX528', 19.75, '2024-10-09', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(5, 'Reprehenderit deleniti laborum quo asperiores.', 'TRX930', 14.24, '2024-04-07', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(6, 'Dolores rerum molestias odit et non.', 'TRX918', 14.5, '2024-06-21', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(7, 'Aspernatur dolor veniam blanditiis voluptates fuga sint quia.', 'TRX746', 14.5, '2024-09-17', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(8, 'Similique sit sed unde odit.', 'TRX799', 16.89, '2024-01-27', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(9, 'Provident enim odio debitis.', 'TRX549', 17.84, '2024-09-16', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(10, 'Voluptatem est qui hic reprehenderit.', 'TRX931', 15.99, '2024-04-19', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(11, 'Sapiente similique eligendi et nemo.', 'TRX681', 12.51, '2024-05-25', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(12, 'Cum fugiat ratione et ut inventore.', 'TRX939', 12.41, '2024-03-29', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(13, 'Est quisquam quis aut deleniti consequatur omnis voluptate necessitatibus.', 'TRX172', 17.82, '2024-07-11', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(14, 'Voluptate necessitatibus suscipit consequatur architecto unde laboriosam magni.', 'TRX390', 19.79, '2024-04-21', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(15, 'Doloremque sint nulla qui.', 'TRX901', 19.02, '2024-10-13', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(16, 'Blanditiis consequuntur non dolores illum velit.', 'TRX012', 17.02, '2024-11-01', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(17, 'Velit nemo recusandae doloribus.', 'TRX513', 16.6, '2024-04-04', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(18, 'Omnis eligendi fugiat quo consequatur nam.', 'TRX960', 14.36, '2024-04-17', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(19, 'Nulla id ipsam blanditiis veritatis praesentium adipisci.', 'TRX953', 11.28, '2024-08-08', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(20, 'Est consequatur assumenda ut et.', 'TRX256', 10.41, '2024-06-07', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(21, 'Vero eos voluptatem sapiente aliquid odio sit.', 'TRX027', 10.87, '2024-10-26', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(22, 'A quo nulla at.', 'TRX598', 14.41, '2024-01-10', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(23, 'Officia ut quia nihil illo earum.', 'TRX660', 12.74, '2024-10-27', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(24, 'Autem alias et eos occaecati ea itaque dolorum.', 'TRX382', 18.28, '2024-06-14', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(25, 'Incidunt commodi cupiditate laudantium quia velit iste iusto.', 'TRX076', 11.4, '2024-11-03', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(26, 'Nulla dolorum porro aut maxime.', 'TRX335', 11.66, '2024-07-04', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(27, 'Autem tempora nihil doloremque adipisci quis.', 'TRX149', 17.69, '2024-09-01', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(28, 'Dolorum non laboriosam unde aut ut placeat.', 'TRX723', 14.61, '2024-02-17', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(29, 'Rem dicta sit nobis.', 'TRX993', 10.56, '2024-03-08', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(30, 'Architecto error nemo perspiciatis nemo mollitia possimus odio.', 'TRX318', 16.18, '2024-07-22', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(31, 'Et repellat explicabo consectetur repellendus eos.', 'TRX597', 16.69, '2024-01-06', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(32, 'Omnis ex quia nemo voluptatem.', 'TRX595', 12.38, '2024-05-23', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(33, 'Consequatur explicabo aut repudiandae et harum id.', 'TRX827', 17.87, '2024-08-30', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(34, 'Blanditiis voluptatem et aliquam at ut enim.', 'TRX508', 18.26, '2024-08-06', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(35, 'Possimus quo id tenetur nihil inventore hic.', 'TRX690', 13.24, '2024-08-15', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(36, 'Voluptatum quia asperiores ipsam repellendus illo dolore optio.', 'TRX368', 13.14, '2024-05-13', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(37, 'Amet repellat ad mollitia libero voluptatem doloribus omnis voluptas.', 'TRX585', 15.84, '2024-02-20', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(38, 'Consequatur ut quo vero dignissimos quidem ea.', 'TRX713', 13.03, '2024-05-21', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(39, 'Possimus unde aut dicta.', 'TRX399', 19.24, '2024-10-01', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(40, 'Voluptates officiis aut magni et est.', 'TRX053', 14.6, '2024-07-04', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(41, 'Commodi ducimus ad rem.', 'TRX218', 15.81, '2024-01-27', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(42, 'Nemo assumenda dolores et ut voluptates autem.', 'TRX777', 16.54, '2024-08-23', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(43, 'Rem qui tempore assumenda voluptatem.', 'TRX448', 12.41, '2024-02-13', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(44, 'Occaecati voluptatem et nam minus.', 'TRX863', 10.78, '2024-01-31', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(45, 'Quidem sed voluptatem minus aut sint eum.', 'TRX912', 10.24, '2024-02-10', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(46, 'Aut est esse minus rerum reiciendis qui dolorem tempore.', 'TRX845', 12.46, '2024-09-28', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(47, 'Aut perferendis adipisci sed rerum repellat cumque.', 'TRX166', 18.56, '2024-07-16', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(48, 'Expedita dolorem odit consequuntur quae vel.', 'TRX284', 11.07, '2024-04-22', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(49, 'Soluta ducimus et quae aut.', 'TRX628', 12.36, '2024-05-14', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(50, 'Ut officiis et ipsa et id vel.', 'TRX466', 18.5, '2024-03-27', '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(51, 'Asperiores elit tem', 'Et est sit ut volu', 19, '1986-07-05', '2024-11-04 22:46:33', '2024-11-04 22:46:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Ari Weissnat', 'kaleb41@example.net', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'j0xBynYF8b', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(2, 'Prof. Sigurd Bailey', 'vmckenzie@example.org', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'um1XHZzWTc', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(3, 'Jordane Vandervort', 'tlubowitz@example.org', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'uVVhN3wqlG', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(4, 'Kaelyn Ryan', 'eulalia.johnson@example.net', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'mVZE4guSAH', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(5, 'Fernando Beer', 'ciara90@example.org', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'ZcbN9hClci', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(6, 'Mrs. Reina Koelpin Jr.', 'augustus.wisozk@example.org', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'YgVHUgDgKq', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(7, 'Genesis Gislason V', 'mariana.jenkins@example.net', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'wgWvUUc8br', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(8, 'Mrs. Kimberly Wehner III', 'stoltenberg.frederique@example.com', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'NTIIWux0dn', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(9, 'Deontae Rohan', 'jaqueline59@example.com', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'apbApIv2SO', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(10, 'Francis Okuneva', 'reynolds.rusty@example.org', '2024-11-04 21:31:32', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'zLDNqw52i9', NULL, NULL, '2024-11-04 21:31:32', '2024-11-04 21:31:32'),
(11, 'Test User', 'test@example.com', '2024-11-04 21:31:33', '$2y$12$7T3tXRhqMz5spqa9mVct1eQnmWt.2N5CloLXpBQLguOw2N0FrdcIm', NULL, NULL, NULL, 'AMjtPgzvUe', NULL, NULL, '2024-11-04 21:31:33', '2024-11-04 21:31:33');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ms_categories`
--
ALTER TABLE `ms_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_details_transaction_category_id_foreign` (`transaction_category_id`);

--
-- Indeks untuk tabel `transaction_headers`
--
ALTER TABLE `transaction_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `ms_categories`
--
ALTER TABLE `ms_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT untuk tabel `transaction_headers`
--
ALTER TABLE `transaction_headers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_transaction_category_id_foreign` FOREIGN KEY (`transaction_category_id`) REFERENCES `ms_categories` (`id`),
  ADD CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transaction_headers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
