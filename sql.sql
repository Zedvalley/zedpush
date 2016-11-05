-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2016 at 10:30 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zedpush`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `number` varchar(14) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `created_by`, `number`, `name`, `email`, `age`) VALUES
(39, 12, '123', 'samad', NULL, NULL),
(40, 12, '9947313547', 'hi', 'sy', 10),
(42, 12, '9947313547', 'hi', 'sy', NULL),
(43, 12, '9947313547', 'hi', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `mobile` varchar(14) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `submitted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'DS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua and Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CK', 'Cook Islands'),
(51, 'CR', 'Costa Rica'),
(52, 'HR', 'Croatia (Hrvatska)'),
(53, 'CU', 'Cuba'),
(54, 'CY', 'Cyprus'),
(55, 'CZ', 'Czech Republic'),
(56, 'DK', 'Denmark'),
(57, 'DJ', 'Djibouti'),
(58, 'DM', 'Dominica'),
(59, 'DO', 'Dominican Republic'),
(60, 'TP', 'East Timor'),
(61, 'EC', 'Ecuador'),
(62, 'EG', 'Egypt'),
(63, 'SV', 'El Salvador'),
(64, 'GQ', 'Equatorial Guinea'),
(65, 'ER', 'Eritrea'),
(66, 'EE', 'Estonia'),
(67, 'ET', 'Ethiopia'),
(68, 'FK', 'Falkland Islands (Malvinas)'),
(69, 'FO', 'Faroe Islands'),
(70, 'FJ', 'Fiji'),
(71, 'FI', 'Finland'),
(72, 'FR', 'France'),
(73, 'FX', 'France, Metropolitan'),
(74, 'GF', 'French Guiana'),
(75, 'PF', 'French Polynesia'),
(76, 'TF', 'French Southern Territories'),
(77, 'GA', 'Gabon'),
(78, 'GM', 'Gambia'),
(79, 'GE', 'Georgia'),
(80, 'DE', 'Germany'),
(81, 'GH', 'Ghana'),
(82, 'GI', 'Gibraltar'),
(83, 'GK', 'Guernsey'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'IM', 'Isle of Man'),
(101, 'ID', 'Indonesia'),
(102, 'IR', 'Iran (Islamic Republic of)'),
(103, 'IQ', 'Iraq'),
(104, 'IE', 'Ireland'),
(105, 'IL', 'Israel'),
(106, 'IT', 'Italy'),
(107, 'CI', 'Ivory Coast'),
(108, 'JE', 'Jersey'),
(109, 'JM', 'Jamaica'),
(110, 'JP', 'Japan'),
(111, 'JO', 'Jordan'),
(112, 'KZ', 'Kazakhstan'),
(113, 'KE', 'Kenya'),
(114, 'KI', 'Kiribati'),
(115, 'KP', 'Korea, Democratic People''s Republic of'),
(116, 'KR', 'Korea, Republic of'),
(117, 'XK', 'Kosovo'),
(118, 'KW', 'Kuwait'),
(119, 'KG', 'Kyrgyzstan'),
(120, 'LA', 'Lao People''s Democratic Republic'),
(121, 'LV', 'Latvia'),
(122, 'LB', 'Lebanon'),
(123, 'LS', 'Lesotho'),
(124, 'LR', 'Liberia'),
(125, 'LY', 'Libyan Arab Jamahiriya'),
(126, 'LI', 'Liechtenstein'),
(127, 'LT', 'Lithuania'),
(128, 'LU', 'Luxembourg'),
(129, 'MO', 'Macau'),
(130, 'MK', 'Macedonia'),
(131, 'MG', 'Madagascar'),
(132, 'MW', 'Malawi'),
(133, 'MY', 'Malaysia'),
(134, 'MV', 'Maldives'),
(135, 'ML', 'Mali'),
(136, 'MT', 'Malta'),
(137, 'MH', 'Marshall Islands'),
(138, 'MQ', 'Martinique'),
(139, 'MR', 'Mauritania'),
(140, 'MU', 'Mauritius'),
(141, 'TY', 'Mayotte'),
(142, 'MX', 'Mexico'),
(143, 'FM', 'Micronesia, Federated States of'),
(144, 'MD', 'Moldova, Republic of'),
(145, 'MC', 'Monaco'),
(146, 'MN', 'Mongolia'),
(147, 'ME', 'Montenegro'),
(148, 'MS', 'Montserrat'),
(149, 'MA', 'Morocco'),
(150, 'MZ', 'Mozambique'),
(151, 'MM', 'Myanmar'),
(152, 'NA', 'Namibia'),
(153, 'NR', 'Nauru'),
(154, 'NP', 'Nepal'),
(155, 'NL', 'Netherlands'),
(156, 'AN', 'Netherlands Antilles'),
(157, 'NC', 'New Caledonia'),
(158, 'NZ', 'New Zealand'),
(159, 'NI', 'Nicaragua'),
(160, 'NE', 'Niger'),
(161, 'NG', 'Nigeria'),
(162, 'NU', 'Niue'),
(163, 'NF', 'Norfolk Island'),
(164, 'MP', 'Northern Mariana Islands'),
(165, 'NO', 'Norway'),
(166, 'OM', 'Oman'),
(167, 'PK', 'Pakistan'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestine'),
(170, 'PA', 'Panama'),
(171, 'PG', 'Papua New Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Peru'),
(174, 'PH', 'Philippines'),
(175, 'PN', 'Pitcairn'),
(176, 'PL', 'Poland'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'RE', 'Reunion'),
(181, 'RO', 'Romania'),
(182, 'RU', 'Russian Federation'),
(183, 'RW', 'Rwanda'),
(184, 'KN', 'Saint Kitts and Nevis'),
(185, 'LC', 'Saint Lucia'),
(186, 'VC', 'Saint Vincent and the Grenadines'),
(187, 'WS', 'Samoa'),
(188, 'SM', 'San Marino'),
(189, 'ST', 'Sao Tome and Principe'),
(190, 'SA', 'Saudi Arabia'),
(191, 'SN', 'Senegal'),
(192, 'RS', 'Serbia'),
(193, 'SC', 'Seychelles'),
(194, 'SL', 'Sierra Leone'),
(195, 'SG', 'Singapore'),
(196, 'SK', 'Slovakia'),
(197, 'SI', 'Slovenia'),
(198, 'SB', 'Solomon Islands'),
(199, 'SO', 'Somalia'),
(200, 'ZA', 'South Africa'),
(201, 'GS', 'South Georgia South Sandwich Islands'),
(202, 'ES', 'Spain'),
(203, 'LK', 'Sri Lanka'),
(204, 'SH', 'St. Helena'),
(205, 'PM', 'St. Pierre and Miquelon'),
(206, 'SD', 'Sudan'),
(207, 'SR', 'Suriname'),
(208, 'SJ', 'Svalbard and Jan Mayen Islands'),
(209, 'SZ', 'Swaziland'),
(210, 'SE', 'Sweden'),
(211, 'CH', 'Switzerland'),
(212, 'SY', 'Syrian Arab Republic'),
(213, 'TW', 'Taiwan'),
(214, 'TJ', 'Tajikistan'),
(215, 'TZ', 'Tanzania, United Republic of'),
(216, 'TH', 'Thailand'),
(217, 'TG', 'Togo'),
(218, 'TK', 'Tokelau'),
(219, 'TO', 'Tonga'),
(220, 'TT', 'Trinidad and Tobago'),
(221, 'TN', 'Tunisia'),
(222, 'TR', 'Turkey'),
(223, 'TM', 'Turkmenistan'),
(224, 'TC', 'Turks and Caicos Islands'),
(225, 'TV', 'Tuvalu'),
(226, 'UG', 'Uganda'),
(227, 'UA', 'Ukraine'),
(228, 'AE', 'United Arab Emirates'),
(229, 'GB', 'United Kingdom'),
(230, 'US', 'United States'),
(231, 'UM', 'United States minor outlying islands'),
(232, 'UY', 'Uruguay'),
(233, 'UZ', 'Uzbekistan'),
(234, 'VU', 'Vanuatu'),
(235, 'VA', 'Vatican City State'),
(236, 'VE', 'Venezuela'),
(237, 'VN', 'Vietnam'),
(238, 'VG', 'Virgin Islands (British)'),
(239, 'VI', 'Virgin Islands (U.S.)'),
(240, 'WF', 'Wallis and Futuna Islands'),
(241, 'EH', 'Western Sahara'),
(242, 'YE', 'Yemen'),
(243, 'ZR', 'Zaire'),
(244, 'ZM', 'Zambia'),
(245, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE `domains` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `domains`
--

INSERT INTO `domains` (`id`, `name`, `user_id`) VALUES
(1, 'www.xyz.com', 16);

-- --------------------------------------------------------

--
-- Table structure for table `extra`
--

CREATE TABLE `extra` (
  `id` int(11) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `pic_name1` varchar(70) NOT NULL,
  `pic_name2` varchar(70) DEFAULT NULL,
  `pic_name3` varchar(70) DEFAULT NULL,
  `pic_name4` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `created_by`, `pic_name1`, `pic_name2`, `pic_name3`, `pic_name4`) VALUES
(5, 12, '580a562828cf9', '580a56282a422', '580a56282a93d', NULL),
(6, 12, '580a74e7eb044', '580a74e7ecaeb', '580a74e7ed6eb', NULL),
(7, 12, '580bae9cea70b', '580bc439d84e1', '580bae9cec8c7', '580bae9ced17d'),
(8, 12, '580bafbdc61bd', '580bafbdc7d65', '580bafbdc817b', '580bafbdc858b'),
(9, 12, '580bafddcf38b', '580bafddd10e0', NULL, NULL),
(10, 12, '5818f69c9ebd9', NULL, NULL, NULL),
(11, 12, '5818f73790448', NULL, NULL, NULL),
(12, 12, '5818f7fa51f4d', NULL, NULL, NULL),
(13, 12, '5818fcc190b2d', NULL, NULL, NULL),
(14, 12, '5818fcde85bfe', NULL, NULL, NULL),
(15, 12, '581c759f22d5f', '581c759f3fa06', '581c7a89c4336', NULL),
(16, 12, '581c79a95028f', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `home`
--

CREATE TABLE `home` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `about_us` varchar(1000) DEFAULT NULL,
  `sector_tag` varchar(200) NOT NULL DEFAULT 'Products / Services',
  `logo_title` varchar(300) DEFAULT NULL,
  `address` varchar(800) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `contact` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `home`
--

INSERT INTO `home` (`id`, `created_by`, `gallery_id`, `about_us`, `sector_tag`, `logo_title`, `address`, `email`, `contact`) VALUES
(1, 16, NULL, NULL, 'Products / Services', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs_campaign`
--

CREATE TABLE `jobs_campaign` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `base_title` varchar(200) NOT NULL,
  `job_title` varchar(700) NOT NULL,
  `job_description` varchar(5000) DEFAULT NULL,
  `salary` varchar(20) DEFAULT NULL,
  `salary_note` varchar(20) DEFAULT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `status` int(11) DEFAULT '1',
  `contact_no` varchar(14) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_campaign`
--

INSERT INTO `jobs_campaign` (`id`, `created_by`, `base_title`, `job_title`, `job_description`, `salary`, `salary_note`, `gallery_id`, `views`, `status`, `contact_no`, `slug`, `created_at`, `updated_at`) VALUES
(1, 12, 'xyz', 'xyzh', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'xyzh', '2016-10-29 17:06:42', NULL),
(2, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasd', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'sadasd-sdas-dasdasd', '2016-10-29 17:07:21', NULL),
(3, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasd', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'sadasd-sdas-dasdasd', '2016-10-29 17:07:34', NULL),
(4, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasd', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'sadasd-sdas-dasdasd', '2016-10-29 17:08:15', NULL),
(5, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasd', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', NULL, '2016-10-29 17:10:18', NULL),
(6, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasd', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', NULL, '2016-10-29 17:11:23', NULL),
(7, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasd', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', NULL, '2016-10-29 17:11:37', NULL),
(8, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasd', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', NULL, '2016-10-29 17:12:07', NULL),
(9, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasd', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', NULL, '2016-10-29 17:12:35', NULL),
(10, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasdy', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'sadasd-sdas-dasdasdy', '2016-10-29 17:17:15', NULL),
(11, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasdy', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', NULL, '2016-10-29 17:17:17', NULL),
(12, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasdy', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'sadasd-sdas-dasdasdy-590', '2016-10-29 17:22:38', NULL),
(13, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasdy', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'sadasd-sdas-dasdasdy-831', '2016-10-29 17:22:42', NULL),
(14, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasdy', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'sadasd-sdas-dasdasdy-490', '2016-10-29 17:22:44', NULL),
(15, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasdy', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'sadasd-sdas-dasdasdy-650', '2016-10-29 17:22:46', NULL),
(16, 12, 'sdasjdk sdasdasd', 'sadasd sdas dasdasdy', 'sdsdxyzh', NULL, NULL, 4, 0, 1, '9947313547', 'sadasd-sdas-dasdasdy-970', '2016-10-29 18:57:41', NULL),
(18, 12, 'sales', 'Paint''s at low price', 'Paints at low price sdasdasdasds', '5000/-', NULL, 4, 0, 1, '9947313547', 'paints-at-low-price-619', '2016-11-02 20:58:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `offer_campaign`
--

CREATE TABLE `offer_campaign` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `base_title` varchar(200) NOT NULL,
  `offer_title` varchar(700) NOT NULL,
  `offer_description` varchar(5000) DEFAULT NULL,
  `offer_price` varchar(100) DEFAULT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `expires_on` date DEFAULT NULL,
  `contact_no` varchar(14) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offer_campaign`
--

INSERT INTO `offer_campaign` (`id`, `created_by`, `base_title`, `offer_title`, `offer_description`, `offer_price`, `gallery_id`, `views`, `expires_on`, `contact_no`, `slug`, `created_at`, `updated_at`) VALUES
(17, 12, 'Paints Campaign', 'Paints at low price', 'Paints at low price sdasdasdasds', '5000/-', 4, 0, '2016-10-31', '9947313547', '', '2016-10-31 19:22:13', NULL),
(18, 12, 'Paints Campaign', 'Paints at low price', 'Paints at low price sdasdasdasds', '5000/-', 4, 0, '2016-10-31', '9947313547', '-655', '2016-10-31 19:31:00', NULL),
(19, 12, 'Paint''s Campaign', 'Paints at low price', 'Paints at low price sdasdasdasds', '5000/-', 4, 0, '2016-10-31', '9947313547', '-590', '2016-10-31 19:31:16', NULL),
(22, 12, '‘ and 1 = any (select 1 from users)', 'Paints at low price', 'Paints at low price sdasdasdasds', '5000/-', 4, 0, '2016-10-31', '9947313547', '-694', '2016-10-31 19:34:59', NULL),
(23, 12, '(substring(version(),1,1)=5)', 'Paints at low price', 'Paints at low price sdasdasdasds', '5000/-', 4, 0, '2016-10-31', '9947313547', '-375', '2016-10-31 19:35:49', NULL),
(24, 12, 'Paint''s Campaign update', 'Paints at low price', 'Paints at low price sdasdasdasds', '55000/-', 14, 5, '2016-11-01', '9947313547', 'paints-at-low-price', '2016-11-01 18:46:32', '2016-11-01 19:06:04'),
(25, 12, '(substring(version(),1,1)=5)', 'Paint''s at low price', 'Paints at low price sdasdasdasds', '5000/-', 4, 0, '2016-11-01', '9947313547', 'paints-at-low-price-223', '2016-11-01 19:41:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `created_by`, `category_name`, `slug`, `parent_id`, `created_on`) VALUES
(20, 12, 'paints', '', NULL, '2016-11-02 17:38:12'),
(21, 12, 'paints and hr', 'paints', NULL, '2016-11-02 17:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `sales_campaign`
--

CREATE TABLE `sales_campaign` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `base_title` varchar(200) NOT NULL,
  `sales_title` varchar(700) NOT NULL,
  `sales_description` varchar(5000) DEFAULT NULL,
  `sales_price` varchar(20) DEFAULT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `contact_no` varchar(14) DEFAULT NULL,
  `showonlist` tinyint(1) NOT NULL DEFAULT '1',
  `slug` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_campaign`
--

INSERT INTO `sales_campaign` (`id`, `created_by`, `cat_id`, `base_title`, `sales_title`, `sales_description`, `sales_price`, `gallery_id`, `views`, `contact_no`, `showonlist`, `slug`, `created_at`, `updated_at`) VALUES
(1, 12, NULL, 'items1', 'itemsbase', '5000', NULL, 4, 0, '9947313547', 1, 'null', '2016-10-24 17:41:44', NULL),
(2, 12, NULL, 'items1', 'itemsbase', '5000', '8000', 4, 0, '9947313547', 1, 'null', '2016-10-24 17:42:31', NULL),
(10, 12, 32, 'sales', 'Paint''s at low price', 'Paints at low price sdasdasdasds', '5000/-', 4, 0, '9947313547', 1, '', '2016-11-02 18:56:39', NULL),
(11, 12, 32, 'sales', 'Paint''s at low price', 'Paints at low price sdasdasdasds', '5000/-', 4, 0, '9947313547', 0, '-470', '2016-11-02 18:57:22', NULL),
(13, 12, NULL, 'sales', 'Paint''s at low price', 'Paints at low price sdasdasdasds', '5000/-', 4, 1, '9947313547', 1, 'paints-at-low-price', '2016-11-02 18:58:29', '2016-11-02 19:00:15');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL DEFAULT '0',
  `home_configured` int(11) NOT NULL DEFAULT '0',
  `usage_count` int(11) NOT NULL DEFAULT '0',
  `def_mob` varchar(20) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  `token_expiry` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `template_id`, `home_configured`, `usage_count`, `def_mob`, `updated_on`, `token`, `token_expiry`) VALUES
(1, 0, 0, 0, NULL, NULL, NULL, NULL),
(2, 0, 0, 0, NULL, NULL, NULL, NULL),
(3, 0, 0, 0, NULL, NULL, NULL, NULL),
(4, 0, 0, 0, 'dsd', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `message` varchar(500) DEFAULT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  `rating` int(11) DEFAULT NULL,
  `image` varchar(120) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `created_by`, `name`, `message`, `hidden`, `rating`, `image`, `created_at`) VALUES
(1, 12, 'sdsd', 'sdasdsfsgfddsfasdfsa', 0, NULL, '5810f1743fb19', '2016-10-26 17:55:09'),
(3, 12, 'Alex', 'good', 1, 5, '581cc21753cc2', '2016-11-04 15:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE `urls` (
  `id` bigint(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `url` varchar(500) NOT NULL,
  `short` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `mobno` varchar(14) NOT NULL,
  `username` varchar(80) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(60) NOT NULL,
  `smspass` varchar(60) DEFAULT NULL,
  `apikey` varchar(100) DEFAULT NULL,
  `smskey` varchar(100) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `settings_id` int(11) NOT NULL,
  `act_stat` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `mobno`, `username`, `email`, `password`, `smspass`, `apikey`, `smskey`, `country_id`, `location_id`, `settings_id`, `act_stat`) VALUES
(12, 'Manzoor', 'Samad', '7736830600', 'testuser', 'manzoorsamad.in@gmail.com', 'hello123', 'hello123', 'bU7QB7duXkIDn9txXA6uIDkHHOHPQAS4nUQM1AkDw', 'bU7QB7duXkIDn9txXA6uIDkHHOHPQAS4nUQM1AkDw', NULL, NULL, 0, 1),
(13, 'samad', 'msd', '789', '564', '656', '45654', '646546', '56464', '4656', 564, NULL, 0, 0),
(14, NULL, NULL, '7736830601', 'manzoor', 'manzoorsamadin@gmail.com', '1234', '1234', '112', '112', NULL, NULL, 0, 0),
(15, NULL, NULL, '7736830601', 'manzoor', 'manzoorsamadin@gmail.com', '1234', '1234', '112', '112', NULL, NULL, 0, 1),
(16, 'dsd', 'dsd', 'dsd', 'dsd', 'dsd', 'dsd', NULL, 'e28240d271d37886ac912c03b8966c6443adfd79', NULL, NULL, NULL, 4, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domains`
--
ALTER TABLE `domains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra`
--
ALTER TABLE `extra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home`
--
ALTER TABLE `home`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_campaign`
--
ALTER TABLE `jobs_campaign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_campaign`
--
ALTER TABLE `offer_campaign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_campaign`
--
ALTER TABLE `sales_campaign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `urls`
--
ALTER TABLE `urls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;
--
-- AUTO_INCREMENT for table `domains`
--
ALTER TABLE `domains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `extra`
--
ALTER TABLE `extra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `home`
--
ALTER TABLE `home`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jobs_campaign`
--
ALTER TABLE `jobs_campaign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `offer_campaign`
--
ALTER TABLE `offer_campaign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `sales_campaign`
--
ALTER TABLE `sales_campaign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
