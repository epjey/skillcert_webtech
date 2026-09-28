-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2025 at 07:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skillcertified`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `certificate_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) NOT NULL,
  `status` enum('issued','revoked','reissued') NOT NULL DEFAULT 'issued',
  `issued_date` date NOT NULL,
  `certificate_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`certificate_id`, `user_id`, `course_id`, `status`, `issued_date`, `certificate_code`) VALUES
(7, 154, 19, 'issued', '2025-10-15', '34442F948E'),
(8, 154, 20, 'issued', '2025-10-15', '9F1653F67E'),
(9, 154, 22, 'issued', '2025-10-15', '18710C64EA'),
(10, 154, 23, 'issued', '2025-10-15', 'C5E396406D'),
(11, 155, 19, 'issued', '2025-10-15', '40786165FC'),
(12, 155, 20, 'issued', '2025-10-15', '625B5A76CF'),
(13, 155, 22, 'issued', '2025-10-15', '911389BA62'),
(14, 156, 38, 'issued', '2025-10-15', '4E071A9EEF'),
(15, 157, 19, 'issued', '2025-10-15', '05F50C23B7'),
(16, 158, 19, 'issued', '2025-10-15', '04BBA04A19'),
(17, 158, 20, 'issued', '2025-10-15', 'FB916BF111'),
(18, 158, 40, 'issued', '2025-10-15', '7260666356');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `completion_rate` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `completion_rate`, `description`, `created_at`) VALUES
(19, 'HTML Fundamentals', '', 'HTML is at the core of every web page. It’s beginner-friendly and knowing the basics is useful for everyone who works in digital design, marketing, content and more. If you’re interested in front-end web development, this course is a great place to start! You don’t need any previous coding experience, and we have plenty of other courses for you to deepen your knowledge once you’re finished, including CSS and JavaScipt.', '2025-10-05 18:54:31'),
(20, 'Introduction To CSS', '', 'CSS (Cascading Style Sheets) is a language used to style and design web pages. It controls how HTML elements look on the screen — like colors, fonts, spacing, and layout. With CSS, you can make your website more attractive and user-friendly.\n\nIt allows you to separate the content (HTML) from the design, making it easier to update and maintain your website. CSS can be written directly inside HTML, inside a <style> tag, or in a separate .css file.\n\nIn this lesson, you’ll learn the basics of how CSS works, how to connect it to your HTML, and how to use simple style rules to make your first web page look better.', '2025-10-05 18:55:00'),
(22, 'JavaScript Fundamentals', '', 'JavaScript is a programming language that makes websites interactive and dynamic. While HTML gives structure and CSS adds design, JavaScript adds behavior — it lets you respond to user actions, update content, and make your web pages come alive without reloading.\n\nIn this module, you will learn the basic parts of JavaScript such as variables, data types, operators, functions, and events. You will also learn how to use JavaScript to interact with HTML and change elements on the page.\n\nBy the end of this module, you’ll understand how JavaScript works and how to create simple scripts that make your website more functional and engaging.', '2025-10-06 08:23:45'),
(23, 'Bootstrap Fundamentals', '', 'Bootstrap is a popular front-end framework used for building responsive and mobile-friendly websites quickly. It provides ready-made CSS styles, layouts, and JavaScript components that help you design professional-looking pages without writing a lot of custom code.\n\nIn this module, you will learn how to use Bootstrap’s grid system, buttons, navigation bars, modals, and other UI components. You will also understand how to customize Bootstrap to match your own website design.\n\nBy the end of this lesson, you’ll be able to create modern and responsive web pages that automatically adjust to any screen size.', '2025-10-06 08:34:29'),
(38, 'PHP Fundamentals', '', 'PHP (Hypertext Preprocessor) is a server-side scripting language used to create dynamic and interactive websites. It works together with HTML to build pages that can display data from a database, handle forms, and perform many back-end functions.\n\nIn this module, you will learn the basics of PHP, including syntax, variables, loops, functions, and how to connect PHP with a database. You will also discover how PHP processes user input and sends information back to the browser.\n\nBy the end of this module, you’ll understand how to build simple web applications that can store, display, and manage data using PHP.', '2025-10-08 17:27:12'),
(40, 'MySQL', '', 'MySQL is a popular database management system used to store, organize, and manage data for websites and applications. It works with languages like PHP to save user information, display records, and perform data operations securely and efficiently.\n\nIn this module, you will learn how to create databases, design tables, and use SQL commands like SELECT, INSERT, UPDATE, and DELETE to manage data. You will also learn how to connect MySQL with PHP to build dynamic web applications.\n\nBy the end of this module, you’ll understand how to create and manage databases that make your website more powerful and data-driven.', '2025-10-09 08:39:28'),
(52, 'gff', '', 'fgh', '2025-10-14 05:07:11'),
(56, 'sdfsf', '', 'sdfsd', '2025-10-14 16:12:36'),
(57, 'sdfsf', '', 'sdfsf', '2025-10-14 16:13:18'),
(58, 'SDFS', '', 'FSDFS', '2025-10-14 20:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `exam_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `exam_title` varchar(255) NOT NULL,
  `total_items` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`exam_id`, `course_id`, `module_id`, `exam_title`, `total_items`, `created_at`) VALUES
(80, 19, 29, 'PRELIM EXAM', 6, '2025-10-14 18:47:57'),
(82, 19, 28, 'MIDTERM EXAM', 6, '2025-10-14 18:58:28'),
(83, 19, 13, 'FINALS EXAM', 6, '2025-10-14 18:58:50'),
(84, 20, 32, 'PRELIM EXAM', 6, '2025-10-14 19:54:08'),
(85, 20, 33, 'MIDTERM EXAM', 6, '2025-10-14 19:54:46'),
(86, 20, 34, 'FINALS EXAM', 6, '2025-10-14 19:55:09'),
(87, 22, 31, 'PRELIM EXAM', 6, '2025-10-14 21:15:28'),
(88, 22, 36, 'MIDTERM EXAM', 6, '2025-10-14 21:16:04'),
(89, 22, 37, 'FINALS EXAM', 6, '2025-10-14 21:16:26'),
(90, 23, 38, 'PRELIM EXAM', 6, '2025-10-15 06:26:53'),
(91, 23, 39, 'MIDTERM EXAM', 6, '2025-10-15 06:27:20'),
(92, 23, 40, 'FINALS EXAM', 6, '2025-10-15 06:27:35'),
(93, 38, 41, 'PRELIM EXAM', 6, '2025-10-15 07:07:06'),
(94, 38, 42, 'MIDTERM EXAM', 6, '2025-10-15 07:07:37'),
(95, 38, 43, 'FINALS EXAM', 6, '2025-10-15 07:07:53'),
(101, 40, 44, 'MIDTERM EXAM', 0, '2025-10-15 16:51:30'),
(102, 40, 45, 'FINALS EXAM', 0, '2025-10-15 16:51:44'),
(103, 40, 14, 'PRELIM EXAM', 0, '2025-10-15 16:53:07');

-- --------------------------------------------------------

--
-- Table structure for table `exam_answers`
--

