-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+deb12u1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 06 juin 2025 à 22:40
-- Version du serveur : 8.0.42
-- Version de PHP : 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_seminaires`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(14, '0001_01_01_000000_create_users_table', 1),
(15, '0001_01_01_000001_create_cache_table', 1),
(16, '0001_01_01_000002_create_jobs_table', 1),
(17, '2025_06_02_023038_create_seminars_table', 1),
(18, '2025_06_02_135415_add_summary_and_preferred_date_to_seminars_table', 1),
(19, '2025_06_03_225844_add_rejected_to_status_enum_in_seminars_table', 2),
(20, '2025_06_06_170645_add_admin_to_role_enum_in_users_table', 3);

-- --------------------------------------------------------

--
-- Structure de la table `seminars`
--

CREATE TABLE `seminars` (
  `id` bigint UNSIGNED NOT NULL,
  `presenter_id` bigint UNSIGNED NOT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','accepted','rejected','published','expired','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `summary` text COLLATE utf8mb4_unicode_ci,
  `preferred_date` date DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `summary_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary_uploaded_at` timestamp NULL DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `presentation_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `presentation_uploaded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `seminars`
--

INSERT INTO `seminars` (`id`, `presenter_id`, `theme`, `status`, `summary`, `preferred_date`, `scheduled_date`, `summary_path`, `summary_uploaded_at`, `published_at`, `presentation_path`, `presentation_uploaded_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Thème 1', 'completed', 'Sed ante nulla, fringilla non imperdiet sit amet, rhoncus at dui. Vestibulum rhoncus nulla eu ultricies imperdiet. Nunc quis ligula sit amet eros vestibulum gravida nec fringilla risus. Etiam dictum egestas purus, in scelerisque sem feugiat eget. Maecenas tincidunt et eros ut vulputate. Donec lobortis imperdiet lectus, quis euismod dui egestas quis. Duis vitae sapien sed ligula tempor malesuada. Donec vel nibh porttitor, volutpat leo sit amet, mattis neque. Curabitur pretium neque ac arcu auctor elementum. Nullam consequat lacus at risus auctor, eu venenatis tortor tempus. Vestibulum vel congue ipsum, sed eleifend est. Cras nec justo in nibh tempus rutrum vitae eu mi. Quisque lacinia convallis nibh, et blandit est vehicula vel. Fusce cursus volutpat sapien quis aliquet. Cras blandit dictum nunc, nec gravida magna pretium sed.\n', '2025-06-01', '2025-06-02', NULL, NULL, '2025-05-24 23:00:00', NULL, NULL, '2025-05-27 21:34:42', '2025-06-02 21:56:25'),
(2, 2, 'Thème 2', 'published', 'Suspendisse tempus est et nisl malesuada, quis sollicitudin libero maximus. Nullam posuere velit tellus, egestas tristique lectus auctor non. Morbi purus tellus, gravida in dolor a, semper tempor lectus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dictum sit amet dolor facilisis gravida. Nulla facilisi. Sed molestie efficitur neque, sed sagittis lacus. In efficitur velit a massa vulputate consectetur. Integer in elit purus. Vestibulum a congue libero. Fusce nunc massa, ultricies sit amet tristique eu, tincidunt ac justo. In sollicitudin diam nulla, eu imperdiet metus aliquet et. Maecenas quis ligula at arcu condimentum blandit.', '2025-06-15', '2025-06-13', NULL, NULL, '2025-06-06 16:37:59', NULL, NULL, '2025-06-03 21:34:56', '2025-06-06 16:37:59'),
(3, 2, 'Thème 3', 'expired', NULL, '2025-06-15', '2025-06-07', NULL, NULL, NULL, NULL, NULL, '2025-06-03 21:35:15', '2025-06-03 21:56:32'),
(4, 2, 'Thème 4', 'rejected', NULL, '2025-06-15', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-03 21:35:41', '2025-06-03 21:59:22'),
(5, 2, 'Thème 5', 'published', 'Mauris eu dui mattis, malesuada tellus eget, aliquet mi. Aliquam id diam luctus elit euismod elementum quis eu urna. Donec convallis placerat fringilla. Suspendisse accumsan ut lacus eget euismod. Vestibulum aliquet pharetra leo fringilla vehicula. Pellentesque finibus enim at ligula convallis sodales. Vestibulum laoreet metus sit amet dictum auctor. Quisque aliquam enim id sagittis iaculis. Donec consectetur, mi id volutpat feugiat, nulla ipsum sagittis libero, vitae tincidunt magna nisl quis mi. Suspendisse sed viverra arcu. Etiam venenatis lectus commodo ligula vulputate, vel scelerisque tellus sagittis. Etiam pretium mauris magna, eget venenatis eros consequat ut. Phasellus consectetur lorem sit amet est euismod, sollicitudin molestie leo hendrerit. Vestibulum imperdiet massa lacus, sed cursus urna suscipit eleifend. Aenean luctus odio sit amet lorem euismod, nec tempor tellus rutrum. Cras urna magna, porttitor et elit nec, ullamcorper gravida ipsum.', '2025-06-17', '2025-06-10', NULL, NULL, '2025-06-03 22:17:38', NULL, NULL, '2025-06-03 21:37:05', '2025-06-03 22:17:38'),
(6, 2, 'Thème 6', 'expired', NULL, '2025-06-01', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12 22:57:01', '2025-05-12 22:57:01'),
(7, 2, 'Thème 9', 'accepted', NULL, '2025-06-16', '2025-06-13', NULL, NULL, NULL, NULL, NULL, '2025-06-04 01:09:58', '2025-06-04 01:11:19'),
(8, 2, 'Thème 10', 'accepted', NULL, '2025-06-21', '2025-06-16', NULL, NULL, NULL, NULL, NULL, '2025-06-04 01:10:19', '2025-06-04 01:11:24'),
(9, 2, 'Thème 6', 'pending', NULL, '2025-06-18', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-06 20:18:02', '2025-06-06 20:18:02');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','secretary','presenter','student') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Secretaire', 'secretaire@imsp.bj', '$2y$12$238NsDKjf3fSe9ZgTF1/l.dlzPBjXAx7XTHEjTbPtbb5Kppmb7COS', 'secretary', NULL, '2025-06-03 21:27:58', '2025-06-03 21:27:58'),
(2, 'Presentateur', 'presentateur@imsp.com', '$2y$12$iMtVQZPiv0zADCAnF9a4BOb6YKWTU9xoDs04C05nLhND7Xc/AfUQ2', 'presenter', NULL, '2025-06-03 21:33:56', '2025-06-03 21:33:56'),
(3, 'Etudiant', 'etudiant@imsp.com', '$2y$12$yHAoQCHhBeITRJ1f0xfcUOC/vbMBez1q8kIuVSajiFu5Hjidj1ZNK', 'student', NULL, '2025-06-04 10:34:12', '2025-06-06 16:15:57'),
(4, 'admin', 'admin@imsp.com', '$2y$12$MJz5onTPfW4ZTm0EGIRMHO/eBTpv/IzgFjHw5h7KvnsRQWqGrSu5u', 'admin', NULL, '2025-06-06 16:10:54', '2025-06-06 16:10:54'),
(5, 'Presentateur 2', 'presentateur2@imsp.com', '$2y$12$TfX1.PB4/k6ZD6NcEPIkiehE1S.O748EsV.i8VhmzMvtmM29gxBQG', 'presenter', NULL, '2025-06-06 16:34:41', '2025-06-06 16:35:17');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `seminars`
--
ALTER TABLE `seminars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seminars_presenter_id_foreign` (`presenter_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `seminars`
--
ALTER TABLE `seminars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `seminars`
--
ALTER TABLE `seminars`
  ADD CONSTRAINT `seminars_presenter_id_foreign` FOREIGN KEY (`presenter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