CREATE TABLE `exam_answers` (
  `answer_id` int(10) UNSIGNED NOT NULL,
  `result_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `selected_answer` enum('A','B','C','D') NOT NULL,
  `is_correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_answers`
--

INSERT INTO `exam_answers` (`answer_id`, `result_id`, `question_id`, `selected_answer`, `is_correct`) VALUES
(313, 60, 207, 'A', 1),
(314, 60, 208, 'B', 1),
(315, 60, 209, 'A', 1),
(316, 60, 210, 'A', 1),
(317, 60, 211, 'C', 1),
(318, 60, 212, 'B', 1),
(319, 61, 225, 'A', 1),
(320, 61, 226, 'A', 1),
(321, 61, 227, 'A', 1),
(322, 61, 228, 'A', 1),
(323, 61, 229, 'A', 1),
(324, 61, 230, 'A', 1),
(325, 62, 231, 'A', 1),
(326, 62, 232, 'C', 1),
(327, 62, 233, 'B', 1),
(328, 62, 234, 'A', 1),
(329, 62, 235, 'B', 1),
(330, 62, 236, 'A', 1),
(331, 63, 237, 'B', 1),
(332, 63, 238, 'B', 1),
(333, 63, 239, 'A', 1),
(334, 63, 240, 'B', 1),
(335, 63, 241, 'C', 1),
(336, 63, 242, 'A', 1),
(337, 64, 243, 'B', 0),
(338, 64, 244, 'B', 1),
(339, 64, 245, 'A', 1),
(340, 64, 246, 'B', 1),
(341, 64, 247, 'B', 1),
(342, 64, 248, 'A', 1),
(343, 65, 249, 'B', 1),
(344, 65, 250, 'C', 1),
(345, 65, 251, 'A', 1),
(346, 65, 252, 'B', 1),
(347, 65, 253, 'B', 1),
(348, 65, 254, 'B', 1),
(349, 66, 255, 'B', 1),
(350, 66, 256, 'C', 1),
(351, 66, 257, 'B', 1),
(352, 66, 258, 'C', 1),
(353, 66, 259, 'B', 1),
(354, 66, 260, 'B', 1),
(355, 67, 261, 'B', 1),
(356, 67, 262, 'C', 1),
(357, 67, 263, 'B', 1),
(358, 67, 264, 'C', 1),
(359, 67, 265, 'B', 1),
(360, 67, 266, 'B', 1),
(361, 68, 267, 'A', 1),
(362, 68, 268, 'B', 1),
(363, 68, 269, 'B', 1),
(364, 68, 270, 'B', 1),
(365, 68, 271, 'C', 1),
(366, 68, 272, 'C', 1),
(367, 69, 273, 'B', 1),
(368, 69, 274, 'C', 1),
(369, 69, 275, '', 0),
(370, 69, 276, '', 0),
(371, 69, 277, '', 0),
(372, 69, 278, '', 0),
(373, 70, 273, '', 0),
(374, 70, 274, '', 0),
(375, 70, 275, '', 0),
(376, 70, 276, '', 0),
(377, 70, 277, '', 0),
(378, 70, 278, '', 0),
(379, 71, 273, '', 0),
(380, 71, 274, '', 0),
(381, 71, 275, '', 0),
(382, 71, 276, '', 0),
(383, 71, 277, '', 0),
(384, 71, 278, '', 0),
(385, 72, 273, '', 0),
(386, 72, 274, '', 0),
(387, 72, 275, '', 0),
(388, 72, 276, '', 0),
(389, 72, 277, '', 0),
(390, 72, 278, '', 0),
(391, 73, 273, 'B', 1),
(392, 73, 274, 'C', 1),
(393, 73, 275, 'A', 1),
(394, 73, 276, 'A', 1),
(395, 73, 277, 'B', 0),
(396, 73, 278, 'B', 1),
(397, 74, 279, 'C', 1),
(398, 74, 280, 'C', 1),
(399, 74, 281, 'B', 1),
(400, 74, 282, 'A', 1),
(401, 74, 283, 'C', 1),
(402, 74, 284, 'A', 1),
(403, 75, 285, 'A', 0),
(404, 75, 286, 'A', 1),
(405, 75, 287, 'B', 1),
(406, 75, 288, 'C', 1),
(407, 75, 289, 'B', 1),
(408, 75, 290, 'A', 0),
(419, 78, 207, 'A', 1),
(420, 78, 208, 'B', 1),
(421, 78, 209, 'C', 0),
(422, 78, 210, 'C', 0),
(423, 78, 211, 'D', 0),
(424, 78, 212, 'C', 0),
(425, 79, 225, 'A', 1),
(426, 79, 226, 'C', 0),
(427, 79, 227, 'D', 0),
(428, 79, 228, 'D', 0),
(429, 79, 229, 'D', 0),
(430, 79, 230, 'D', 0),
(431, 80, 231, 'D', 0),
(432, 80, 232, 'D', 0),
(433, 80, 233, 'D', 0),
(434, 80, 234, 'D', 0),
(435, 80, 235, 'D', 0),
(436, 80, 236, 'D', 0),
(437, 81, 231, 'C', 0),
(438, 81, 232, 'B', 0),
(439, 81, 233, 'C', 0),
(440, 81, 234, 'A', 1),
(441, 81, 235, 'A', 0),
(442, 81, 236, 'A', 1),
(443, 82, 231, 'B', 0),
(444, 82, 232, 'B', 0),
(445, 82, 233, 'B', 1),
(446, 82, 234, 'A', 1),
(447, 82, 235, 'B', 1),
(448, 82, 236, 'A', 1),
(449, 83, 231, 'A', 1),
(450, 83, 232, 'C', 1),
(451, 83, 233, 'B', 1),
(452, 83, 234, 'A', 1),
(453, 83, 235, 'B', 1),
(454, 83, 236, 'B', 0),
(455, 84, 237, 'B', 1),
(456, 84, 238, 'B', 1),
(457, 84, 239, 'A', 1),
(458, 84, 240, 'B', 1),
(459, 84, 241, 'C', 1),
(460, 84, 242, 'A', 1),
(461, 85, 243, 'A', 0),
(462, 85, 244, 'B', 1),
(463, 85, 245, 'B', 0),
(464, 85, 246, 'B', 1),
(465, 85, 247, 'B', 1),
(466, 85, 248, 'A', 1),
(467, 86, 243, 'C', 1),
(468, 86, 244, 'B', 1),
(469, 86, 245, 'A', 1),
(470, 86, 246, 'B', 1),
(471, 86, 247, 'B', 1),
(472, 86, 248, 'A', 1),
(473, 87, 249, 'B', 1),
(474, 87, 250, 'C', 1),
(475, 87, 251, 'C', 0),
(476, 87, 252, 'C', 0),
(477, 87, 253, 'C', 0),
(478, 87, 254, 'C', 0),
(479, 88, 249, 'B', 1),
(480, 88, 250, 'C', 1),
(481, 88, 251, 'A', 1),
(482, 88, 252, 'B', 1),
(483, 88, 253, 'B', 1),
(484, 88, 254, 'B', 1),
(485, 89, 255, 'B', 1),
(486, 89, 256, 'C', 1),
(487, 89, 257, 'B', 1),
(488, 89, 258, 'C', 1),
(489, 89, 259, 'B', 1),
(490, 89, 260, 'B', 1),
(491, 90, 261, 'B', 1),
(492, 90, 262, 'C', 1),
(493, 90, 263, 'B', 1),
(494, 90, 264, 'C', 1),
(495, 90, 265, 'B', 1),
(496, 90, 266, 'B', 1),
(497, 91, 267, 'B', 0),
(498, 91, 268, 'C', 0),
(499, 91, 269, 'C', 0),
(500, 91, 270, 'B', 1),
(501, 91, 271, 'C', 1),
(502, 91, 272, 'B', 0),
(503, 92, 267, 'B', 0),
(504, 92, 268, 'B', 1),
(505, 92, 269, 'B', 1),
(506, 92, 270, 'B', 1),
(507, 92, 271, 'C', 1),
(508, 92, 272, 'C', 1),
(509, 93, 273, 'D', 0),
(510, 93, 274, 'C', 1),
(511, 93, 275, 'C', 0),
(512, 93, 276, 'D', 0),
(513, 93, 277, 'C', 0),
(514, 93, 278, 'C', 0),
(515, 94, 291, 'B', 1),
(516, 94, 292, 'C', 1),
(517, 94, 293, 'D', 1),
(518, 94, 294, 'D', 1),
(519, 94, 295, 'B', 1),
(520, 94, 296, 'C', 1),
(521, 95, 297, 'B', 1),
(522, 95, 298, 'B', 1),
(523, 95, 299, 'C', 1),
(524, 95, 300, 'C', 1),
(525, 95, 301, 'C', 1),
(526, 95, 302, 'C', 0),
(527, 96, 303, 'B', 1),
(528, 96, 304, 'A', 1),
(529, 96, 305, 'B', 0),
(530, 96, 306, 'C', 1),
(531, 96, 307, 'A', 1),
(532, 96, 308, 'B', 1),
(533, 97, 237, 'B', 1),
(534, 97, 238, 'B', 1),
(535, 97, 239, 'A', 1),
(536, 97, 240, 'B', 1),
(537, 97, 241, 'C', 1),
(538, 97, 242, 'A', 1),
(539, 98, 207, 'A', 1),
(540, 98, 208, 'B', 1),
(541, 98, 209, 'A', 1),
(542, 98, 210, 'A', 1),
(543, 98, 211, 'C', 1),
(544, 98, 212, 'B', 1),
(545, 99, 225, 'A', 1),
(546, 99, 226, 'A', 1),
(547, 99, 227, 'A', 1),
(548, 99, 228, 'A', 1),
(549, 99, 229, 'A', 1),
(550, 99, 230, 'A', 1),
(551, 100, 231, 'A', 1),
(552, 100, 232, 'C', 1),
(553, 100, 233, 'B', 1),
(554, 100, 234, 'A', 1),
(555, 100, 235, 'B', 1),
(556, 100, 236, 'A', 1),
(557, 101, 207, 'A', 1),
(558, 101, 208, 'B', 1),
(559, 101, 209, 'A', 1),
(560, 101, 210, 'A', 1),
(561, 101, 211, 'C', 1),
(562, 101, 212, 'B', 1),
(563, 102, 225, 'C', 0),
(564, 102, 226, 'C', 0),
(565, 102, 227, 'C', 0),
(566, 102, 228, 'C', 0),
(567, 102, 229, 'A', 1),
(568, 102, 230, 'A', 1),
(569, 103, 225, 'A', 1),
(570, 103, 226, 'A', 1),
(571, 103, 227, 'A', 1),
(572, 103, 228, 'A', 1),
(573, 103, 229, 'A', 1),
(574, 103, 230, 'A', 1),
(575, 104, 231, 'A', 1),
(576, 104, 232, 'C', 1),
(577, 104, 233, 'B', 1),
(578, 104, 234, 'A', 1),
(579, 104, 235, 'B', 1),
(580, 104, 236, 'A', 1),
(581, 105, 237, 'B', 1),
(582, 105, 238, 'B', 1),
(583, 105, 239, 'A', 1),
(584, 105, 240, 'B', 1),
(585, 105, 241, 'C', 1),
(586, 105, 242, 'A', 1),
(587, 106, 243, 'C', 1),
(588, 106, 244, 'B', 1),
(589, 106, 245, 'A', 1),
(590, 106, 246, 'B', 1),
(591, 106, 247, 'B', 1),
(592, 106, 248, 'A', 1),
(593, 107, 249, 'B', 1),
(594, 107, 250, 'C', 1),
(595, 107, 251, 'A', 1),
(596, 107, 252, 'B', 1),
(597, 107, 253, 'B', 1),
(598, 107, 254, 'B', 1),
(604, 109, 349, 'C', 1),
(605, 109, 350, 'A', 1),
(606, 109, 351, 'A', 1),
(607, 109, 352, 'A', 1),
(608, 109, 353, 'B', 1),
(609, 110, 339, 'B', 1),
(610, 110, 340, 'B', 1),
(611, 110, 341, 'A', 0),
(612, 110, 342, 'B', 1),
(613, 110, 343, 'C', 0),
(614, 111, 339, 'B', 1),
(615, 111, 340, 'A', 0),
(616, 111, 341, 'B', 1),
(617, 111, 342, 'B', 1),
(618, 111, 343, 'C', 0),
(619, 112, 339, 'B', 1),
(620, 112, 340, 'B', 1),
(621, 112, 341, 'B', 1),
(622, 112, 342, 'B', 1),
(623, 112, 343, 'C', 0),
(624, 113, 344, 'B', 1),
(625, 113, 345, 'B', 1),
(626, 113, 346, 'B', 1),
(627, 113, 347, 'B', 1),
(628, 113, 348, 'B', 1),
(629, 114, 291, 'B', 1),
(630, 114, 292, 'C', 1),
(631, 114, 293, 'D', 1),
(632, 114, 294, 'D', 1),
(633, 114, 295, 'B', 1),
(634, 114, 296, 'C', 1),
(635, 115, 339, 'B', 1),
(636, 115, 340, 'B', 1),
(637, 115, 341, 'B', 1),
(638, 115, 342, 'B', 1),
(639, 115, 343, 'B', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `question_id` int(10) UNSIGNED NOT NULL,
  `exam_id` int(10) UNSIGNED NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_answer` enum('A','B','C','D') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`question_id`, `exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(207, 80, 'What does HTML stand for?', 'HyperText Markup Language', 'Hyper Transfer Markup Language', 'HighText Machine Language', 'HyperText Markdown Language', 'A'),
(208, 80, 'Which tag is used to define a paragraph?', '<div>', '<p>', '<h1>', '<text>', 'B'),
(209, 80, 'Which of the following is a correct HTML document structure?', '<html><head><title></title></head><body></body></html>', '<head><html><body></body></html></head>', '<html><body><head></head></body></html>', '<head><title></title><body></body></head>', 'A'),
(210, 80, 'What tag is used to make text bold in HTML?', '<b>', '<i>', '<bold>', '<stronger>', 'A'),
(211, 80, 'Which attribute is used to define the destination of a hyperlink?', 'src', 'link', 'href', 'target', 'C'),
(212, 80, 'What does the <br> tag do?', 'Creates a bold line', 'Creates a line break', 'Creates a table row', 'Creates a paragraph', 'B'),
(225, 82, 'Which tag is used for an unordered list?', '<ul>', '<ol>', '<li>', '<list>', 'A'),
(226, 82, 'What tag inserts an image in HTML?', '<img>', '<image>', '<src>', '<pic>', 'A'),
(227, 82, 'Which attribute defines alternative text for an image?', 'alt', 'src', 'title', 'name', 'A'),
(228, 82, 'Which tag is used to create a table row?', '<tr>', '<td>', '<th>', '<table>', 'A'),
(229, 82, 'Which tag is used to describe a term in a description list?', '<dt>', '<dd>', '<li>', '<dl>', 'A'),
(230, 82, 'Which tag is used to embed a YouTube video?', '<iframe>', '<embed>', '<video>', '<src>', 'A'),
(231, 83, 'Which HTML tag is used to create a form?', '<form>', '<input>', '<submit>', '<table>', 'A'),
(232, 83, 'What attribute specifies the file that will process the form data?', 'href', 'src', 'action', 'method', 'C'),
(233, 83, 'Which input type is used for passwords?', '<input type=\'secret\'>', '<input type=\'password\'>', '<input type=\'text\'>', '<password>', 'B'),
(234, 83, 'What is the correct semantic tag for page navigation?', '<nav>', '<header>', '<menu>', '<path>', 'A'),
(235, 83, 'Which element defines the footer of a page?', '<bottom>', '<footer>', '<end>', '<section>', 'B'),
(236, 83, 'Which tag group helps to create meaning in your layout?', 'Semantic tags', 'Design tags', 'Format tags', 'Display tags', 'A'),
(237, 84, 'What does CSS stand for?', 'Creative Style Sheets', 'Cascading Style Sheets', 'Computer Style System', 'Colorful Style Syntax', 'B'),
(238, 84, 'Which HTML tag is used to link an external CSS file?', '<style>', '<link>', '<css>', '<head>', 'B'),
(239, 84, 'Which symbol is used for a class selector in CSS?', '.', '#', '*', '&', 'A'),
(240, 84, 'Which of the following is the correct CSS syntax?', 'body:color=black;', 'body {color: black;}', '{body:color=black;}', 'body(color:black);', 'B'),
(241, 84, 'How do you write a comment in CSS?', '// comment', '<!-- comment -->', '/* comment */', '** comment **', 'C'),
(242, 84, 'Which type of CSS is written inside the HTML element itself?', 'Inline CSS', 'Internal CSS', 'External CSS', 'Import CSS', 'A'),
(243, 85, 'Which property is used to change the text color?', 'font-color', 'text-color', 'color', 'background-color', 'C'),
(244, 85, 'Which value of background-repeat shows the image only once?', 'repeat', 'no-repeat', 'repeat-x', 'repeat-y', 'B'),
(245, 85, 'Which property changes the size of the text?', 'font-size', 'text-size', 'text-height', 'font-weight', 'A'),
(246, 85, 'What does the border-radius property do?', 'Adds shadow to text', 'Rounds the corners', 'Adds color to the background', 'Changes text spacing', 'B'),
(247, 85, 'Which part of the box model creates space inside the border?', 'Margin', 'Padding', 'Content', 'Outline', 'B'),
(248, 85, 'Which value makes the box-sizing include padding and border?', 'border-box', 'content-box', 'box-fit', 'full-box', 'A'),
(249, 86, 'Which property controls the visibility of an element?', 'display', 'visibility', 'show', 'opacity', 'B'),
(250, 86, 'What is the default position value in CSS?', 'relative', 'absolute', 'static', 'fixed', 'C'),
(251, 86, 'Which display value puts elements in a flexible container?', 'flex', 'grid', 'block', 'inline', 'A'),
(252, 86, 'Which property sets the order of overlapping elements?', 'position', 'z-index', 'float', 'overflow', 'B'),
(253, 86, 'Which property helps make a website responsive?', 'animation', 'media queries', 'hover', 'background', 'B'),
(254, 86, 'Which unit is often used for responsive widths?', 'px', '%', 'pt', 'cm', 'B'),
(255, 87, 'What is JavaScript mainly used for?', 'Styling web pages', 'Making web pages interactive', 'Creating databases', 'Hosting websites', 'B'),
(256, 87, 'Which HTML tag is used to include JavaScript?', '<javascript>', '<js>', '<script>', '<code>', 'C'),
(257, 87, 'Which command shows output in the browser console?', 'alert()', 'console.log()', 'print()', 'write()', 'B'),
(258, 87, 'Which keyword is used to declare a variable that can change?', 'const', 'static', 'let', 'define', 'C'),
(259, 87, 'Which symbol is used for single-line comments?', '/* */', '//', '<!-- -->', '** **', 'B'),
(260, 87, 'What does \'===\' mean in JavaScript?', 'Assign value', 'Compare both value and type', 'Compare value only', 'Check undefined', 'B'),
(261, 88, 'Which statement is used to perform different actions based on conditions?', 'for', 'switch', 'loop', 'case', 'B'),
(262, 88, 'Which loop will run at least once?', 'for', 'while', 'do...while', 'none', 'C'),
(263, 88, 'Which keyword stops a loop early?', 'end', 'break', 'continue', 'stop', 'B'),
(264, 88, 'Which keyword is used to create a function?', 'method', 'func', 'function', 'define', 'C'),
(265, 88, 'What does a return statement do?', 'Stops the code', 'Ends the function and gives a value', 'Starts a loop', 'Declares a variable', 'B'),
(266, 88, 'Which scope type is visible everywhere in the code?', 'Local', 'Global', 'Block', 'Inner', 'B'),
(267, 89, 'What does DOM stand for?', 'Document Object Model', 'Data Object Module', 'Document Oriented Markup', 'Display Object Model', 'A'),
(268, 89, 'Which method gets an element by its ID?', 'querySelector()', 'getElementById()', 'getElementsByClass()', 'findById()', 'B'),
(269, 89, 'Which event runs code when a button is clicked?', 'onload', 'onclick', 'onchange', 'onsubmit', 'B'),
(270, 89, 'Which property changes an element\'s text?', 'innerText', 'textContent', 'value', 'htmlText', 'B'),
(271, 89, 'Which method adds an event listener?', 'addEvent()', 'onEvent()', 'addEventListener()', 'createEvent()', 'C'),
(272, 89, 'How do you access the first item in an array called fruits?', 'fruits.1', 'fruits.first()', 'fruits[0]', 'fruits.get(0)', 'C'),
(273, 90, 'What is Bootstrap mainly used for?', 'Creating databases', 'Designing responsive websites', 'Hosting web servers', 'Writing JavaScript code', 'B'),
(274, 90, 'What version of Bootstrap is the latest?', 'Bootstrap 3', 'Bootstrap 4', 'Bootstrap 5', 'Bootstrap 2', 'C'),
(275, 90, 'Which HTML tag is used to link Bootstrap using CDN?', '<link>', '<script>', '<import>', '<style>', 'A'),
(276, 90, 'What is the purpose of the container class in Bootstrap?', 'Add spacing and alignment', 'Hide elements', 'Create borders', 'Add background color', 'A'),
(277, 90, 'How many columns does Bootstrap’s grid system use?', '6', '8', '10', '12', 'D'),
(278, 90, 'Which class gives a full-width container?', '.container', '.container-fluid', '.row', '.col', 'B'),
(279, 91, 'Which class is used for the main heading style?', '.text-heading', '.lead', '.h1', '.heading', 'C'),
(280, 91, 'Which class centers text in Bootstrap?', '.text-left', '.text-middle', '.text-center', '.text-align', 'C'),
(281, 91, 'Which class gives a primary color to text?', '.text-main', '.text-primary', '.text-color', '.color-primary', 'B'),
(282, 91, 'Which class is used to create a button?', '.btn', '.button', '.click', '.press', 'A'),
(283, 91, 'Which alert class shows success messages?', '.alert-error', '.alert-danger', '.alert-success', '.alert-warning', 'C'),
(284, 91, 'Which class adds margin spacing at the bottom of elements?', '.mb-3', '.mt-3', '.padding', '.space', 'A'),
(285, 92, 'Which class creates a navbar in Bootstrap?', '.nav', '.navbar', '.navigation', '.header', 'B'),
(286, 92, 'Which class is used for navigation links?', '.nav-link', '.navbar-item', '.link', '.menu-item', 'A'),
(287, 92, 'Which class is used to make a navbar responsive?', '.navbar-collapse', '.navbar-expand-lg', '.navbar-toggle', '.nav-responsive', 'B'),
(288, 92, 'Which class creates a Bootstrap card?', '.panel', '.box', '.card', '.content', 'C'),
(289, 92, 'Which class is used for a modal popup?', '.popup', '.modal', '.alert', '.window', 'B'),
(290, 92, 'Which class adds a dark background to a footer?', '.footer-dark', '.bg-dark', '.background-black', '.footer-bg', 'B'),
(291, 93, 'What does PHP stand for?', 'Personal Home Page', 'PHP: Hypertext Preprocessor', 'Preprocessed HTML Program', 'Programming Hypertext Processor', 'B'),
(292, 93, 'Which symbol is used to declare a variable in PHP?', '@', '#', '$', '&', 'C'),
(293, 93, 'Which function is used to print text in PHP?', 'print()', 'write()', 'display()', 'echo()', 'D'),
(294, 93, 'Which of the following is NOT a PHP data type?', 'String', 'Integer', 'Boolean', 'Character', 'D'),
(295, 93, 'Which tag is used to start PHP code?', '<%', '<?php', '<script>', '<code>', 'B'),
(296, 93, 'Which statement is used to include an external PHP file?', 'add()', 'import()', 'include()', 'requirehtml()', 'C'),
(297, 94, 'Which loop runs code a specific number of times?', 'while', 'for', 'foreach', 'if', 'B'),
(298, 94, 'What is the correct syntax for an if statement?', 'if condition {}', 'if (condition) {}', 'if {condition}', 'if condition;', 'B'),
(299, 94, 'Which keyword is used to stop a loop?', 'exit', 'stop', 'break', 'end', 'C'),
(300, 94, 'How do you define a function in PHP?', 'create()', 'def()', 'function()', 'func()', 'C'),
(301, 94, 'Which statement calls a function named greet?', 'call greet()', 'run greet()', 'greet();', 'start greet()', 'C'),
(302, 94, 'Which function returns the length of a string?', 'strlen()', 'count()', 'size()', 'textlen()', 'A'),
(303, 95, 'Which superglobal is used for form data sent using POST?', '$_GET', '$_POST', '$_FORM', '$_DATA', 'B'),
(304, 95, 'What function converts special characters to HTML entities?', 'htmlspecialchars()', 'encode()', 'safe_input()', 'cleanData()', 'A'),
(305, 95, 'Which of the following creates an associative array?', '$arr = array(1,2,3);', '$arr = [1,2,3];', '$arr = array(\'name\'=>\'John\');', '$arr = (\'a\',\'b\');', 'C'),
(306, 95, 'Which function connects to a MySQL database?', 'connect_db()', 'mysql()', 'mysqli_connect()', 'db_open()', 'C'),
(307, 95, 'Which function runs a SQL query?', 'mysqli_query()', 'query_run()', 'db_query()', 'sql_run()', 'A'),
(308, 95, 'Which function retrieves rows from a query result?', 'fetch_array()', 'mysqli_fetch_assoc()', 'get_rows()', 'result()', 'B'),
(339, 101, 'Which command updates a record in MySQL?', 'CHANGE TABLE', 'UPDATE', 'ALTER', 'MODIFY', 'B'),
(340, 101, 'What does DELETE FROM students do?', 'Removes a table', 'Deletes data from a table', 'Deletes a column', 'Deletes a database', 'B'),
(341, 101, 'Which keyword is used to filter results in MySQL?', 'FILTER', 'WHERE', 'LIMIT', 'GROUP', 'B'),
(342, 101, 'What does ORDER BY do in SQL?', 'Arranges rows randomly', 'Sorts results', 'Filters rows', 'Joins tables', 'B'),
(343, 101, 'Which function counts total rows in a table?', 'TOTAL()', 'COUNT()', 'SUM()', 'ROWCOUNT()', 'B'),
(344, 102, 'What is a foreign key used for in MySQL?', 'To uniquely identify a record', 'To link tables together', 'To delete foreign tables', 'To create indexes', 'B'),
(345, 102, 'Which join returns only matching records from both tables?', 'LEFT JOIN', 'INNER JOIN', 'RIGHT JOIN', 'CROSS JOIN', 'B'),
(346, 102, 'Which join includes all rows from the left table even if there\'s no match?', 'INNER JOIN', 'LEFT JOIN', 'FULL JOIN', 'UNION', 'B'),
(347, 102, 'Which function connects PHP with MySQL?', 'connect()', 'mysqli_connect()', 'db_connect()', 'connect_db()', 'B'),
(348, 102, 'What PHP function is used to execute a query?', 'execute()', 'mysqli_query()', 'query_run()', 'run_sql()', 'B'),
(349, 103, 'What is MySQL used for?', 'Frontend development', 'Server hosting', 'Data management', 'Networking', 'C'),
(350, 103, 'Which command creates a new database in MySQL?', 'CREATE DATABASE db_name;', 'CREATE TABLE db_name;', 'USE DATABASE;', 'CREATE SCHEMA;', 'A'),
(351, 103, 'How do you select all data from a table named \'students\'?', 'SELECT * FROM students;', 'SHOW TABLES;', 'INSERT INTO students;', 'VIEW TABLE students;', 'A'),
(352, 103, 'Which MySQL tool is web-based and often used with PHP?', 'phpMyAdmin', 'VS Code', 'XAMPP Control Panel', 'GitHub', 'A'),
(353, 103, 'What command is used to choose a database before creating tables?', 'SELECT DATABASE', 'USE db_name;', 'CHOOSE DATABASE', 'OPEN DATABASE', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `result_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `exam_id` int(10) UNSIGNED NOT NULL,
  `score` int(10) UNSIGNED NOT NULL,
  `percentage` float NOT NULL,
  `status` enum('passed','failed') NOT NULL,
  `taken_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`result_id`, `user_id`, `exam_id`, `score`, `percentage`, `status`, `taken_at`) VALUES
(60, 154, 80, 6, 100, 'passed', '2025-10-15 07:49:19'),
(61, 154, 82, 6, 100, 'passed', '2025-10-15 07:49:55'),
(62, 154, 83, 6, 100, 'passed', '2025-10-15 07:50:33'),
(63, 154, 84, 6, 100, 'passed', '2025-10-15 07:52:08'),
(64, 154, 85, 5, 83.33, 'passed', '2025-10-15 07:52:44'),
(65, 154, 86, 6, 100, 'passed', '2025-10-15 07:53:21'),
(66, 154, 87, 6, 100, 'passed', '2025-10-15 07:54:09'),
(67, 154, 88, 6, 100, 'passed', '2025-10-15 07:54:45'),
(68, 154, 89, 6, 100, 'passed', '2025-10-15 07:55:10'),
(69, 154, 90, 2, 33.33, 'failed', '2025-10-15 08:20:06'),
(70, 154, 90, 0, 0, 'failed', '2025-10-15 08:33:17'),
(71, 154, 90, 0, 0, 'failed', '2025-10-15 08:33:30'),
(72, 154, 90, 0, 0, 'failed', '2025-10-15 08:46:27'),
(73, 154, 90, 5, 83.33, 'passed', '2025-10-15 08:52:48'),
(74, 154, 91, 6, 100, 'passed', '2025-10-15 11:27:00'),
(75, 154, 92, 4, 66.67, 'passed', '2025-10-15 12:36:36'),
(78, 155, 80, 2, 33.33, 'passed', '2025-10-15 15:01:51'),
(79, 155, 82, 1, 16.67, 'passed', '2025-10-15 15:03:30'),
(80, 155, 83, 0, 0, 'failed', '2025-10-15 15:09:20'),
(81, 155, 83, 2, 33, 'failed', '2025-10-15 15:09:36'),
(82, 155, 83, 4, 66, 'failed', '2025-10-15 15:09:50'),
(83, 155, 83, 5, 83, 'passed', '2025-10-15 15:10:12'),
(84, 155, 84, 6, 100, 'passed', '2025-10-15 15:14:21'),
(85, 155, 85, 4, 66, 'failed', '2025-10-15 15:15:06'),
(86, 155, 85, 6, 100, 'passed', '2025-10-15 15:15:22'),
(87, 155, 86, 2, 33, 'failed', '2025-10-15 15:15:58'),
(88, 155, 86, 6, 100, 'passed', '2025-10-15 15:16:17'),
(89, 155, 87, 6, 100, 'passed', '2025-10-15 15:17:03'),
(90, 155, 88, 6, 100, 'passed', '2025-10-15 15:17:57'),
(91, 155, 89, 2, 33, 'failed', '2025-10-15 15:26:41'),
(92, 155, 89, 5, 83, 'passed', '2025-10-15 15:29:09'),
(93, 155, 90, 1, 16, 'failed', '2025-10-15 15:41:06'),
(94, 156, 93, 6, 100, 'passed', '2025-10-15 15:48:56'),
(95, 156, 94, 5, 83, 'passed', '2025-10-15 15:50:05'),
(96, 156, 95, 5, 83, 'passed', '2025-10-15 15:50:58'),
(97, 156, 84, 6, 100, 'passed', '2025-10-15 16:00:47'),
(98, 157, 80, 6, 100, 'passed', '2025-10-15 16:05:49'),
(99, 157, 82, 6, 100, 'passed', '2025-10-15 16:07:04'),
(100, 157, 83, 6, 100, 'passed', '2025-10-15 16:07:40'),
(101, 158, 80, 6, 100, 'passed', '2025-10-15 16:32:05'),
(102, 158, 82, 2, 33, 'failed', '2025-10-15 16:32:35'),
(103, 158, 82, 6, 100, 'passed', '2025-10-15 16:32:50'),
(104, 158, 83, 6, 100, 'passed', '2025-10-15 16:33:17'),
(105, 158, 84, 6, 100, 'passed', '2025-10-15 16:34:12'),
(106, 158, 85, 6, 100, 'passed', '2025-10-15 16:34:44'),
(107, 158, 86, 6, 100, 'passed', '2025-10-15 16:35:13'),
(109, 158, 103, 5, 100, 'passed', '2025-10-15 16:53:42'),
(110, 158, 101, 3, 60, 'failed', '2025-10-15 16:55:41'),
(111, 158, 101, 3, 60, 'failed', '2025-10-15 16:55:56'),
(112, 158, 101, 4, 80, 'passed', '2025-10-15 16:56:18'),
(113, 158, 102, 5, 100, 'passed', '2025-10-15 16:56:55'),
(114, 158, 93, 6, 100, 'passed', '2025-10-15 17:01:04'),
(115, 154, 101, 5, 100, 'passed', '2025-10-15 17:33:41');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lesson_title` varchar(255) NOT NULL,
  `lesson_description` text NOT NULL,
  `content` text DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `module_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `course_id`, `lesson_title`, `lesson_description`, `content`, `file`, `module_id`) VALUES
(82, 19, 'HTML Forms', '', NULL, '', 13),
(83, 19, 'Semantic HTML and Structure Tags', '', NULL, '', 13),
(84, 19, 'Combining Everything', '', NULL, '', 13),
(108, 19, 'Working with Lists', '', NULL, '', 28),
(109, 19, 'Images and Multimedia', '', NULL, '', 28),
(110, 19, 'Tables', '', NULL, '', 28),
(112, 19, 'Getting Started with HTML', '', NULL, '', 29),
(113, 19, 'Basic HTML Tags', '', NULL, '', 29),
(114, 19, 'Text Formatting and Links', '', NULL, '', 29),
(115, 22, 'Getting Started with JavaScript', '', NULL, '', 31),
(116, 22, 'JavaScript Syntax and Variables', '', NULL, '', 31),
(117, 20, 'What is CSS and How It Works', '', NULL, '', 32),
(118, 20, 'Adding CSS to a Webpage', '', NULL, '', 32),
(119, 20, 'CSS Selectors and Comments', '', NULL, '', 32),
(120, 20, 'Working with Colors and Backgrounds', '', NULL, '', 33),
(121, 20, 'Text and Font Styling', '', NULL, '', 33),
(122, 20, 'Box Model', '', NULL, '', 33),
(123, 20, 'Display and Position', '', NULL, '', 34),
(124, 20, 'Flexbox Layout', '', NULL, '', 34),
(125, 20, 'Responsive Design Basics', '', NULL, '', 34),
(127, 22, 'Data Types and Operators', '', NULL, '', 31),
(128, 22, 'Conditional Statements', '', NULL, '', 36),
(129, 22, 'Loops and Iteration', '', NULL, '', 36),
(130, 22, 'Functions and Scope', '', NULL, '', 36),
(131, 22, 'Introduction to the DOM', '', NULL, '', 37),
(132, 22, 'Handling Events', '', NULL, '', 37),
(133, 22, 'Arrays and Objects', '', NULL, '', 37),
(134, 23, 'What is Bootstrap?', '', NULL, '', 38),
(135, 23, 'Setting Up Bootstrap', '', NULL, '', 38),
(136, 23, 'Understanding the Grid System', '', NULL, '', 38),
(137, 23, 'Typography and Colors', '', NULL, '', 39),
(138, 23, 'Buttons and Alerts', '', NULL, '', 39),
(139, 23, 'Forms and Inputs', '', NULL, '', 39),
(140, 23, 'Navigation Bar (Navbar)', '', NULL, '', 40),
(141, 23, 'Cards and Modals', '', NULL, '', 40),
(142, 23, 'Carousel and Footer', '', NULL, '', 40),
(143, 38, 'Getting Started with PHP', '', NULL, '', 41),
(144, 38, 'PHP Syntax and Comments', '', NULL, '', 41),
(145, 38, 'Variables and Data Types', '', NULL, '', 41),
(146, 38, 'Conditional Statements', '', NULL, '', 42),
(147, 38, 'Loops', '', NULL, '', 42),
(148, 38, 'Functions', '', NULL, '', 42),
(149, 38, 'Working with Forms', '', NULL, '', 43),
(150, 38, 'Arrays', '', NULL, '', 43),
(151, 38, 'PHP and MySQL', '', NULL, '', 43),
(152, 40, 'What is MySQL', '', NULL, '', 14),
(153, 40, 'Databases and Tables', '', NULL, '', 14),
(154, 40, 'Inserting and Viewing Data', '', NULL, '', 14),
(155, 40, 'Updating and Deleting Data', '', NULL, '', 44),
(156, 40, 'Filtering and Sorting Data', '', NULL, '', 44),
(157, 40, 'Aggregate Functions', '', NULL, '', 44),
(158, 40, 'Table Relationships', '', NULL, '', 45),
(159, 40, 'Joining Tables', '', NULL, '', 45),
(160, 40, 'Connecting MySQL with PHP', '', NULL, '', 45);

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `status` enum('completed','in_progress') NOT NULL DEFAULT 'in_progress',
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `user_id`, `course_id`, `lesson_id`, `status`, `completed`, `completed_at`) VALUES
(575, 154, 19, 112, 'completed', 0, '2025-10-15 07:48:53'),
(576, 154, 19, 113, 'completed', 0, '2025-10-15 07:48:58'),
(578, 154, 19, 114, 'completed', 0, '2025-10-15 07:49:02'),
(580, 154, 19, 108, 'completed', 0, '2025-10-15 07:49:34'),
(581, 154, 19, 109, 'completed', 0, '2025-10-15 07:49:38'),
(583, 154, 19, 110, 'completed', 0, '2025-10-15 07:49:44'),
(585, 154, 19, 82, 'completed', 0, '2025-10-15 07:50:04'),
(586, 154, 19, 83, 'completed', 0, '2025-10-15 07:50:08'),
(588, 154, 19, 84, 'completed', 0, '2025-10-15 07:50:13'),
(590, 154, 20, 117, 'completed', 0, '2025-10-15 07:51:36'),
(591, 154, 20, 118, 'completed', 0, '2025-10-15 07:51:43'),
(593, 154, 20, 119, 'completed', 0, '2025-10-15 07:51:47'),
(595, 154, 20, 120, 'completed', 0, '2025-10-15 07:52:15'),
(597, 154, 20, 121, 'completed', 0, '2025-10-15 07:52:20'),
(599, 154, 20, 122, 'completed', 0, '2025-10-15 07:52:26'),
(601, 154, 20, 123, 'completed', 0, '2025-10-15 07:52:54'),
(603, 154, 20, 124, 'completed', 0, '2025-10-15 07:53:00'),
(605, 154, 20, 125, 'completed', 0, '2025-10-15 07:53:08'),
(607, 154, 22, 115, 'completed', 0, '2025-10-15 07:53:36'),
(608, 154, 22, 116, 'completed', 0, '2025-10-15 07:53:41'),
(610, 154, 22, 127, 'completed', 0, '2025-10-15 07:53:45'),
(612, 154, 22, 128, 'completed', 0, '2025-10-15 07:54:14'),
(614, 154, 22, 129, 'completed', 0, '2025-10-15 07:54:19'),
(616, 154, 22, 130, 'completed', 0, '2025-10-15 07:54:24'),
(618, 154, 22, 131, 'completed', 0, '2025-10-15 07:54:50'),
(620, 154, 22, 132, 'completed', 0, '2025-10-15 07:54:54'),
(622, 154, 22, 133, 'completed', 0, '2025-10-15 07:54:57'),
(624, 154, 23, 134, 'completed', 0, '2025-10-15 08:19:30'),
(625, 154, 23, 135, 'completed', 0, '2025-10-15 08:19:32'),
(627, 154, 23, 136, 'completed', 0, '2025-10-15 08:19:36'),
(629, 154, 23, 137, 'completed', 0, '2025-10-15 11:25:36'),
(631, 154, 23, 138, 'completed', 0, '2025-10-15 11:25:49'),
(645, 154, 23, 139, 'completed', 0, '2025-10-15 11:26:37'),
(647, 154, 23, 140, 'completed', 0, '2025-10-15 11:27:11'),
(649, 154, 23, 141, 'completed', 0, '2025-10-15 11:57:55'),
(651, 154, 23, 142, 'completed', 0, '2025-10-15 12:36:14'),
(653, 154, 40, 152, 'completed', 0, '2025-10-15 14:52:04'),
(654, 154, 40, 153, 'completed', 0, '2025-10-15 14:52:07'),
(656, 154, 40, 154, 'completed', 0, '2025-10-15 14:52:11'),
(658, 154, 40, 155, 'completed', 0, '2025-10-15 14:54:02'),
(660, 154, 40, 156, 'completed', 0, '2025-10-15 14:54:04'),
(662, 154, 40, 157, 'completed', 0, '2025-10-15 14:54:08'),
(664, 154, 40, 158, 'completed', 0, '2025-10-15 17:33:51'),
(665, 155, 19, 112, 'completed', 0, '2025-10-15 15:01:35'),
(666, 155, 19, 113, 'completed', 0, '2025-10-15 15:01:38'),
(668, 155, 19, 114, 'completed', 0, '2025-10-15 15:01:44'),
(670, 155, 19, 108, 'completed', 0, '2025-10-15 15:03:14'),
(671, 155, 19, 109, 'completed', 0, '2025-10-15 15:03:17'),
(673, 155, 19, 110, 'completed', 0, '2025-10-15 15:03:22'),
(675, 155, 19, 82, 'completed', 0, '2025-10-15 15:09:06'),
(676, 155, 19, 83, 'completed', 0, '2025-10-15 15:09:09'),
(678, 155, 19, 84, 'completed', 0, '2025-10-15 15:09:12'),
(680, 155, 20, 117, 'completed', 0, '2025-10-15 15:14:00'),
(681, 155, 20, 118, 'completed', 0, '2025-10-15 15:14:03'),
(683, 155, 20, 119, 'completed', 0, '2025-10-15 15:14:07'),
(685, 155, 20, 120, 'completed', 0, '2025-10-15 15:14:42'),
(687, 155, 20, 121, 'completed', 0, '2025-10-15 15:14:46'),
(689, 155, 20, 122, 'completed', 0, '2025-10-15 15:14:52'),
(691, 155, 20, 123, 'completed', 0, '2025-10-15 15:15:30'),
(693, 155, 20, 124, 'completed', 0, '2025-10-15 15:15:45'),
(695, 155, 20, 125, 'completed', 0, '2025-10-15 15:15:49'),
(697, 155, 22, 115, 'completed', 0, '2025-10-15 15:16:37'),
(698, 155, 22, 116, 'completed', 0, '2025-10-15 15:16:41'),
(700, 155, 22, 127, 'completed', 0, '2025-10-15 15:16:45'),
(702, 155, 22, 128, 'completed', 0, '2025-10-15 15:17:33'),
(704, 155, 22, 129, 'completed', 0, '2025-10-15 15:17:40'),
(706, 155, 22, 130, 'completed', 0, '2025-10-15 15:17:43'),
(708, 155, 22, 131, 'completed', 0, '2025-10-15 15:25:38'),
(710, 155, 22, 132, 'completed', 0, '2025-10-15 15:25:42'),
(712, 155, 22, 133, 'completed', 0, '2025-10-15 15:25:46'),
(714, 155, 23, 134, 'completed', 0, '2025-10-15 15:40:14'),
(715, 155, 23, 135, 'completed', 0, '2025-10-15 15:40:18'),
(717, 155, 23, 136, 'completed', 0, '2025-10-15 15:40:22'),
(719, 155, 23, 137, '', 0, NULL),
(720, 156, 38, 143, 'completed', 0, '2025-10-15 15:48:33'),
(721, 156, 38, 144, 'completed', 0, '2025-10-15 15:48:36'),
(723, 156, 38, 145, 'completed', 0, '2025-10-15 15:48:40'),
(725, 156, 38, 146, 'completed', 0, '2025-10-15 15:49:13'),
(727, 156, 38, 147, 'completed', 0, '2025-10-15 15:49:17'),
(729, 156, 38, 148, 'completed', 0, '2025-10-15 15:49:24'),
(731, 156, 38, 149, 'completed', 0, '2025-10-15 15:50:16'),
(733, 156, 38, 150, 'completed', 0, '2025-10-15 15:50:21'),
(735, 156, 38, 151, 'completed', 0, '2025-10-15 15:50:25'),
(737, 156, 20, 117, 'completed', 0, '2025-10-15 16:00:23'),
(738, 156, 20, 118, 'completed', 0, '2025-10-15 16:00:31'),
(740, 156, 20, 119, 'completed', 0, '2025-10-15 16:00:35'),
(742, 156, 20, 120, '', 0, NULL),
(743, 157, 19, 112, 'completed', 0, '2025-10-15 16:05:22'),
(744, 157, 19, 113, 'completed', 0, '2025-10-15 16:05:27'),
(746, 157, 19, 114, 'completed', 0, '2025-10-15 16:05:32'),
(748, 157, 19, 108, 'completed', 0, '2025-10-15 16:06:27'),
(749, 157, 19, 109, 'completed', 0, '2025-10-15 16:06:32'),
(751, 157, 19, 110, 'completed', 0, '2025-10-15 16:06:37'),
(753, 157, 19, 82, 'completed', 0, '2025-10-15 16:07:11'),
(754, 157, 19, 83, 'completed', 0, '2025-10-15 16:07:16'),
(756, 157, 19, 84, 'completed', 0, '2025-10-15 16:07:20'),
(758, 158, 19, 112, 'completed', 0, '2025-10-15 16:31:40'),
(759, 158, 19, 113, 'completed', 0, '2025-10-15 16:31:44'),
(761, 158, 19, 114, 'completed', 0, '2025-10-15 16:31:48'),
(763, 158, 19, 108, 'completed', 0, '2025-10-15 16:32:12'),
(764, 158, 19, 109, 'completed', 0, '2025-10-15 16:32:19'),
(766, 158, 19, 110, 'completed', 0, '2025-10-15 16:32:25'),
(768, 158, 19, 82, 'completed', 0, '2025-10-15 16:32:55'),
(769, 158, 19, 83, 'completed', 0, '2025-10-15 16:32:58'),
(771, 158, 19, 84, 'completed', 0, '2025-10-15 16:33:01'),
(773, 158, 20, 117, 'completed', 0, '2025-10-15 16:33:42'),
(774, 158, 20, 118, 'completed', 0, '2025-10-15 16:33:46'),
(776, 158, 20, 119, 'completed', 0, '2025-10-15 16:33:51'),
(778, 158, 20, 120, 'completed', 0, '2025-10-15 16:34:19'),
(780, 158, 20, 121, 'completed', 0, '2025-10-15 16:34:24'),
(782, 158, 20, 122, 'completed', 0, '2025-10-15 16:34:28'),
(784, 158, 20, 123, 'completed', 0, '2025-10-15 16:34:51'),
(786, 158, 20, 124, 'completed', 0, '2025-10-15 16:34:55'),
(788, 158, 20, 125, 'completed', 0, '2025-10-15 16:35:00'),
(790, 158, 40, 152, 'completed', 0, '2025-10-15 16:35:26'),
(791, 158, 40, 153, 'completed', 0, '2025-10-15 16:35:33'),
(793, 158, 40, 154, 'completed', 0, '2025-10-15 16:35:41'),
(795, 158, 40, 155, 'completed', 0, '2025-10-15 16:54:57'),
(797, 158, 40, 156, 'completed', 0, '2025-10-15 16:55:00'),
(799, 158, 40, 157, 'completed', 0, '2025-10-15 16:55:02'),
(801, 158, 40, 158, 'completed', 0, '2025-10-15 16:56:23'),
(803, 158, 40, 159, 'completed', 0, '2025-10-15 16:56:28'),
(805, 158, 40, 160, 'completed', 0, '2025-10-15 16:56:32'),
(807, 158, 38, 143, 'completed', 0, '2025-10-15 17:00:41'),
(808, 158, 38, 144, 'completed', 0, '2025-10-15 17:00:44'),
(810, 158, 38, 145, 'completed', 0, '2025-10-15 17:00:47'),
(812, 158, 38, 146, '', 0, NULL),
(814, 154, 40, 159, '', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lesson_topics`
--

CREATE TABLE `lesson_topics` (
  `topic_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `topic_title` varchar(255) NOT NULL,
  `topic_content` longtext NOT NULL,
  `topic_order` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_topics`
--

INSERT INTO `lesson_topics` (`topic_id`, `lesson_id`, `topic_title`, `topic_content`, `topic_order`) VALUES
(208, 112, 'Topic 1: What is HTML and How It Works', '<p>HTML (<b>HyperText Markup Language</b>) is the main language used to create web pages. It tells the browser what to show — like text, images, links, or buttons. It uses <em data-start=\"746\" data-end=\"752\">tags</em> to mark parts of the content.</p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760463415_1760463293_1760463289_1760463236_1760462895_Screenshot 2025-10-15 002937.png\" style=\"width: 665px;\"><span style=\"font-family: Verdana;\">﻿</span></p>', 1),
(209, 112, 'Topic 2: Structure of an HTML Document', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760463973_1760463969_Screenshot 2025-10-15 014559.png\" style=\"width: 388px;\"></p><p><b><span style=\"font-family: Impact;\">﻿</span>The <code data-start=\"1018\" data-end=\"1026\">&lt;head&gt;</code> contains page info, and the <code data-start=\"1055\" data-end=\"1063\">&lt;body&gt;</code> has what you actually see.</b><span style=\"font-family: Impact;\">﻿</span><br></p>', 1),
(210, 112, 'Topic 3: Setting Up Your First HTML File', '<p><b>To start coding HTML</b></p><ul><li>Open a text editor (like VS Code or Notepad++)</li><li>Save your file with <code data-start=\"1240\" data-end=\"1247\">.html</code> (example: <code data-start=\"1258\" data-end=\"1270\">index.html</code>)</li><li>Open it in your browser to view your work</li></ul>', 1),
(211, 112, 'Topic 4: How Web Browsers Read HTML', '<p><b>Browsers like Chrome or Firefox read your HTML file and display it visually. The browser ignores spaces and new lines — only tags and content matter.</b></p>', 1),
(212, 113, 'Topic 1: Headings', '<p><b>Headings are used for titles:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760464824_Screenshot 2025-10-15 020008.png\" style=\"width: 744.8px;\"><b><br></b></p>', 1),
(213, 113, 'Topic 2: Paragraphs', '<p><b>The <code data-start=\"1718\" data-end=\"1723\">&lt;p&gt;</code> tag is used for blocks of text:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760464931_Screenshot 2025-10-15 020159.png\" style=\"width: 430px;\"><b><br></b></p>', 1),
(214, 113, 'Topic 3: Line Breaks and Horizontal Lines', '<p><b>Use <code data-start=\"1864\" data-end=\"1870\">&lt;br&gt;</code> to break lines and <code data-start=\"1890\" data-end=\"1896\">&lt;hr&gt;</code> to create a line divider.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760464995_Screenshot 2025-10-15 020307.png\" style=\"width: 241px;\"><b><br></b></p>', 1),
(215, 113, 'Topic 4: Comments', '<p><b>Comments are notes you add that don’t appear on the webpage:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760465068_Screenshot 2025-10-15 020420.png\" style=\"width: 283px;\"><b><br></b></p>', 1),
(216, 114, 'Topic 1: Text Formatting Tags', '<p><b>Make your text stand out</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760465161_Screenshot 2025-10-15 020552.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(217, 114, 'Topic 2: Creating Hyperlinks', '<p><b>Links are made using the <code data-start=\"2369\" data-end=\"2374\">&lt;a&gt;</code> tag</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760465275_Screenshot 2025-10-15 020748.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(218, 114, 'Topic 3: Absolute and Relative Links', '<ul><li><strong data-start=\"2488\" data-end=\"2501\">Absolute:</strong> full URL (<code data-start=\"2512\" data-end=\"2544\">https://example.com/about.html</code>)</li><li><strong data-start=\"2552\" data-end=\"2565\">Relative:</strong> file path from your project (<code data-start=\"2595\" data-end=\"2607\">about.html</code>)</li></ul>', 1),
(219, 114, 'Topic 4: Opening Links in New Tabs', '<p><b>Add <code data-start=\"2655\" data-end=\"2672\">target=\"_blank\"</code></b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760465399_Screenshot 2025-10-15 020948.png\" style=\"width: 100%;\"><b><code data-start=\"2655\" data-end=\"2672\"><br></code></b></p>', 1),
(220, 108, 'Topic 1: Ordered Lists', '<p><b>Used for numbered lists:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760465591_Screenshot 2025-10-15 021301.png\" style=\"\"><b><br></b></p>', 1),
(221, 108, 'Topic 2: Unordered Lists', '<p><b>Used for bullet lists:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760465703_Screenshot 2025-10-15 021456.png\" style=\"width: 186px;\"><b><br></b></p>', 1),
(222, 108, 'Topic 3: Nested Lists', '<p><b>You can put a list inside another list:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760465746_Screenshot 2025-10-15 021539.png\" style=\"width: 306px;\"><b><br></b></p>', 1),
(223, 108, 'Topic 4: Description Lists', '<p><b>For terms and definitions:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760465800_Screenshot 2025-10-15 021632.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(224, 109, 'Topic 1: Inserting Images', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760466175_Screenshot 2025-10-15 022242.png\" style=\"width: 100%;\"><br></p>', 1),
(225, 109, 'Topic 2: Image Attributes', '<p><b>You can control image display using attributes:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760466239_Screenshot 2025-10-15 022349.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(226, 109, 'Topic 3: Adding Audio and Video', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760466284_Screenshot 2025-10-15 022434.png\" style=\"\"><br></p>', 1),
(227, 109, 'Topic 4: Embedding YouTube Videos', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760466345_Screenshot 2025-10-15 022532.png\" style=\"width: 100%;\"><br></p>', 1),
(228, 110, 'Topic 1: Creating Basic Tables', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760466425_Screenshot 2025-10-15 022655.png\" style=\"width: 327px;\"><br></p>', 1),
(229, 110, 'Topic 2: Table Borders and Styling', '<h4 class=\"\"><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">Use </span><code data-start=\"4284\" data-end=\"4292\"><span style=\"font-family: &quot;Comic Sans MS&quot;;\">border</span></code><span style=\"font-family: &quot;Comic Sans MS&quot;;\">, </span><code data-start=\"4294\" data-end=\"4307\"><span style=\"font-family: &quot;Comic Sans MS&quot;;\">cellpadding</span></code><span style=\"font-family: &quot;Comic Sans MS&quot;;\">, or CSS for better appearance.</span></b></h4>', 1),
(230, 110, 'Topic 3: Merging Cells', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760466475_Screenshot 2025-10-15 022749.png\" style=\"width: 100%;\"><br></p>', 1),
(231, 110, 'Topic 4: Data Table Example', '<h2 class=\"\"><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">A table is often used to show organized data like student scores or schedules.</span></b></h2>', 1),
(232, 82, 'Topic 1: Form Structure', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760466746_Screenshot 2025-10-15 023215.png\" style=\"width: 100%;\"><br></p>', 1),
(233, 82, 'Topic 2: Input Types', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760466789_Screenshot 2025-10-15 023300.png\" style=\"width: 276px;\"><br></p>', 1),
(234, 82, 'Topic 3: Labels and Placeholders', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760466819_Screenshot 2025-10-15 023333.png\" style=\"width: 100%;\"><br></p>', 1),
(235, 82, 'Topic 4: Submit and Reset Buttons', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760466856_Screenshot 2025-10-15 023409.png\" style=\"width: 100%;\"><br></p>', 1),
(236, 83, 'Topic 1: What is Semantic HTML', '<h3 class=\"\"><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">Semantic tags describe the meaning of content (not just how it looks). It helps search engines and screen readers.</span></b></h3>', 1),
(237, 83, 'Topic 2: Common Semantic Elements', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760467000_Screenshot 2025-10-15 023631.png\" style=\"width: 335px;\"><br></p>', 1),
(238, 83, 'Topic 3: Why Use Semantic Tags', '<h3 class=\"\"><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">They make your code more organized, accessible, and SEO-friendly</span></b>.</h3>', 1),
(239, 84, 'Topic 1: Building a Simple Web Page', '<h3 class=\"\"><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">Create a homepage that uses headings, paragraphs, links, and images together.</span></b></h3>', 1),
(240, 84, 'Topic 2: Adding Navigation', '<h3 class=\"\"><b>Use <code data-start=\"5911\" data-end=\"5918\">&lt;nav&gt;</code> and <code data-start=\"5923\" data-end=\"5928\">&lt;a&gt;</code> tags for simple menus.</b></h3>', 1),
(241, 84, 'Topic 3: Footer and Structure', '<h3 class=\"\"><b>Add <code data-start=\"5993\" data-end=\"6003\">&lt;footer&gt;</code> at the bottom with contact info.</b></h3>', 1),
(242, 117, 'Topic 1: What is CSS', '<h4 class=\"\"><span style=\"font-family: Verdana;\">﻿</span><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\"><span style=\"font-family: Verdana;\">CSS (Cascading Style Sheets) is used to style and design HTML pages.</span><br></span></b><b><span style=\"font-family: Verdana;\">\r\nIt controls how elements look — like colors, fonts, and layout</span></b><span style=\"font-family: Verdana;\">.</span></h4>', 1),
(243, 117, 'Topic 2: How CSS Works with HTML', '<h4 class=\"\"><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\"><span style=\"font-family: Verdana;\">HTML gives structure, while CSS adds the look.</span><br></span></b><b><span style=\"font-family: Verdana;\">\r\nThe browser reads the HTML, then applies CSS styles to the matching elements.</span></b></h4>', 1),
(244, 117, 'Topic 3: Benefits of Using CSS', '<h6 class=\"\"></h6><h4 class=\"\"></h4><h5 class=\"\"><ul><li><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">Makes your design consistent across pages.</span></b></li><li><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">Easier to update the style of a whole website.</span></b></li><li><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">Separates content (HTML) from design (CSS).</span></b></li></ul></h5>', 1),
(245, 117, 'Topic 4: CSS Syntax and Rules', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760469297_Screenshot 2025-10-15 031446.png\" style=\"\"></p><p><b>This changes all <code data-start=\"1162\" data-end=\"1167\">&lt;p&gt;</code> text to blue and 16px size.</b></p>', 1),
(246, 118, 'Topic 1: Inline CSS', '<p><b>Written inside an HTML tag using the <code data-start=\"1309\" data-end=\"1316\">style</code> attribute:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760469399_Screenshot 2025-10-15 031632.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(247, 118, 'Topic 2: Internal CSS', '<p><b>Placed inside the <code data-start=\"1426\" data-end=\"1435\">&lt;style&gt;</code> tag in the HTML <code data-start=\"1452\" data-end=\"1460\">&lt;head&gt;</code>:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760469521_Screenshot 2025-10-15 031835.png\" style=\"\"><b><br></b></p>', 1),
(248, 118, 'Topic 3: External CSS', '<p><b>Written in a separate <code data-start=\"1563\" data-end=\"1569\">.css</code> file (like <code data-start=\"1581\" data-end=\"1592\">style.css</code>) and linked using:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760469592_Screenshot 2025-10-15 031945.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(249, 118, 'Topic 4: Linking a CSS File', '<h4 class=\"\"><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">External CSS is best for large websites — it keeps your code clean and reusable.</span></b></h4>', 1),
(250, 119, 'Topic 1: Element Selectors', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760469747_Screenshot 2025-10-15 032221.png\" style=\"width: 100%;\"></p><p><b>Selects all <code data-start=\"1911\" data-end=\"1917\">&lt;h1&gt;</code> tags and makes them green.</b></p>', 1),
(251, 119, 'Topic 2: Class and ID Selectors', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760469813_Screenshot 2025-10-15 032323.png\" style=\"width: 100%;\"></p><p><b>Class uses <code data-start=\"2083\" data-end=\"2086\">.</code>, ID uses <code data-start=\"2096\" data-end=\"2099\">#</code>.</b></p>', 1),
(252, 119, 'Topic 3: Grouping Selectors', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760469856_Screenshot 2025-10-15 032409.png\" style=\"width: 100%;\"></p><p><b>Applies the same style to multiple elements.</b></p>', 1),
(253, 119, 'Topic 4: CSS Comments', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760469909_Screenshot 2025-10-15 032502.png\" style=\"width: 100%;\"><br></p>', 1),
(254, 120, 'Topic 1: Color Names, HEX, and RGB', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760469998_Screenshot 2025-10-15 032630.png\" style=\"\"><br></p>', 1),
(255, 120, 'Topic 2: Setting Text and Background Colors', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470048_Screenshot 2025-10-15 032719.png\" style=\"\"><br></p>', 1),
(256, 120, 'Topic 3: Using Background Images', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470087_Screenshot 2025-10-15 032758.png\" style=\"\"><br></p>', 1),
(257, 120, 'Topic 4: Background Repeat and Position', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470128_Screenshot 2025-10-15 032840.png\" style=\"\"><br></p>', 1),
(258, 121, 'Topic 1: Font Family and Font Size', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470202_Screenshot 2025-10-15 032954.png\" style=\"\"><br></p>', 1),
(259, 121, 'Topic 2: Font Weight and Style', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470239_Screenshot 2025-10-15 033032.png\" style=\"\"><br></p>', 1),
(260, 121, 'Topic 3: Text Alignment and Decoration', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470284_Screenshot 2025-10-15 033115.png\" style=\"\"><br></p>', 1),
(261, 121, 'Topic 4: Line Height and Letter Spacing', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470308_Screenshot 2025-10-15 033141.png\" style=\"\"><br></p>', 1),
(263, 122, 'Topic 1: Understanding Content, Padding, Border, and Margin', '<p><b>Every element is a box:</b></p><ul><li><b><strong data-start=\"3449\" data-end=\"3460\">Content</strong> → actual text or image</b></li><li><b><strong data-start=\"3490\" data-end=\"3501\">Padding</strong> → space inside the border</b></li><li><b><strong data-start=\"3534\" data-end=\"3544\">Border</strong> → outer line</b></li><li><b><strong data-start=\"3564\" data-end=\"3574\">Margin</strong> → space outside the element</b></li></ul>', 1),
(264, 122, 'Topic 2: Box Sizing', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470566_Screenshot 2025-10-15 033558.png\" style=\"width: 100%;\"></p><p><b>Keeps width and height predictable.</b></p>', 1),
(265, 122, 'Topic 3: Adding Borders and Border Radius', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470697_Screenshot 2025-10-15 033809.png\" style=\"width: 50%;\"><br></p>', 1),
(266, 122, 'Topic 4: Spacing Elements', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470726_Screenshot 2025-10-15 033839.png\" style=\"width: 50%;\"><br></p>', 1),
(268, 123, 'Topic 1: Block and Inline Elements', '<ul><li><b>Block: starts on a new line (<code data-start=\"4071\" data-end=\"4076\">div</code>, <code data-start=\"4078\" data-end=\"4081\">p</code>, <code data-start=\"4083\" data-end=\"4087\">h1</code>)</b></li><li><b>Inline: stays in line (<code data-start=\"4118\" data-end=\"4124\">span</code>, <code data-start=\"4126\" data-end=\"4129\">a</code>, <code data-start=\"4131\" data-end=\"4136\">img</code>)</b></li></ul>', 1),
(269, 123, 'Topic 2: Display Property', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470904_Screenshot 2025-10-15 034135.png\" style=\"width: 100%;\"><br></p>', 1),
(270, 123, 'Topic 3: Position Values', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760470935_Screenshot 2025-10-15 034208.png\" style=\"\"><br></p>', 1),
(271, 123, 'Topic 4: Using z-index', '<p><b>Controls which element appears on top:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760470995_Screenshot 2025-10-15 034309.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(272, 124, 'Topic 1: What is Flexbox', '<h4 class=\"\"><span style=\"font-family: &quot;Comic Sans MS&quot;;\"><b>Flexbox helps you arrange items easily in rows or columns.</b></span></h4>', 1),
(273, 124, 'Topic 2: Creating a Flex Container', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760471104_Screenshot 2025-10-15 034455.png\" style=\"width: 50%;\"><br></p>', 1),
(274, 124, 'Topic 3: Aligning Items', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760471197_Screenshot 2025-10-15 034631.png\" style=\"width: 100%;\"><br></p>', 1),
(275, 124, 'Topic 4: Common Flexbox Properties', '<ul><li><b>flex-direction</b></li><li><b>justify-content</b></li><li><b>align-items</b></li><li><b>gap</b></li></ul>', 1),
(276, 125, 'Topic 1: What is Responsive Design', '<h4 class=\"\"><span style=\"font-family: &quot;Comic Sans MS&quot;;\"><b>It makes websites look good on all devices — desktop, tablet, and mobile.</b></span></h4>', 1),
(277, 125, 'Topic 2: Media Queries', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760471366_Screenshot 2025-10-15 034919.png\" style=\"width: 100%;\"><br></p>', 1),
(278, 125, 'Topic 3: Using Percentages and Max-width', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760471399_Screenshot 2025-10-15 034952.png\" style=\"width: 100%;\"><br></p>', 1),
(279, 125, 'Topic 4: Mobile-first Design', '<h4 class=\"\"><span style=\"font-family: &quot;Comic Sans MS&quot;;\"><b>Start designing for small screens first, then expand for larger devices.</b></span></h4>', 1),
(280, 115, 'Topic 1: What is JavaScript and its role in web development', '<p><b><span style=\"font-family: Helvetica;\">JavaScript is a programming language that makes websites interactive. It can update content, show alerts, and react to user actions without reloading the page. It works with HTML and CSS to create dynamic web pages.</span></b></p>', 1),
(281, 115, 'Topic 2: Adding JavaScript to HTML (inline, internal, external)', '<p><b>You can add JavaScript in three ways:</b></p><ul><li><b><strong data-start=\"700\" data-end=\"711\">Inline:</strong> inside an HTML tag using the <code data-start=\"741\" data-end=\"750\">onclick</code> or similar attributes.</b></li><li><b><strong data-start=\"778\" data-end=\"791\">Internal:</strong> using a <code data-start=\"800\" data-end=\"810\">&lt;script&gt;</code> tag inside the HTML file.</b></li><li><b><strong data-start=\"841\" data-end=\"854\">External:</strong> linking a separate <code data-start=\"874\" data-end=\"879\">.js</code> file using <code data-start=\"891\" data-end=\"926\">&lt;script src=\"script.js\"&gt;&lt;/script&gt;</code>.</b></li></ul>', 1),
(282, 115, 'Topic 3: Writing your first script and using console.log()', '<p><b>The <code data-start=\"1000\" data-end=\"1015\">console.log()</code> command displays messages in the browser console. It’s helpful for testing and debugging your code. Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760474848_Screenshot 2025-10-15 044719.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(283, 116, 'Topic 1: Understanding statements and comments', '<p><b>A JavaScript statement is like a single instruction. You can use comments to explain your code:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760474926_Screenshot 2025-10-15 044839.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(284, 116, 'Topic 2: Declaring variables with var, let, and const', '<p><b>Variables store data values.</b></p><ul><li><b><code data-start=\"1556\" data-end=\"1561\">var</code> is the old way (still works).</b></li><li><b><code data-start=\"1596\" data-end=\"1601\">let</code> is for variables that can change.</b></li><li><b><code data-start=\"1640\" data-end=\"1647\">const</code> is for variables that should not change.</b></li></ul>', 1),
(285, 116, 'Topic 3: Naming conventions and case sensitivity', '<p><b>Variable names can include letters, numbers, <code data-start=\"1790\" data-end=\"1793\">$</code>, and <code data-start=\"1799\" data-end=\"1802\">_</code> but cannot start with a number. JavaScript is <span data-start=\"1849\" data-end=\"1867\">case-sensitive</span>, meaning <code data-start=\"1877\" data-end=\"1883\">name</code> and <code data-start=\"1888\" data-end=\"1894\">Name</code> are different.</b></p>', 1),
(286, 127, 'Topic 1: Primitive data types', '<p><b>JavaScript has simple data types:</b></p><ul><li><b><code data-start=\"2033\" data-end=\"2041\">String</code> – text like <code data-start=\"2054\" data-end=\"2063\">\"Hello\"</code></b></li><li><b><code data-start=\"2068\" data-end=\"2076\">Number</code> – values like <code data-start=\"2091\" data-end=\"2095\">10</code> or <code data-start=\"2099\" data-end=\"2105\">3.14</code></b></li><li><span style=\"font-family: Arial;\">﻿</span><span style=\"font-family: Arial;\"><b><code data-start=\"2110\" data-end=\"2119\">Boolean</code> – <code data-start=\"2122\" data-end=\"2128\">true</code> or <code data-start=\"2132\" data-end=\"2139\">false</code></b></span></li><li><span style=\"font-family: Arial;\"><b><code data-start=\"2144\" data-end=\"2150\">Null</code> – empty value﻿</b></span><b><code data-start=\"2099\" data-end=\"2105\"><br></code></b></li><li><span style=\"font-family: Arial;\">﻿</span><b><code data-start=\"2099\" data-end=\"2105\"><code data-start=\"2169\" data-end=\"2180\">Undefined</code> – no value assigned<br></code></b></li></ul>', 1),
(287, 127, 'Topic 2: Arithmetic and assignment operators', '<p><b>Arithmetic operators include&nbsp;&nbsp;<code data-start=\"2284\" data-end=\"2287\">+&nbsp;</code>, <code data-start=\"2289\" data-end=\"2292\">-&nbsp;</code>, <code data-start=\"2294\" data-end=\"2297\">*&nbsp;</code>, <code data-start=\"2299\" data-end=\"2302\">/&nbsp;</code>, <code data-start=\"2304\" data-end=\"2307\">%&nbsp;</code>.<br data-start=\"2308\" data-end=\"2311\">\r\nAssignment operators like&nbsp;&nbsp;<code data-start=\"2337\" data-end=\"2340\">=</code>&nbsp; or&nbsp;&nbsp;<code data-start=\"2344\" data-end=\"2348\">+=</code>&nbsp; help assign values to variables.</b></p>', 1),
(288, 127, 'Topic 3: Comparison and logical operators', '<p><b>Comparison operators: <code data-start=\"2453\" data-end=\"2457\">==</code>, <code data-start=\"2459\" data-end=\"2464\">===</code>, <code data-start=\"2466\" data-end=\"2470\">!=</code>, <code data-start=\"2472\" data-end=\"2475\">&gt;</code>, <code data-start=\"2477\" data-end=\"2480\">&lt;</code>, <code data-start=\"2482\" data-end=\"2486\">&gt;=</code>, <code data-start=\"2488\" data-end=\"2492\">&lt;=</code><br data-start=\"2492\" data-end=\"2495\">\r\nLogical operators: <code data-start=\"2514\" data-end=\"2518\">&amp;&amp;</code> (and), <code data-start=\"2526\" data-end=\"2530\">||</code> (or), <code data-start=\"2537\" data-end=\"2540\">!</code> (not)</b></p>', 1),
(289, 128, 'Topic 1: Using if, else if, and else', '<p><b>Use these to make decisions in your code:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760475531_Screenshot 2025-10-15 045843.png\" style=\"\"><b><br></b></p>', 1),
(290, 128, 'Topic 2: The switch statement', '<p><b>Used for multiple conditions:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760475587_Screenshot 2025-10-15 045940.png\" style=\"width: 479px;\"><b><br></b></p>', 1),
(291, 128, 'Topic 3: Common logical conditions', '<p><b>You can check multiple conditions together using <code data-start=\"3145\" data-end=\"3149\">&amp;&amp;</code> and <code data-start=\"3154\" data-end=\"3158\">||</code>.</b></p><p><b><br></b></p>', 1),
(292, 129, 'Topic 1: Using for and while loops', '<p><b>Loops help repeat actions.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760475660_Screenshot 2025-10-15 050050.png\" style=\"width: 50%;\"><b><br></b></p><p><b><code data-start=\"3338\" data-end=\"3345\">while</code> loop runs while a condition is true.</b></p>', 1),
(293, 129, 'Topic 2: The do...while loop', '<p><b>Runs at least once, even if the condition is false.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760475760_Screenshot 2025-10-15 050233.png\" style=\"\"><b><br></b></p>', 1),
(294, 129, 'Topic 3: Loop control statements', '<h3 class=\"\"><b><code data-start=\"3572\" data-end=\"3579\">break</code> and <code data-start=\"3584\" data-end=\"3594\">continue:</code></b></h3><h3 class=\"\"><b><code data-start=\"3584\" data-end=\"3594\"><br></code></b></h3><h5 class=\"\"><b><code data-start=\"3600\" data-end=\"3607\">break</code> stops the loop early, <code data-start=\"3630\" data-end=\"3640\">continue</code> skips the current step.</b></h5>', 1),
(295, 130, 'Topic 1: Defining and calling functions', '<p><b>Functions group code into reusable parts:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760475927_Screenshot 2025-10-15 050520.png\" style=\"\"><b><br></b></p>', 1),
(296, 130, 'Topic 2: Parameters and return values', '<p><b>You can pass values to functions and get results:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760475967_Screenshot 2025-10-15 050600.png\" style=\"\"><b><br></b></p>', 1),
(297, 130, 'Topic 3: Function scope and global/local variables', '<h4 class=\"\"><h5 class=\"\"><span style=\"font-family: Helvetica;\">Variables inside functions are </span><strong data-start=\"4099\" data-end=\"4108\"><span style=\"font-family: Helvetica;\">local</span></strong><span style=\"font-family: Helvetica;\"> and can’t be used outside.</span></h5><h5 class=\"\"><span style=\"font-family: Helvetica;\">\r\nVariables outside are </span><strong data-start=\"4160\" data-end=\"4170\"><span style=\"font-family: Helvetica;\">global</span></strong><span style=\"font-family: Helvetica;\"> and can be used anywhere.</span></h5></h4>', 1),
(298, 131, 'Topic 1: What is the DOM?', '<h5 class=\"\"><span style=\"font-family: Helvetica;\">The </span><strong data-start=\"4334\" data-end=\"4365\"><span style=\"font-family: Helvetica;\">Document Object Model (DOM)</span></strong><span style=\"font-family: Helvetica;\"> represents the webpage as objects that JavaScript can change</span></h5>', 1),
(299, 131, 'Topic 2: Selecting elements', '<p><b>Use methods like:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760476167_Screenshot 2025-10-15 050920.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(300, 131, 'Topic 3: Changing content and styles', '<p><b>You can change text or styles with JavaScript:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760476203_Screenshot 2025-10-15 050954.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(301, 132, 'Topic 1: What are events in JavaScript', '<h5 class=\"\"><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">Events are actions like clicks, typing, or page loading.</span></b></h5>', 1),
(302, 132, 'Topic 2: Using onclick, onchange, onload', '<h5 class=\"\"><b><span style=\"font-family: &quot;Comic Sans MS&quot;;\">Attach simple event actions directly in HTML or JS.</span></b></h5>', 1),
(303, 132, 'Topic 3: Adding event listeners with addEventListener()', '<p><b>Better way to handle events:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760476343_Screenshot 2025-10-15 051216.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(304, 133, 'Topic 1: Creating and accessing arrays', '<p><b>Arrays hold multiple values in one variable:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760476399_Screenshot 2025-10-15 051312.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(305, 133, 'Topic 2: Common array methods', '<h5 class=\"\"><b><code data-start=\"5417\" data-end=\"5425\">push()</code> adds, <code data-start=\"5432\" data-end=\"5439\">pop()</code> removes, and <code data-start=\"5453\" data-end=\"5461\">length</code> counts elements.</b></h5>', 1),
(306, 133, 'Topic 3: Introduction to objects', '<p><b>Objects store data in key-value pairs:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760476463_Screenshot 2025-10-15 051416.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(307, 134, 'Topic 1: Overview of Bootstrap', '<h5 class=\"\"><b>Bootstrap</b> is a free <b>front-end framework </b>that helps create responsive and mobile-friendly websites quickly. It includes ready-made CSS and JS components for layouts, buttons, forms, and more.</h5>', 1),
(308, 134, 'Topic 2: Why use Bootstrap?', '<h5 class=\"\"><b>Bootstrap</b> saves time because you don’t need to code everything from scratch. It works on all devices and is easy to customize.</h5>', 1),
(309, 134, 'Topic 3: Versions and setup', '<h5 class=\"\">The latest version is <strong data-start=\"873\" data-end=\"888\">Bootstrap 5</strong>. You can use it by including CDN links or by downloading the Bootstrap files.</h5>', 1),
(310, 135, 'Topic 1: Adding Bootstrap via CDN', '<p><b>You can include Bootstrap by copying the CDN link into your HTML file’s <code data-start=\"1126\" data-end=\"1134\">&lt;head&gt;</code> section:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760508288_Screenshot 2025-10-15 140432.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(311, 135, 'Topic 2: Folder setup for local Bootstrap', '<h5 class=\"\"><b>Download Bootstrap and link the CSS and JS files from your local folder if you want to work offline.</b></h5>', 1),
(312, 135, 'Topic 3: Using the container class', '<p><b>The <code data-start=\"1455\" data-end=\"1467\">.container</code> or <code data-start=\"1471\" data-end=\"1489\">.container-fluid</code> class wraps your content and gives it spacing and alignment.</b></p><ul><li><b><code data-start=\"1555\" data-end=\"1567\">.container</code> = fixed width</b></li><li><b><code data-start=\"1586\" data-end=\"1604\">.container-fluid</code> = full width</b></li></ul>', 1),
(313, 136, 'Topic 1: What is the grid system?', '<p><b>Bootstrap uses a 12-column grid layout to align elements easily. You can divide rows into columns using <code data-start=\"1818\" data-end=\"1824\">.row</code> and <code data-start=\"1829\" data-end=\"1835\">.col</code>.</b></p>', 1),
(314, 136, 'Topic 2: Creating rows and columns', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760508549_Screenshot 2025-10-15 140850.png\" style=\"\"><br></p>', 1),
(315, 136, 'Topic 3: Responsive breakpoints', '<p><b>Bootstrap has classes like <code data-start=\"2061\" data-end=\"2071\">.col-sm-</code>, <code data-start=\"2073\" data-end=\"2083\">.col-md-</code>, <code data-start=\"2085\" data-end=\"2095\">.col-lg-</code>, and <code data-start=\"2101\" data-end=\"2111\">.col-xl-</code> for different screen sizes.</b></p>', 1),
(316, 137, 'Topic 1: Text styles and headings', '<p><b>Bootstrap has classes like <code data-start=\"2299\" data-end=\"2304\">.h1</code> to <code data-start=\"2308\" data-end=\"2313\">.h6</code> and <code data-start=\"2318\" data-end=\"2325\">.lead</code> for styled text.</b></p><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760508691_Screenshot 2025-10-15 141122.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(317, 137, 'Topic 2: Text alignment and colors', '<p><b>Use classes like <code data-start=\"2483\" data-end=\"2497\">.text-center</code>, <code data-start=\"2499\" data-end=\"2512\">.text-start</code>, and color classes like <code data-start=\"2537\" data-end=\"2552\">.text-primary</code>, <code data-start=\"2554\" data-end=\"2568\">.text-danger</code>, <code data-start=\"2570\" data-end=\"2585\">.text-success</code>.</b></p>', 1),
(318, 137, 'Topic 3: Background colors', '<h5 class=\"\"><b>Add background colors using <code data-start=\"2651\" data-end=\"2664\">.bg-primary</code>, <code data-start=\"2666\" data-end=\"2679\">.bg-warning</code>, etc.</b></h5>', 1),
(319, 138, 'Topic 1: Button styles', '<p><b>Bootstrap buttons use the <code data-start=\"2784\" data-end=\"2790\">.btn</code> class and color variants like <code data-start=\"2821\" data-end=\"2835\">.btn-primary</code>, <code data-start=\"2837\" data-end=\"2851\">.btn-success</code>, <code data-start=\"2853\" data-end=\"2866\">.btn-danger</code>.</b></p>', 1),
(320, 138, 'Topic 2: Button sizes and outlines', '<h5 class=\"\"><b>Use <code data-start=\"2916\" data-end=\"2925\">.btn-lg</code> or <code data-start=\"2929\" data-end=\"2938\">.btn-sm</code> for sizes, and <code data-start=\"2954\" data-end=\"2976\">.btn-outline-primary</code> for outline buttons.</b></h5>', 1),
(321, 138, 'Topic 3: Alert boxes', '<p><b>Alerts give feedback messages to users:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760508858_Screenshot 2025-10-15 141411.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(322, 139, 'Topic 1: Basic form setup', '<p><b>Use the <code data-start=\"3217\" data-end=\"3232\">.form-control</code> class for inputs:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760508918_Screenshot 2025-10-15 141511.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(323, 139, 'Topic 2: Form groups and labels', '<h5 class=\"\"><b>Group inputs and labels using <code data-start=\"3398\" data-end=\"3405\">.mb-3</code> (margin bottom spacing).</b></h5><p><b><br></b></p>', 1),
(324, 139, 'Topic 3: Form validation states', '<h5 class=\"\"><b>Add <code data-start=\"3476\" data-end=\"3487\">.is-valid</code> or <code data-start=\"3491\" data-end=\"3504\">.is-invalid</code> to show success or error states.</b></h5>', 1),
(325, 140, 'Topic 1: Creating a simple navbar', '<h5 class=\"\"><b>Use <code data-start=\"3687\" data-end=\"3696\">.navbar</code>, <code data-start=\"3698\" data-end=\"3717\">.navbar-expand-lg</code>, and <code data-start=\"3723\" data-end=\"3738\">.navbar-light</code> or <code data-start=\"3742\" data-end=\"3756\">.navbar-dark</code> for color theme.</b></h5>', 1),
(326, 140, 'Topic 2: Adding links and brand name', '<h5 class=\"\"><b>Use <code data-start=\"3824\" data-end=\"3839\">.navbar-brand</code> for your logo and <code data-start=\"3858\" data-end=\"3869\">.nav-link</code> for menu items.</b></h5>', 1),
(327, 140, 'Topic 3: Responsive toggle button', '<h5 class=\"\"><b>Bootstrap includes a built-in hamburger menu using <code data-start=\"3980\" data-end=\"3997\">.navbar-toggler</code> and <code data-start=\"4002\" data-end=\"4013\">.collapse</code>.</b></h5>', 1),
(328, 141, 'Topic 1: Creating a card', '<p><b>Cards are used to display content in boxes:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760509130_Screenshot 2025-10-15 141840.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(329, 141, 'Topic 2: Adding images and titles to cards', '<h5 class=\"\"><b>Use <code data-start=\"4272\" data-end=\"4287\">.card-img-top</code> for images and <code data-start=\"4303\" data-end=\"4316\">.card-title</code> for headings.</b></h5>', 1),
(330, 141, 'Topic 3: Using modals for popups', '<h5 class=\"\"><b>Modals are popup windows that appear when triggered by buttons.</b></h5>', 1),
(331, 142, 'Topic 1: Image carousel', '<p><b>A carousel is a slideshow for images:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760509241_Screenshot 2025-10-15 142034.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(332, 142, 'Topic 2: Carousel controls and indicators', '<p><b>Use <code data-start=\"4733\" data-end=\"4757\">.carousel-control-prev</code> and <code data-start=\"4762\" data-end=\"4786\">.carousel-control-next</code> for navigation.</b></p>', 1),
(333, 142, 'Topic 3: Footer section', '<h5 class=\"\"><b>Use <code data-start=\"4838\" data-end=\"4848\">.bg-dark</code> and <code data-start=\"4853\" data-end=\"4866\">.text-light</code> for simple, elegant footers.</b></h5>', 1),
(334, 143, 'Topic 1: What is PHP?', '<p>PHP (Hypertext Preprocessor) is a server-side scripting language used to create <strong data-start=\"519\" data-end=\"556\">dynamic and interactive web pages</strong>. It runs on the server and outputs HTML to the browser.</p><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760510380_Screenshot 2025-10-15 143930.png\" style=\"\"><b><br></b></p>', 1),
(335, 143, 'Topic 2: Setting up PHP Environment', '<p>To run PHP code, install a local server such as <strong data-start=\"768\" data-end=\"777\">XAMPP</strong> or <strong data-start=\"781\" data-end=\"789\">WAMP</strong>.</p><ul><li><b>Place your PHP files inside the <code data-start=\"827\" data-end=\"835\">htdocs</code> folder.</b></li><li><b>Start Apache from the control panel.&nbsp; </b></li><li><b>Example file path: </b><u>C:\\xampp\\htdocs\\myproject\\index.php&nbsp;</u>&nbsp;<b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</b></li></ul>', 1),
(336, 143, 'Topic 3: Writing Your First PHP Script', '<p><b>PHP code is written inside special tags <code data-start=\"1039\" data-end=\"1053\">&lt;?php ... ?&gt;</code>.</b></p><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760510592_Screenshot 2025-10-15 144303.png\" style=\"\"><b><br></b></p>', 1),
(337, 144, 'Topic 1: PHP Script Tags', '<p><b>PHP code must start with <code data-start=\"1221\" data-end=\"1228\">&lt;?php</code> and end with <code data-start=\"1242\" data-end=\"1246\">?&gt;</code>.</b></p><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760510690_Screenshot 2025-10-15 144443.png\" style=\"width: 297px;\"><b><br></b></p>', 1),
(338, 144, 'Topic 2: Case Sensitivity', '<h5 class=\"\">Variable names are <strong data-start=\"1365\" data-end=\"1383\">case-sensitive</strong>, but functions are not.</h5><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760510761_Screenshot 2025-10-15 144552.png\" style=\"width: 100%;\"><b><br></b></p>', 1),
(339, 144, 'Topic 3: Comments in PHP', '<p><b>Use comments to describe your code.</b></p><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760510820_Screenshot 2025-10-15 144653.png\" style=\"\"><b><br></b></p>', 1),
(340, 145, 'Topic 1: Declaring Variables', '<p><b>Variables in PHP start with <code data-start=\"1785\" data-end=\"1788\">$</code>.</b></p><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760510883_Screenshot 2025-10-15 144756.png\" style=\"width: 550px;\"><b><br></b></p>', 1),
(341, 145, 'Topic 2: PHP Data Types', '<p><b>PHP supports several data types:</b></p><p>String, Integer, Float, Boolean, Array, Object, Null</p><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760510986_Screenshot 2025-10-15 144910.png\" style=\"width: 373px;\"><b><br></b></p><p><b><br></b></p><p><b><br></b></p>', 1),
(342, 145, 'Topic 3: Type Casting', '<p><b>You can convert data from one type to another.</b></p><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760511038_Screenshot 2025-10-15 145029.png\" style=\"width: 460px;\"><b><br></b></p>', 1),
(343, 146, 'Topic 1: If Statement', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511094_Screenshot 2025-10-15 145118.png\" style=\"width: 276px;\"><br></p>', 1),
(344, 146, 'Topic 2: If...Else Statement', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511134_Screenshot 2025-10-15 145205.png\" style=\"width: 264px;\"><br></p>', 1),
(345, 146, 'Topic 3: Switch Statement', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511171_Screenshot 2025-10-15 145238.png\" style=\"width: 368px;\"><br></p>', 1),
(346, 147, 'Topic 1: For Loop', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511231_Screenshot 2025-10-15 145341.png\" style=\"width: 364px;\"><br></p>', 1),
(347, 147, 'Topic 2: While Loop', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511266_Screenshot 2025-10-15 145416.png\" style=\"width: 310px;\"><br></p>', 1),
(348, 147, 'Topic 3: Foreach Loop', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511295_Screenshot 2025-10-15 145447.png\" style=\"width: 398px;\"><br></p>', 1),
(349, 148, 'Topic 1: Creating Functions', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511370_Screenshot 2025-10-15 145600.png\" style=\"width: 274px;\"><br></p>', 1),
(350, 148, 'Topic 2: Functions with Parameters', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511414_Screenshot 2025-10-15 145643.png\" style=\"width: 280px;\"><br></p>', 1),
(351, 148, 'Topic 3: Built-in Functions', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511439_Screenshot 2025-10-15 145714.png\" style=\"width: 452px;\"><br></p>', 1),
(352, 149, 'Topic 1: Handling GET and POST', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511492_Screenshot 2025-10-15 145805.png\" style=\"width: 403px;\"><br></p>', 1),
(353, 149, 'Topic 2: Form Validation', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511522_Screenshot 2025-10-15 145833.png\" style=\"width: 375px;\"><br></p>', 1),
(354, 149, 'Topic 3: Sanitizing Input', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511551_Screenshot 2025-10-15 145904.png\" style=\"width: 510px;\"><br></p>', 1),
(355, 150, 'Topic 1: Indexed Arrays', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511674_Screenshot 2025-10-15 150105.png\" style=\"width: 386px;\"><br></p>', 1),
(356, 150, 'Topic 2: Associative Arrays', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511708_Screenshot 2025-10-15 150134.png\" style=\"width: 413px;\"><br></p>', 1),
(357, 150, 'Topic 3: Array Functions', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511737_Screenshot 2025-10-15 150209.png\" style=\"width: 274px;\"><br></p>', 1),
(358, 151, 'Topic 1: Database Connection', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511780_Screenshot 2025-10-15 150252.png\" style=\"width: 100%;\"><br></p>', 1),
(359, 151, 'Topic 2: Inserting Data', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511818_Screenshot 2025-10-15 150320.png\" style=\"width: 100%;\"><br></p>', 1),
(360, 151, 'Topic 3: Fetching Data', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760511864_Screenshot 2025-10-15 150359.png\" style=\"width: 576.8px;\"><br></p>', 1),
(361, 152, 'Topic 1: Understanding MySQL', '<p>MySQL is an <strong data-start=\"426\" data-end=\"487\">open-source relational database management system (RDBMS)</strong> used to store and manage data using <strong data-start=\"524\" data-end=\"559\">SQL (Structured Query Language)</strong>.</p><p><b>It’s widely used with PHP in web development.</b></p>', 1),
(362, 152, 'Topic 2: MySQL and SQL', '<ul><li><strong data-start=\"644\" data-end=\"653\">MySQL</strong> is the software (database server).</li><li><strong data-start=\"693\" data-end=\"700\">SQL</strong> is the language used to communicate with it.</li><li>Example:<img src=\"/skillcertsystem/uploads/lesson_files/1760512526_Screenshot 2025-10-15 151513.png\" style=\"width: 274px;\"></li></ul>', 1),
(363, 152, 'Topic 3: MySQL Tools', '<h5 class=\"\">You can manage MySQL through:</h5><ul><li><strong data-start=\"859\" data-end=\"873\">phpMyAdmin</strong> (web interface)</li><li><b>MySQL Command Line Client</b></li><li><b>MySQL Workbench</b></li></ul>', 1),
(364, 153, 'Topic 1: Creating a Database', '<p><b>You can create a new database using:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760512653_Screenshot 2025-10-15 151721.png\" style=\"\"><b><br></b></p>', 1),
(365, 153, 'Topic 2: Using a Database', '<p><b>To start working in that database:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760512685_Screenshot 2025-10-15 151800.png\" style=\"\"><b><br></b></p>', 1),
(366, 153, 'Topic 3: Creating a Table', '<p><b>A table stores data in rows and columns.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760512729_Screenshot 2025-10-15 151842.png\" style=\"width: 466px;\"><b><br></b></p>', 1),
(367, 154, 'Topic 1: Inserting Data', '<p><b>Add new records to a table.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760512777_Screenshot 2025-10-15 151931.png\" style=\"\"><b><br></b></p>', 1),
(368, 154, 'Topic 2: Viewing Data', '<p><b>Display all records in a table.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760512811_Screenshot 2025-10-15 152004.png\" style=\"width: 254px;\"><b><br></b></p>', 1),
(369, 154, 'Topic 3: Selecting Specific Columns', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760512835_Screenshot 2025-10-15 152029.png\" style=\"width: 332px;\"><br></p>', 1),
(370, 155, 'Topic 1: Updating Records', '<p><b>Change existing data using:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760512883_Screenshot 2025-10-15 152116.png\" style=\"width: 225px;\"><b><br></b></p>', 1),
(371, 155, 'Topic 2: Deleting Records', '<p><b>Remove data permanently.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760512920_Screenshot 2025-10-15 152151.png\" style=\"width: 275px;\"><b><br></b></p>', 1),
(372, 155, 'Topic 3: Truncating a Table', '<p><b>Deletes all records but keeps the table structure.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760512948_Screenshot 2025-10-15 152223.png\" style=\"width: 296px;\"><b><br></b></p>', 1),
(373, 156, 'Topic 1: Using WHERE Clause', '<p><b>Filter rows using conditions.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760512987_Screenshot 2025-10-15 152301.png\" style=\"width: 288px;\"><b><br></b></p>', 1),
(374, 156, 'Topic 2: Using ORDER BY', '<p><b>Sort results by column name.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760513030_Screenshot 2025-10-15 152341.png\" style=\"width: 283px;\"><b><br></b></p>', 1),
(375, 156, 'Topic 3: Using LIMIT', '<p><b>Show only a specific number of results.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760513057_Screenshot 2025-10-15 152412.png\" style=\"width: 286px;\"><b><br></b></p>', 1),
(376, 157, 'Topic 1: COUNT() Function', '<p><b>Count total rows.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760513100_Screenshot 2025-10-15 152454.png\" style=\"\"><b><br></b></p>', 1),
(377, 157, 'Topic 2: AVG() and SUM()', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760513125_Screenshot 2025-10-15 152519.png\" style=\"width: 357px;\"><br></p>', 1),
(378, 157, 'Topic 3: GROUP BY', '<p><b>Group data by a column value.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760513161_Screenshot 2025-10-15 152556.png\" style=\"width: 297px;\"><b><br></b></p>', 1),
(379, 158, 'Topic 1: Primary and Foreign Keys', '<p>A <strong data-start=\"3185\" data-end=\"3200\">primary key</strong> uniquely identifies a record.</p><p>A <strong data-start=\"3235\" data-end=\"3250\">foreign key</strong> links data between two tables.</p><p><b>Example:</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760513219_Screenshot 2025-10-15 152652.png\" style=\"width: 576.8px;\"><b><br></b></p>', 1),
(380, 159, 'Topic 1: INNER JOIN', '<p><b>Fetch related data from multiple tables.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760513266_Screenshot 2025-10-15 152740.png\" style=\"width: 576.8px;\"><b><br></b></p>', 1),
(381, 159, 'Topic 2: LEFT JOIN', '<p><b>Shows all students even if they are not enrolled.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760513294_Screenshot 2025-10-15 152808.png\" style=\"width: 576.8px;\"><b><br></b></p>', 1),
(382, 159, 'Topic 3: RIGHT JOIN', '<p><b>Shows all courses even if no one enrolled.</b></p><p><img src=\"/skillcertsystem/uploads/lesson_files/1760513321_Screenshot 2025-10-15 152836.png\" style=\"width: 576.8px;\"><b><br></b></p>', 1),
(383, 160, 'Topic 1: Connecting to Database', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760513357_Screenshot 2025-10-15 152911.png\" style=\"width: 576.8px;\"><br></p>', 1),
(384, 160, 'Topic 2: Running Queries', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760513379_Screenshot 2025-10-15 152933.png\" style=\"width: 576.8px;\"><br></p>', 1),
(385, 160, 'Topic 3: Inserting Data via PHP', '<p><img src=\"/skillcertsystem/uploads/lesson_files/1760513398_Screenshot 2025-10-15 152953.png\" style=\"width: 576.8px;\"><br></p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `module_title` varchar(255) NOT NULL,
  `module_order` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `course_id`, `module_title`, `module_order`) VALUES
(13, 19, 'FINALS', 3),
(14, 40, 'PRELIM', 1),
(28, 19, 'MIDTERM', 2),
(29, 19, 'PRELIM', 1),
(31, 22, 'PRELIM', 1),
(32, 20, 'PRELIM', 1),
(33, 20, 'MIDTERM', 2),
(34, 20, 'FINALS', 3),
(36, 22, 'MIDTERM', 2),
(37, 22, 'FINALS', 3),
(38, 23, 'PRELIM', 1),
(39, 23, 'MIDTERM', 2),
(40, 23, 'FINALS', 3),
(41, 38, 'PRELIM', 1),
(42, 38, 'MIDTERM', 2),
(43, 38, 'FINALS', 3),
(44, 40, 'MIDTERM', 2),
(45, 40, 'FINALS', 3);

-- --------------------------------------------------------

--
-- Table structure for table `security_logs`
--

CREATE TABLE `security_logs` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `exam_id` int(10) UNSIGNED NOT NULL,
  `warning_count` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security_logs`
--

INSERT INTO `security_logs` (`log_id`, `user_id`, `exam_id`, `warning_count`) VALUES
(44, 158, 93, 1),
(45, 154, 101, 1);

-- --------------------------------------------------------

--
-- Table structure for table `topic_progress`
--

CREATE TABLE `topic_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topic_progress`
--

INSERT INTO `topic_progress` (`id`, `user_id`, `lesson_id`, `topic_id`, `completed`, `completed_at`) VALUES
(521, 154, 112, 208, 1, NULL),
(522, 154, 112, 209, 1, NULL),
(523, 154, 112, 210, 1, NULL),
(524, 154, 112, 211, 1, NULL),
(525, 154, 113, 212, 1, NULL),
(526, 154, 113, 213, 1, NULL),
(527, 154, 113, 214, 1, NULL),
(528, 154, 113, 215, 1, NULL),
(529, 154, 114, 216, 1, NULL),
(530, 154, 114, 217, 1, NULL),
(531, 154, 114, 218, 1, NULL),
(532, 154, 114, 219, 1, NULL),
(533, 154, 108, 220, 1, NULL),
(534, 154, 108, 221, 1, NULL),
(535, 154, 108, 222, 1, NULL),
(536, 154, 108, 223, 1, NULL),
(537, 154, 109, 224, 1, NULL),
(538, 154, 109, 225, 1, NULL),
(539, 154, 109, 226, 1, NULL),
(540, 154, 109, 227, 1, NULL),
(541, 154, 110, 228, 1, NULL),
(542, 154, 110, 229, 1, NULL),
(543, 154, 110, 230, 1, NULL),
(544, 154, 110, 231, 1, NULL),
(545, 154, 82, 232, 1, NULL),
(546, 154, 82, 233, 1, NULL),
(547, 154, 82, 234, 1, NULL),
(548, 154, 82, 235, 1, NULL),
(549, 154, 83, 236, 1, NULL),
(550, 154, 83, 237, 1, NULL),
(551, 154, 83, 238, 1, NULL),
(552, 154, 84, 239, 1, NULL),
(553, 154, 84, 240, 1, NULL),
(554, 154, 84, 241, 1, NULL),
(555, 154, 117, 242, 1, NULL),
(556, 154, 117, 243, 1, NULL),
(557, 154, 117, 244, 1, NULL),
(558, 154, 117, 245, 1, NULL),
(559, 154, 118, 246, 1, NULL),
(560, 154, 118, 247, 1, NULL),
(561, 154, 118, 248, 1, NULL),
(562, 154, 118, 249, 1, NULL),
(563, 154, 119, 250, 1, NULL),
(564, 154, 119, 251, 1, NULL),
(565, 154, 119, 252, 1, NULL),
(566, 154, 119, 253, 1, NULL),
(567, 154, 120, 254, 1, NULL),
(568, 154, 120, 255, 1, NULL),
(569, 154, 120, 256, 1, NULL),
(570, 154, 120, 257, 1, NULL),
(571, 154, 121, 258, 1, NULL),
(572, 154, 121, 259, 1, NULL),
(573, 154, 121, 260, 1, NULL),
(574, 154, 121, 261, 1, NULL),
(575, 154, 122, 263, 1, NULL),
(576, 154, 122, 264, 1, NULL),
(577, 154, 122, 265, 1, NULL),
(578, 154, 122, 266, 1, NULL),
(579, 154, 123, 268, 1, NULL),
(580, 154, 123, 269, 1, NULL),
(581, 154, 123, 270, 1, NULL),
(582, 154, 123, 271, 1, NULL),
(583, 154, 124, 272, 1, NULL),
(584, 154, 124, 273, 1, NULL),
(585, 154, 124, 274, 1, NULL),
(586, 154, 124, 275, 1, NULL),
(587, 154, 125, 276, 1, NULL),
(588, 154, 125, 277, 1, NULL),
(589, 154, 125, 278, 1, NULL),
(590, 154, 125, 279, 1, NULL),
(591, 154, 115, 280, 1, NULL),
(592, 154, 115, 281, 1, NULL),
(593, 154, 115, 282, 1, NULL),
(594, 154, 116, 283, 1, NULL),
(595, 154, 116, 284, 1, NULL),
(596, 154, 116, 285, 1, NULL),
(597, 154, 127, 286, 1, NULL),
(598, 154, 127, 287, 1, NULL),
(599, 154, 127, 288, 1, NULL),
(600, 154, 128, 289, 1, NULL),
(601, 154, 128, 290, 1, NULL),
(602, 154, 128, 291, 1, NULL),
(603, 154, 129, 292, 1, NULL),
(604, 154, 129, 293, 1, NULL),
(605, 154, 129, 294, 1, NULL),
(606, 154, 130, 295, 1, NULL),
(607, 154, 130, 296, 1, NULL),
(608, 154, 130, 297, 1, NULL),
(609, 154, 131, 298, 1, NULL),
(610, 154, 131, 299, 1, NULL),
(611, 154, 131, 300, 1, NULL),
(612, 154, 132, 301, 1, NULL),
(613, 154, 132, 302, 1, NULL),
(614, 154, 132, 303, 1, NULL),
(615, 154, 133, 304, 1, NULL),
(616, 154, 133, 305, 1, NULL),
(617, 154, 133, 306, 1, NULL),
(618, 154, 134, 307, 1, NULL),
(619, 154, 134, 308, 1, NULL),
(620, 154, 134, 309, 1, NULL),
(621, 154, 135, 310, 1, NULL),
(622, 154, 135, 311, 1, NULL),
(623, 154, 135, 312, 1, NULL),
(624, 154, 136, 313, 1, NULL),
(625, 154, 136, 314, 1, NULL),
(626, 154, 136, 315, 1, NULL),
(627, 154, 152, 361, 1, NULL),
(628, 154, 137, 316, 1, NULL),
(629, 154, 137, 317, 1, NULL),
(630, 154, 137, 318, 1, NULL),
(631, 154, 138, 319, 1, NULL),
(632, 154, 138, 320, 1, NULL),
(633, 154, 138, 321, 1, NULL),
(634, 154, 139, 322, 1, NULL),
(635, 154, 139, 323, 1, NULL),
(636, 154, 139, 324, 1, NULL),
(637, 154, 140, 325, 1, NULL),
(638, 154, 140, 326, 1, NULL),
(639, 154, 140, 327, 1, NULL),
(640, 154, 141, 328, 1, NULL),
(641, 154, 141, 329, 1, NULL),
(642, 154, 141, 330, 1, NULL),
(643, 154, 142, 331, 1, NULL),
(644, 154, 142, 332, 1, NULL),
(645, 154, 142, 333, 1, NULL),
(646, 154, 152, 362, 1, NULL),
(647, 154, 152, 363, 1, NULL),
(648, 154, 153, 364, 1, NULL),
(649, 154, 153, 365, 1, NULL),
(650, 154, 153, 366, 1, NULL),
(651, 154, 154, 367, 1, NULL),
(652, 154, 154, 368, 1, NULL),
(653, 154, 154, 369, 1, NULL),
(654, 154, 155, 370, 1, NULL),
(655, 154, 155, 371, 1, NULL),
(656, 154, 155, 372, 1, NULL),
(657, 154, 156, 373, 1, NULL),
(658, 154, 156, 374, 1, NULL),
(659, 154, 156, 375, 1, NULL),
(660, 154, 157, 376, 1, NULL),
(661, 154, 157, 377, 1, NULL),
(662, 154, 157, 378, 1, NULL),
(663, 155, 112, 208, 1, NULL),
(664, 155, 112, 209, 1, NULL),
(665, 155, 112, 210, 1, NULL),
(666, 155, 112, 211, 1, NULL),
(667, 155, 113, 212, 1, NULL),
(668, 155, 113, 213, 1, NULL),
(669, 155, 113, 214, 1, NULL),
(670, 155, 113, 215, 1, NULL),
(671, 155, 114, 216, 1, NULL),
(672, 155, 114, 217, 1, NULL),
(673, 155, 114, 218, 1, NULL),
(674, 155, 114, 219, 1, NULL),
(675, 155, 108, 220, 1, NULL),
(676, 155, 108, 221, 1, NULL),
(677, 155, 108, 222, 1, NULL),
(678, 155, 108, 223, 1, NULL),
(679, 155, 109, 224, 1, NULL),
(680, 155, 109, 225, 1, NULL),
(681, 155, 109, 226, 1, NULL),
(682, 155, 109, 227, 1, NULL),
(683, 155, 110, 228, 1, NULL),
(684, 155, 110, 229, 1, NULL),
(685, 155, 110, 230, 1, NULL),
(686, 155, 110, 231, 1, NULL),
(687, 155, 82, 232, 1, NULL),
(688, 155, 82, 233, 1, NULL),
(689, 155, 82, 234, 1, NULL),
(690, 155, 82, 235, 1, NULL),
(691, 155, 83, 236, 1, NULL),
(692, 155, 83, 237, 1, NULL),
(693, 155, 83, 238, 1, NULL),
(694, 155, 84, 239, 1, NULL),
(695, 155, 84, 240, 1, NULL),
(696, 155, 84, 241, 1, NULL),
(697, 155, 117, 242, 1, NULL),
(698, 155, 117, 243, 1, NULL),
(699, 155, 117, 244, 1, NULL),
(700, 155, 117, 245, 1, NULL),
(701, 155, 118, 246, 1, NULL),
(702, 155, 118, 247, 1, NULL),
(703, 155, 118, 248, 1, NULL),
(704, 155, 118, 249, 1, NULL),
(705, 155, 119, 250, 1, NULL),
(706, 155, 119, 251, 1, NULL),
(707, 155, 119, 252, 1, NULL),
(708, 155, 119, 253, 1, NULL),
(709, 155, 120, 254, 1, NULL),
(710, 155, 120, 255, 1, NULL),
(711, 155, 120, 256, 1, NULL),
(712, 155, 120, 257, 1, NULL),
(713, 155, 121, 258, 1, NULL),
(714, 155, 121, 259, 1, NULL),
(715, 155, 121, 260, 1, NULL),
(716, 155, 121, 261, 1, NULL),
(717, 155, 122, 263, 1, NULL),
(718, 155, 122, 264, 1, NULL),
(719, 155, 122, 265, 1, NULL),
(720, 155, 122, 266, 1, NULL),
(721, 155, 123, 268, 1, NULL),
(722, 155, 123, 269, 1, NULL),
(723, 155, 123, 270, 1, NULL),
(724, 155, 123, 271, 1, NULL),
(725, 155, 124, 272, 1, NULL),
(726, 155, 124, 273, 1, NULL),
(727, 155, 124, 274, 1, NULL),
(728, 155, 124, 275, 1, NULL),
(729, 155, 125, 276, 1, NULL),
(730, 155, 125, 277, 1, NULL),
(731, 155, 125, 278, 1, NULL),
(732, 155, 125, 279, 1, NULL),
(733, 155, 115, 280, 1, NULL),
(734, 155, 115, 281, 1, NULL),
(735, 155, 115, 282, 1, NULL),
(736, 155, 116, 283, 1, NULL),
(737, 155, 116, 284, 1, NULL),
(738, 155, 116, 285, 1, NULL),
(739, 155, 127, 286, 1, NULL),
(740, 155, 127, 287, 1, NULL),
(741, 155, 127, 288, 1, NULL),
(742, 155, 128, 289, 1, NULL),
(743, 155, 128, 290, 1, NULL),
(744, 155, 128, 291, 1, NULL),
(745, 155, 129, 292, 1, NULL),
(746, 155, 129, 293, 1, NULL),
(747, 155, 129, 294, 1, NULL),
(748, 155, 130, 295, 1, NULL),
(749, 155, 130, 296, 1, NULL),
(750, 155, 130, 297, 1, NULL),
(751, 155, 131, 298, 1, NULL),
(752, 155, 131, 299, 1, NULL),
(753, 155, 131, 300, 1, NULL),
(754, 155, 132, 301, 1, NULL),
(755, 155, 132, 302, 1, NULL),
(756, 155, 132, 303, 1, NULL),
(757, 155, 133, 304, 1, NULL),
(758, 155, 133, 305, 1, NULL),
(759, 155, 133, 306, 1, NULL),
(760, 155, 134, 307, 1, NULL),
(761, 155, 134, 308, 1, NULL),
(762, 155, 134, 309, 1, NULL),
(763, 155, 135, 310, 1, NULL),
(764, 155, 135, 311, 1, NULL),
(765, 155, 135, 312, 1, NULL),
(766, 155, 136, 313, 1, NULL),
(767, 155, 136, 314, 1, NULL),
(768, 155, 136, 315, 1, NULL),
(769, 156, 143, 334, 1, NULL),
(770, 156, 143, 335, 1, NULL),
(771, 156, 143, 336, 1, NULL),
(772, 156, 144, 337, 1, NULL),
(773, 156, 144, 338, 1, NULL),
(774, 156, 144, 339, 1, NULL),
(775, 156, 145, 340, 1, NULL),
(776, 156, 145, 341, 1, NULL),
(777, 156, 145, 342, 1, NULL),
(778, 156, 146, 343, 1, NULL),
(779, 156, 146, 344, 1, NULL),
(780, 156, 146, 345, 1, NULL),
(781, 156, 147, 346, 1, NULL),
(782, 156, 147, 347, 1, NULL),
(783, 156, 147, 348, 1, NULL),
(784, 156, 148, 349, 1, NULL),
(785, 156, 148, 350, 1, NULL),
(786, 156, 148, 351, 1, NULL),
(787, 156, 149, 352, 1, NULL),
(788, 156, 149, 353, 1, NULL),
(789, 156, 149, 354, 1, NULL),
(790, 156, 150, 355, 1, NULL),
(791, 156, 150, 356, 1, NULL),
(792, 156, 150, 357, 1, NULL),
(793, 156, 151, 358, 1, NULL),
(794, 156, 151, 359, 1, NULL),
(795, 156, 151, 360, 1, NULL),
(796, 156, 117, 242, 1, NULL),
(797, 156, 117, 243, 1, NULL),
(798, 156, 117, 244, 1, NULL),
(799, 156, 117, 245, 1, NULL),
(800, 156, 118, 246, 1, NULL),
(801, 156, 118, 247, 1, NULL),
(802, 156, 118, 248, 1, NULL),
(803, 156, 118, 249, 1, NULL),
(804, 156, 119, 250, 1, NULL),
(805, 156, 119, 251, 1, NULL),
(806, 156, 119, 252, 1, NULL),
(807, 156, 119, 253, 1, NULL),
(808, 157, 112, 208, 1, NULL),
(809, 157, 112, 209, 1, NULL),
(810, 157, 112, 210, 1, NULL),
(811, 157, 112, 211, 1, NULL),
(812, 157, 113, 212, 1, NULL),
(813, 157, 113, 213, 1, NULL),
(814, 157, 113, 214, 1, NULL),
(815, 157, 113, 215, 1, NULL),
(816, 157, 114, 216, 1, NULL),
(817, 157, 114, 217, 1, NULL),
(818, 157, 114, 218, 1, NULL),
(819, 157, 114, 219, 1, NULL),
(820, 157, 108, 220, 1, NULL),
(821, 157, 108, 221, 1, NULL),
(822, 157, 108, 222, 1, NULL),
(823, 157, 108, 223, 1, NULL),
(824, 157, 109, 224, 1, NULL),
(825, 157, 109, 225, 1, NULL),
(826, 157, 109, 226, 1, NULL),
(827, 157, 109, 227, 1, NULL),
(828, 157, 110, 228, 1, NULL),
(829, 157, 110, 229, 1, NULL),
(830, 157, 110, 230, 1, NULL),
(831, 157, 110, 231, 1, NULL),
(832, 157, 82, 232, 1, NULL),
(833, 157, 82, 233, 1, NULL),
(834, 157, 82, 234, 1, NULL),
(835, 157, 82, 235, 1, NULL),
(836, 157, 83, 236, 1, NULL),
(837, 157, 83, 237, 1, NULL),
(838, 157, 83, 238, 1, NULL),
(839, 157, 84, 239, 1, NULL),
(840, 157, 84, 240, 1, NULL),
(841, 157, 84, 241, 1, NULL),
(842, 158, 112, 208, 1, NULL),
(843, 158, 112, 209, 1, NULL),
(844, 158, 112, 210, 1, NULL),
(845, 158, 112, 211, 1, NULL),
(846, 158, 113, 212, 1, NULL),
(847, 158, 113, 213, 1, NULL),
(848, 158, 113, 214, 1, NULL),
(849, 158, 113, 215, 1, NULL),
(850, 158, 114, 216, 1, NULL),
(851, 158, 114, 217, 1, NULL),
(852, 158, 114, 218, 1, NULL),
(853, 158, 114, 219, 1, NULL),
(854, 158, 108, 220, 1, NULL),
(855, 158, 108, 221, 1, NULL),
(856, 158, 108, 222, 1, NULL),
(857, 158, 108, 223, 1, NULL),
(858, 158, 109, 224, 1, NULL),
(859, 158, 109, 225, 1, NULL),
(860, 158, 109, 226, 1, NULL),
(861, 158, 109, 227, 1, NULL),
(862, 158, 110, 228, 1, NULL),
(863, 158, 110, 229, 1, NULL),
(864, 158, 110, 230, 1, NULL),
(865, 158, 110, 231, 1, NULL),
(866, 158, 82, 232, 1, NULL),
(867, 158, 82, 233, 1, NULL),
(868, 158, 82, 234, 1, NULL),
(869, 158, 82, 235, 1, NULL),
(870, 158, 83, 236, 1, NULL),
(871, 158, 83, 237, 1, NULL),
(872, 158, 83, 238, 1, NULL),
(873, 158, 84, 239, 1, NULL),
(874, 158, 84, 240, 1, NULL),
(875, 158, 84, 241, 1, NULL),
(876, 158, 117, 242, 1, NULL),
(877, 158, 117, 243, 1, NULL),
(878, 158, 117, 244, 1, NULL),
(879, 158, 117, 245, 1, NULL),
(880, 158, 118, 246, 1, NULL),
(881, 158, 118, 247, 1, NULL),
(882, 158, 118, 248, 1, NULL),
(883, 158, 118, 249, 1, NULL),
(884, 158, 119, 250, 1, NULL),
(885, 158, 119, 251, 1, NULL),
(886, 158, 119, 252, 1, NULL),
(887, 158, 119, 253, 1, NULL),
(888, 158, 120, 254, 1, NULL),
(889, 158, 120, 255, 1, NULL),
(890, 158, 120, 256, 1, NULL),
(891, 158, 120, 257, 1, NULL),
(892, 158, 121, 258, 1, NULL),
(893, 158, 121, 259, 1, NULL),
(894, 158, 121, 260, 1, NULL),
(895, 158, 121, 261, 1, NULL),
(896, 158, 122, 263, 1, NULL),
(897, 158, 122, 264, 1, NULL),
(898, 158, 122, 265, 1, NULL),
(899, 158, 122, 266, 1, NULL),
(900, 158, 123, 268, 1, NULL),
(901, 158, 123, 269, 1, NULL),
(902, 158, 123, 270, 1, NULL),
(903, 158, 123, 271, 1, NULL),
(904, 158, 124, 272, 1, NULL),
(905, 158, 124, 273, 1, NULL),
(906, 158, 124, 274, 1, NULL),
(907, 158, 124, 275, 1, NULL),
(908, 158, 125, 276, 1, NULL),
(909, 158, 125, 277, 1, NULL),
(910, 158, 125, 278, 1, NULL),
(911, 158, 125, 279, 1, NULL),
(912, 158, 152, 361, 1, NULL),
(913, 158, 152, 362, 1, NULL),
(914, 158, 152, 363, 1, NULL),
(915, 158, 153, 364, 1, NULL),
(916, 158, 153, 365, 1, NULL),
(917, 158, 153, 366, 1, NULL),
(918, 158, 154, 367, 1, NULL),
(919, 158, 154, 368, 1, NULL),
(920, 158, 154, 369, 1, NULL),
(921, 158, 155, 370, 1, NULL),
(922, 158, 155, 371, 1, NULL),
(923, 158, 155, 372, 1, NULL),
(924, 158, 156, 373, 1, NULL),
(925, 158, 156, 374, 1, NULL),
(926, 158, 156, 375, 1, NULL),
(927, 158, 157, 376, 1, NULL),
(928, 158, 157, 377, 1, NULL),
(929, 158, 157, 378, 1, NULL),
(930, 158, 158, 379, 1, NULL),
(931, 158, 159, 380, 1, NULL),
(932, 158, 159, 381, 1, NULL),
(933, 158, 159, 382, 1, NULL),
(934, 158, 160, 383, 1, NULL),
(935, 158, 160, 384, 1, NULL),
(936, 158, 160, 385, 1, NULL),
(937, 158, 143, 334, 1, NULL),
(938, 158, 143, 335, 1, NULL),
(939, 158, 143, 336, 1, NULL),
(940, 158, 144, 337, 1, NULL),
(941, 158, 144, 338, 1, NULL),
(942, 158, 144, 339, 1, NULL),
(943, 158, 145, 340, 1, NULL),
(944, 158, 145, 341, 1, NULL),
(945, 158, 145, 342, 1, NULL),
(946, 154, 158, 379, 1, NULL),
(947, 154, 159, 380, 1, NULL),
(948, 154, 159, 381, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(255) NOT NULL,
  `role` enum('admin','student') NOT NULL DEFAULT 'student',
  `status` enum('active','banned') NOT NULL DEFAULT 'active',
  `session_token` varchar(255) DEFAULT NULL,
  `certificate_count` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `status`, `session_token`, `certificate_count`, `created_at`, `updated_at`) VALUES
(142, 'admin', 'log', 'adminlog@gmail.com', '247247247', 'admin', 'active', NULL, 0, '2025-10-04 15:29:08', '2025-10-04 15:29:08'),
(154, 'Froilan', 'Adriano', 'froilan@1', '247247247', 'student', 'active', 'f43cc399b17555a0e253cd8c9ab87793f637382a562ed074294b6648028e085a', 0, '2025-10-15 07:45:03', '2025-10-15 07:45:03'),
(155, 'Renz ', 'Perez', 'renz@1', '123123123', 'student', 'active', NULL, 0, '2025-10-15 15:01:09', '2025-10-15 15:01:09'),
(156, 'Aaron', 'Pore', 'aaron@1', '12345678', 'student', 'active', NULL, 0, '2025-10-15 15:47:52', '2025-10-15 15:47:52'),
(157, 'Mark', 'Yow', 'mark@1', '123123123', 'student', 'active', NULL, 0, '2025-10-15 16:04:58', '2025-10-15 16:04:58'),
(158, 'John ', 'Doe', 'john@2', '321321321', 'student', 'active', NULL, 0, '2025-10-15 16:31:11', '2025-10-15 16:31:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`certificate_id`),
  ADD UNIQUE KEY `certificate_code` (`certificate_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `result_id` (`result_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `fk_lessons_course` (`course_id`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_lesson_progress` (`user_id`,`lesson_id`),
  ADD UNIQUE KEY `user_lesson_unique` (`user_id`,`lesson_id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `lesson_topics`
--
ALTER TABLE `lesson_topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `security_logs`
--
ALTER TABLE `security_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `topic_progress`
--
ALTER TABLE `topic_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_progress` (`user_id`,`topic_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `certificate_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `exam_answers`
--
ALTER TABLE `exam_answers`
  MODIFY `answer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=640;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `question_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=354;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `result_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=815;

--
-- AUTO_INCREMENT for table `lesson_topics`
--
ALTER TABLE `lesson_topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `security_logs`
--
ALTER TABLE `security_logs`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `topic_progress`
--
ALTER TABLE `topic_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=949;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD CONSTRAINT `exam_answers_ibfk_1` FOREIGN KEY (`result_id`) REFERENCES `exam_results` (`result_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `exam_questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD CONSTRAINT `exam_questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_results_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `fk_lessons_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessons_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE SET NULL;

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `lesson_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_4` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lesson_topics`
--
ALTER TABLE `lesson_topics`
  ADD CONSTRAINT `lesson_topics_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `security_logs`
--
ALTER TABLE `security_logs`
  ADD CONSTRAINT `security_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `security_logs_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topic_progress`
--
ALTER TABLE `topic_progress`
  ADD CONSTRAINT `topic_progress_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `lesson_topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topic_progress_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
