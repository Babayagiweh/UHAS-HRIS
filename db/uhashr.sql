-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 02:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uhashr`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_rank`
--

CREATE TABLE `academic_rank` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `activity_title` varchar(255) NOT NULL,
  `activity_date` date NOT NULL,
  `activity_time` time NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `directorate` varchar(255) DEFAULT NULL,
  `number_of_attendees` int(11) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `activity_title`, `activity_date`, `activity_time`, `venue`, `directorate`, `number_of_attendees`, `approved_by`, `remarks`) VALUES
(1, 'WORK RESUMES', '2024-12-30', '21:57:00', 'UHAS', 'Directorate of HR', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `created_at`) VALUES
(1, 'Admin', 'd3c358692f876f59138b9596c29a924a', 'Hr', 'Uhas', 'hr@uhas.edu.gh', '2024-12-13 12:29:09'),
(4, 'Gakikor', '5a306e6ba466380922bfeaa5809e6112', 'Gabriel', 'Akikor', 'gakikor@uhas.edu.gh', '2024-12-17 14:49:03'),
(5, 'Gamoah', 'd37371f5be42af49c7888b1ef4911568', 'Godfred', 'Amoah', 'gamoah@uhas.edu.gh', '2025-01-07 18:26:19'),
(6, 'Dadonu', 'c6dbb592dd48e826bec08e51cd24295a', 'Delali', 'Adonu', 'dadonu@uhas.edu.gh', '2025-01-09 09:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `id_calendar` int(11) NOT NULL,
  `calendar_name` varchar(400) NOT NULL,
  `date_to` date NOT NULL,
  `date_from` date NOT NULL,
  `venue` text NOT NULL,
  `supervisory` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE `campus` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campus`
--

INSERT INTO `campus` (`id`, `name`) VALUES
(1, 'Trafalgar'),
(2, 'Hohoe Campus'),
(3, 'Main Campus Phase 1'),
(4, 'Main Campus Phase 2'),
(5, 'Basic School'),
(6, 'Dave Campus');

-- --------------------------------------------------------

--
-- Table structure for table `casual_staff`
--

CREATE TABLE `casual_staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `designation` varchar(100) NOT NULL,
  `present_appointment` date NOT NULL,
  `department` varchar(150) NOT NULL,
  `highest_qualifications` varchar(255) NOT NULL,
  `service_end_date` date NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `campus` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conferences`
--

CREATE TABLE `conferences` (
  `id` int(11) NOT NULL,
  `conference_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `conference_date` date NOT NULL,
  `conference_time` time NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `speaker` varchar(255) DEFAULT NULL,
  `remarks` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deceased`
--

CREATE TABLE `deceased` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `DoB` date DEFAULT NULL,
  `hometown` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `staff_category` varchar(100) DEFAULT NULL,
  `years_in_uhas` int(11) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `date_of_death` date NOT NULL,
  `place_of_death` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `files` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` int(11) NOT NULL,
  `department_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `department_name`) VALUES
(2, 'Archival Unit'),
(3, 'Directorate of Academic Affairs'),
(4, 'Directorate of Finance'),
(5, 'Directorate of Human Resource'),
(6, 'Directorate of ICT'),
(7, 'Directorate of Internal Audit'),
(8, 'Directorate of Quality Assurance'),
(9, 'Directorate of Works and Physical Development'),
(10, 'International Programmes Office'),
(11, 'Legal Service Unit'),
(12, 'Office of Graduate Studies'),
(13, 'Office of Student Affairs'),
(14, 'Office of the Pro-Vice Chancellor'),
(15, 'Office of the Registrar'),
(16, 'Office of the Vice Chancellor'),
(17, 'Procurement and Supply Unit'),
(18, 'UHAS Basic School'),
(19, 'Vocational Training Unit'),
(20, 'Fred N. Binka School of Public Health'),
(21, 'Institute of Health Research'),
(22, 'Institute of Traditional and Alternative Medicine'),
(23, 'School of Allied Health Sciences'),
(24, 'School of Basic and Biomedical Sciences'),
(25, 'School of Dentistry'),
(26, 'School of Nursing and Midwifery'),
(27, 'School of Pharmacy'),
(28, 'School of Sports and Exercise Medicine'),
(29, 'University Library');

-- --------------------------------------------------------

--
-- Table structure for table `directories`
--

CREATE TABLE `directories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `directories`
--

INSERT INTO `directories` (`id`, `name`) VALUES
(3, 'Directorate of Academic Affairs'),
(4, 'Directorate of Finance'),
(5, 'Directorate of Human Resource'),
(6, 'Directorate of ICT'),
(7, 'Directorate of Internal Audit'),
(8, 'Directorate of Quality Assurance'),
(9, 'Directorate of Works and Physical Development');

-- --------------------------------------------------------

--
-- Table structure for table `employee_status`
--

CREATE TABLE `employee_status` (
  `id_employee_status` int(11) NOT NULL,
  `employee_status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_status`
--

INSERT INTO `employee_status` (`id_employee_status`, `employee_status_name`) VALUES
(1, 'Permanent '),
(2, 'Contract'),
(3, 'Part-Time'),
(4, 'Post-Retirement Contract'),
(5, 'National Service Personnel '),
(6, 'National Service Personnel ');

-- --------------------------------------------------------

--
-- Table structure for table `fixed_term_contract`
--

CREATE TABLE `fixed_term_contract` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `designation` varchar(100) NOT NULL,
  `present_appointment` date NOT NULL,
  `department` varchar(150) NOT NULL,
  `highest_qualifications` varchar(255) NOT NULL,
  `service_date` date NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `campus` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `highest_qualification`
--

CREATE TABLE `highest_qualification` (
  `id_highest_qualification` int(11) NOT NULL,
  `highest_qualification_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `highest_qualification`
--

INSERT INTO `highest_qualification` (`id_highest_qualification`, `highest_qualification_name`) VALUES
(2, 'Doctorate Degree(PhD)'),
(3, 'Master of Philosophy(Mphil)'),
(9, 'Master of Science(Msc.)'),
(10, 'Master of Business  Administration(MBA)'),
(11, 'Bachelor of Technology Degree(Btech)'),
(12, 'Bachelor of Science Degree(BSc.)'),
(13, 'Bachelor of Arts Degree(BA)'),
(14, 'Higher National Diploma(HND)'),
(15, 'Diploma'),
(16, 'SSSCE/WASSCE'),
(17, 'BECE'),
(18, 'Professional Certificate');

-- --------------------------------------------------------

--
-- Table structure for table `hr_member`
--

CREATE TABLE `hr_member` (
  `hr_id` int(11) NOT NULL,
  `hr_companyid` varchar(255) DEFAULT NULL,
  `hr_firstname` varchar(255) DEFAULT NULL,
  `hr_lastname` varchar(255) DEFAULT NULL,
  `hr_middlename` varchar(255) DEFAULT NULL,
  `hr_contactno` varchar(255) DEFAULT NULL,
  `hr_email` varchar(100) NOT NULL,
  `hr_password` varchar(100) NOT NULL,
  `hr_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hr_member`
--

INSERT INTO `hr_member` (`hr_id`, `hr_companyid`, `hr_firstname`, `hr_lastname`, `hr_middlename`, `hr_contactno`, `hr_email`, `hr_password`, `hr_type`) VALUES
(2, 'UHAS-133', 'hr officer', 'hr officer', 'h', '02417777777', 'hrofficer@gmail.com', 'hrofficer@123', 'HR Officer'),
(4, 'UHAS-1111', 'hrhead', 'hrhead', 'a', '02411111111', 'hrhead@gmail.com', 'hrhead@123', 'HR Head'),
(5, 'UHAS-1111', 'layla', 'tank', 'a', '02411122222', 'hrassistant@gmail.com', 'hrassistant@123', 'HR Assistant');

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `name`) VALUES
(21, 'Institute of Health Research'),
(22, 'Institute of Traditional and Alternative Medicine');

-- --------------------------------------------------------

--
-- Table structure for table `leave`
--

CREATE TABLE `leave` (
  `id_leave` int(11) NOT NULL,
  `leave_type` text NOT NULL,
  `staff_id` varchar(11) NOT NULL,
  `full_name` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `department` text NOT NULL,
  `campus` text NOT NULL,
  `present_appointment` text NOT NULL,
  `Academic_rank` text NOT NULL,
  `designation` text NOT NULL,
  `handing_over_notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `login_time` datetime NOT NULL,
  `actions` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `user_id`, `username`, `first_name`, `last_name`, `email`, `login_time`, `actions`, `ip_address`, `user_agent`) VALUES
(1, 1, 'uhashr', 'Hr', 'uhas', 'hr@uhas.edu.gh', '2024-12-17 15:40:56', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0'),
(2, 1, 'uhashr', 'Hr', 'uhas', 'hr@uhas.edu.gh', '2024-12-30 13:15:31', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0'),
(3, 1, 'uhashr', 'Hr', 'uhas', 'hr@uhas.edu.gh', '2024-12-30 13:16:10', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` int(11) NOT NULL,
  `meeting_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `meeting_date` date NOT NULL,
  `meeting_time` time NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `directorate` varchar(100) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nss`
--

CREATE TABLE `nss` (
  `nss_number` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `institution_attended` varchar(150) NOT NULL,
  `program_studied` varchar(100) NOT NULL,
  `qualification` varchar(50) NOT NULL,
  `nss_start_date` date NOT NULL,
  `department_posted` varchar(100) NOT NULL,
  `nss_end_date` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `campus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orientations`
--

CREATE TABLE `orientations` (
  `id` int(11) NOT NULL,
  `orientation_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `orientation_date` date NOT NULL,
  `orientation_time` time NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `remarks` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `part_time`
--

CREATE TABLE `part_time` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `mname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `contract_start_date` date DEFAULT NULL,
  `contract_end_date` date DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `dept` varchar(100) DEFAULT NULL,
  `campus` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `uhas_staff_category` varchar(100) DEFAULT NULL,
  `academic_rank` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

CREATE TABLE `personnel` (
  `staff_id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `date_on_present_grade` date DEFAULT NULL,
  `present_appointment` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `marital_status` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `hometown` varchar(100) DEFAULT NULL,
  `qualifications` text DEFAULT NULL,
  `details_of_highest_qualification` text DEFAULT NULL,
  `highest_qualification` varchar(100) DEFAULT NULL,
  `speciality` varchar(100) DEFAULT NULL,
  `first_appointment` date DEFAULT NULL,
  `date_hired` date DEFAULT NULL,
  `assumption_of_duty_date` date DEFAULT NULL,
  `other_appointment` text DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `staff_category` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `directory` varchar(100) DEFAULT NULL,
  `gog_unit` varchar(100) DEFAULT NULL,
  `campus` varchar(100) DEFAULT NULL,
  `end_of_contract_date` date DEFAULT NULL,
  `years_with_uhas` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email_official` varchar(100) DEFAULT NULL,
  `email_private` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnel_file`
--

CREATE TABLE `personnel_file` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(20) NOT NULL,
  `full_name` text NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_retirement_contract`
--

CREATE TABLE `post_retirement_contract` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `designation` varchar(100) NOT NULL,
  `present_appointment` date NOT NULL,
  `department` varchar(150) NOT NULL,
  `highest_qualifications` varchar(255) NOT NULL,
  `retired_date` date NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `campus` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `school` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_staff`
--

CREATE TABLE `project_staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `designation` varchar(100) NOT NULL,
  `present_appointment` date NOT NULL,
  `department` varchar(150) NOT NULL,
  `highest_qualifications` varchar(255) NOT NULL,
  `project_title` text NOT NULL,
  `project_start_date` date NOT NULL,
  `project_end_date` date NOT NULL,
  `project_supervisor` varchar(100) NOT NULL,
  `project_team` varchar(200) NOT NULL,
  `campus` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resignation`
--

CREATE TABLE `resignation` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `present_appointment` varchar(255) NOT NULL,
  `date_hired` date NOT NULL,
  `department` varchar(255) NOT NULL,
  `date_on_present_grade` date NOT NULL,
  `academic_rank` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `reason_of_resignation` text NOT NULL,
  `effective_date` date NOT NULL,
  `email_official` varchar(100) NOT NULL,
  `email_private` varchar(100) NOT NULL,
  `files` varchar(255) DEFAULT NULL,
  `campus` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retiree`
--

CREATE TABLE `retiree` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `DoB` date DEFAULT NULL,
  `hometown` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `staff_category` varchar(100) DEFAULT NULL,
  `highest_qualifications` varchar(255) DEFAULT NULL,
  `date_hired` date DEFAULT NULL,
  `years_in_uhas` int(11) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `positions_held` text DEFAULT NULL,
  `date_of_retired` date NOT NULL,
  `grade_retired` varchar(100) DEFAULT NULL,
  `campus` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `files` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id_school` int(11) NOT NULL,
  `school_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seminars`
--

CREATE TABLE `seminars` (
  `id` int(11) NOT NULL,
  `seminar_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `seminar_date` date NOT NULL,
  `seminar_time` time NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `remarks` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(11) NOT NULL,
  `controller_no` varchar(50) NOT NULL,
  `ghanacard_no` text NOT NULL,
  `duty_status` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `designation` text NOT NULL,
  `employee_status` text NOT NULL,
  `date_on_present_grade` date DEFAULT NULL,
  `present_appointment` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `marital_status` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `hometown` varchar(100) DEFAULT NULL,
  `qualifications` text DEFAULT NULL,
  `details_of_highest_qualification` text DEFAULT NULL,
  `highest_qualification` varchar(100) DEFAULT NULL,
  `speciality` varchar(100) DEFAULT NULL,
  `first_appointment` date DEFAULT NULL,
  `date_hired` date DEFAULT NULL,
  `assumption_of_duty_date` date DEFAULT NULL,
  `other_appointment` varchar(255) DEFAULT NULL,
  `from_appointment` date DEFAULT NULL,
  `to_appointment` date DEFAULT NULL,
  `staff_category` varchar(50) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `directory` varchar(255) DEFAULT NULL,
  `gog_unit` varchar(100) DEFAULT NULL,
  `campus` varchar(100) DEFAULT NULL,
  `end_of_contract_date` date DEFAULT NULL,
  `years_with_uhas` int(11) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email_official` varchar(100) DEFAULT NULL,
  `email_private` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `files` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `controller_no`, `ghanacard_no`, `duty_status`, `status`, `from_date`, `to_date`, `first_name`, `middle_name`, `last_name`, `title`, `full_name`, `designation`, `employee_status`, `date_on_present_grade`, `present_appointment`, `dob`, `marital_status`, `gender`, `hometown`, `qualifications`, `details_of_highest_qualification`, `highest_qualification`, `speciality`, `first_appointment`, `date_hired`, `assumption_of_duty_date`, `other_appointment`, `from_appointment`, `to_appointment`, `staff_category`, `department`, `directory`, `gog_unit`, `campus`, `end_of_contract_date`, `years_with_uhas`, `phone`, `email_official`, `email_private`, `birthday`, `files`) VALUES
(186, 'UHAS-00458', '7031', 'GHA-328743953-4', 'AT POST', 'Active', '0000-00-00', '0000-00-00', 'Alhassan', 'Robert', 'Kaba', 'Dr.', 'Alhassan Robert Kaba Dr.', 'Director of Human Resource', 'Permanent', '2024-12-16', 'Associate Professor', '2004-12-16', 'Single', 'Male', 'Ga Mashi', 'MSc HRM', 'PhD in HRM', 'Masters', 'HRM', '2024-11-01', '2024-11-01', '2024-11-01', 'HOD', '2024-11-01', '2025-11-01', 'Senior Administrative staff', 'PROCUREMENT', 'Allocation', 'GTEC', 'Hohoe', NULL, 20, '+233 598-121-33', 'yie@gmail.com', 'yie@gmail.com', '1999-12-30', 'img.67'),
(187, 'UHAS-00911', '1303', 'GHA-948539559-7', 'FELLOWSHIP', 'inactive', '0000-00-00', '0000-00-00', 'Mottey', 'Elsie', 'Ewoenam', 'Ms.', 'Mottey Elsie Ewoenam Ms.', 'Assistant Registrar', 'permanent', '2024-12-16', 'Professor (Post-Retirement Contract)', '1994-12-16', 'Married', 'Female', 'Tema', 'MTech', 'PhD in HRM', 'Phd', 'medicine', '2024-11-01', '2024-11-01', '2024-11-01', 'Director', '2024-11-01', '2026-11-01', 'Junior  Staff', 'Directorate of ICT', 'administrative computing', '', 'Main campus phase 1', NULL, 10, '+233 598-121-34', 'com@gmail.com', 'jimmy@gmail. com', '1999-12-31', 'img.68');

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `page_visited` varchar(255) NOT NULL,
  `action` text NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL,
  `training_title` varchar(255) NOT NULL,
  `training_date` date NOT NULL,
  `training_time` time NOT NULL,
  `venue` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `Remarks` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uhas_designation`
--

CREATE TABLE `uhas_designation` (
  `id` int(11) NOT NULL,
  `designation_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uhas_designation`
--

INSERT INTO `uhas_designation` (`id`, `designation_name`) VALUES
(41, 'Chief Accounting Assistant'),
(42, 'Chief Administrative Assistant'),
(43, 'Chief Assistant Binder'),
(44, 'Chief Assistant Printer'),
(45, 'Auditing Assistant'),
(46, 'Chief Dental Hygienist/Therapist'),
(47, 'Chief Dental Surgery Assistant'),
(48, 'Chief Dental Technologist'),
(49, 'Chief Designer'),
(50, 'Chief Dispensing Technician'),
(51, 'Chief Domestic Bursar'),
(52, 'Chief Draughtsman'),
(53, 'Chief Estate Assistant'),
(54, 'Chief Fire Prevention Officer'),
(55, 'Chief Health Superintendent'),
(56, 'Chief ICT Assistant'),
(57, 'Chief Instructor'),
(58, 'Chief Laboratory Technician'),
(59, 'Chief Library Assistant'),
(60, 'Chief Medical Assistant'),
(61, 'Chief Medical Assistant/Illustrator/Artist'),
(62, 'Chief Medical Photographer'),
(63, 'Chief Medical Records Technician'),
(64, 'Chief Midwifery Superintendent'),
(65, 'Chief Nurse Anesthetist'),
(66, 'Chief Nursing Officer'),
(67, 'Chief Organiser'),
(68, 'Chief Performing Artist'),
(69, 'Chief Porter'),
(70, 'Chief Procurement Assistant'),
(71, 'Chief Quantity Surveyor Assistant'),
(72, 'Chief Research Assistant'),
(73, 'Chief Security Officer'),
(74, 'Chief Stores Superintendent'),
(75, 'Chief Teacher'),
(76, 'Chief Technician'),
(77, 'Chief Telephone Superintendent'),
(78, 'Chief University Sports Coach'),
(79, 'Chief Work Superintendent'),
(80, 'Chief X-Ray Technician'),
(81, 'Clerk of Works'),
(82, 'Chief Assistant Curator'),
(83, 'Farm Manager'),
(84, 'Superintendent Technologist'),
(85, 'Transport Officer'),
(86, 'Principal Accounting Assistant'),
(87, 'Principal Administrative Assistant'),
(88, 'Principal Assistant Binder'),
(89, 'Principal Assistant Bookshop Manager'),
(90, 'Principal Assistant Curator'),
(91, 'Principal  Assistant Farm Manager'),
(92, 'Principal Assistant Printer'),
(93, 'Principal Assistant Transport Officer'),
(94, 'Principal Auditing Assistant'),
(95, 'Principal Clerks of Works'),
(96, 'Principal Data Operating Officer'),
(97, 'Principal Dental Technologist'),
(98, 'Principal Designer'),
(99, 'Principal Dispensing Technician'),
(100, 'Principal Domestic Bursar'),
(101, 'Principal Draughtsman'),
(102, 'Principal Estate Assistant'),
(103, 'Principal Fire Prevention Officer'),
(104, 'Principal Health Superintendent'),
(105, 'Principal ICT Assistant'),
(106, 'Principal Instructor'),
(107, 'Principal Laboratory Technician'),
(108, 'Principal Library Assistant'),
(109, 'Principal Medical Artist/Instructor'),
(110, 'Principal Medical Assistant'),
(111, 'Principal Medical Photographer'),
(112, 'Principal Medical Records Technician'),
(113, 'Principal Midwifery Superintendent'),
(114, 'Principal Nurse Anesthetist'),
(115, 'Principal Nursing Officer'),
(116, 'Principal Organiser'),
(117, 'Principal Performing Artist'),
(118, 'Principal Porter'),
(119, 'Principal Procurement Assistant'),
(120, 'Quality Surveyor Assistant'),
(121, 'Senior Medical Artist/Instructor'),
(122, 'Senior Medical Photographer'),
(123, 'Senior Medical Records Technician'),
(124, 'Senior Midwifery Superintendent'),
(125, 'Senior Nurse Anesthetist'),
(126, 'Senior Nursing Officer'),
(127, 'Senior Organiser'),
(128, 'Senior Performing Artist'),
(129, 'Senior Porter'),
(130, 'Senior Procurement Assistant'),
(131, 'Senior Research Assistant'),
(132, 'Senior Security Officer'),
(133, 'Senior Teacher'),
(134, 'Senior Technician'),
(135, 'Senior Telephone Superintendent'),
(136, 'Senior University Sports Coach'),
(137, 'Senior Works Superintendent'),
(138, 'Senior X-Ray Technician'),
(139, 'Accounting Assistant'),
(140, 'Administrative Assistant'),
(141, 'Assistant Binder'),
(142, 'Assistant Clerk of Works'),
(143, 'Assistant Curator'),
(144, 'Assistant Farm Manager'),
(145, 'Assistant Bookshop Manager'),
(146, 'Assistant Printer'),
(147, 'Assistant Transport Officer'),
(148, 'Data Entry Officer'),
(149, 'Dental Hygienist Therapist'),
(150, 'Dental Surgery Assistant'),
(151, 'Dental Technologist'),
(152, 'Dispensing Technician'),
(153, 'Domestic Bursar'),
(154, 'Draughtsman'),
(155, 'Estate Assistant'),
(156, 'Fire Prevention Officer'),
(157, 'Health Superintendent'),
(158, 'ICT Assistant'),
(159, 'Instructor'),
(160, 'Chief Driver'),
(161, 'Assistant Technician'),
(162, 'Assistant Porter'),
(163, 'Senior Estate Assistant'),
(164, 'Bindery Assistant 1'),
(165, 'Bookshop Assistant I'),
(166, 'Chief Cook/Baker'),
(167, 'Senior Health Inspector'),
(168, 'Chief Steward'),
(169, 'Dental Technical Assistant I'),
(170, 'Foreman'),
(171, 'Assistant Security Officer'),
(172, 'Health Inspector I'),
(173, 'Junior Library Assistant I'),
(174, 'Junior Research Assistant I'),
(175, 'Laundry Supervisor'),
(176, 'Overseer'),
(177, 'Printing Assistant I'),
(178, 'Senior Accounts Clerk'),
(179, 'Senior Audit Clerk'),
(180, 'Senior Clerk'),
(181, 'Senior Departmental Assistant'),
(182, 'Senior Dispensing Assistant'),
(183, 'Senior Domestic Assistant'),
(184, 'Senior Class Assistance'),
(185, 'Senior Store Keeper'),
(186, 'Traffic Supervisor'),
(187, 'Farm Overseer I'),
(188, 'Artisan'),
(189, 'Assistant Prosector I'),
(190, 'Bookshop Assistant II'),
(191, 'Senior Campus Guard'),
(192, 'Assistant Draughtsman II'),
(193, 'Technical Assistant I'),
(194, 'Dancer I'),
(195, 'Dispensing Assistant I'),
(196, 'Drummer I'),
(197, 'Farm Overseer II'),
(198, 'Junior Dental Assistant II'),
(199, 'Meter Reader I'),
(200, 'Audit Clerk II'),
(201, 'Campus Guard I'),
(202, 'Caterpillar Driver/Tractor Operator'),
(203, 'Clerk II'),
(204, 'Computer Typesetter III'),
(205, 'Dispensing Assistant II'),
(206, 'Driver I'),
(207, 'Fireman'),
(208, 'Life Guard I'),
(209, 'Meter Reader II'),
(210, 'Senior Cook/Baker'),
(211, 'Assistant Draughtsman III'),
(212, 'Storekeeper II'),
(213, 'Head Mortuaryman'),
(214, 'Senior Typist'),
(215, 'Ward/Health Care Assistant'),
(216, 'Driver II'),
(217, 'Campus Guard II'),
(218, 'Nurseryman'),
(219, 'Sanitary/Health Headman/Labourer Headman'),
(220, 'Supervisor'),
(221, 'Assistant Overseer III'),
(222, 'Baker'),
(223, 'Cook'),
(224, 'Dancer III'),
(225, 'Drummer III'),
(226, 'Junior Library Assistant III'),
(227, 'Junior Research Assistant III'),
(228, 'Labourer Stockman'),
(229, 'Nurse/Ward Assistant'),
(230, 'Head Cleaner-Mesenger'),
(231, 'Senior Conservancy Labourer'),
(232, 'Senior Laundryman'),
(233, 'Senior Sanitary Labourer'),
(234, 'Technician Assistant II'),
(235, 'Technician Assistant III'),
(236, 'Telephonist'),
(237, 'Tradesman II/Mechanic II'),
(238, 'Typist I'),
(239, 'Conservancy Labourer/Labourer Headman'),
(240, 'Registrar'),
(241, 'Deputy Registrar'),
(242, 'College Registrar'),
(243, 'Senior Assistant Registrar'),
(244, 'Assistant Registrar'),
(245, 'Junior Assistant Registrar'),
(246, 'Director of Academics'),
(247, 'Director of Administration'),
(248, 'Director (ITSD)'),
(249, 'Director of HR'),
(250, 'Deputy Director of Finance'),
(251, 'College Finance Officer'),
(252, 'Senior Accountant'),
(253, 'Accountant'),
(254, 'Assistant Accountant'),
(255, 'Director of Audit'),
(256, 'Deputy Director of Internal Audit'),
(257, 'Senior Internal Auditor'),
(258, 'Internal Auditor'),
(259, 'Assistant Internal Auditor'),
(260, 'Director of Works/Development'),
(261, 'Deputy Director of Works/Development'),
(262, 'Senior Estates Officer'),
(263, 'Senior Quantity Surveyor'),
(264, 'Senior Engineer'),
(265, 'Senior Architect'),
(266, 'Senior Assistant Estate Officer'),
(267, 'Quantity/Land Surveyor'),
(268, 'Works/Physical Development Manager'),
(269, 'Engineer'),
(270, 'Architect'),
(271, 'Assistant Engineer'),
(272, 'Assistant Estate Officer'),
(273, 'Assistant Quantity/Land Surveyor'),
(274, 'Assistant Architect'),
(275, 'Planner'),
(276, 'Curator'),
(277, 'Director of Procurement'),
(278, 'Senior Procurement Officer'),
(279, 'Procurement Officer'),
(280, 'Assistant Procurement Officer'),
(281, 'Director of ICT'),
(282, 'Deputy Director of ICT'),
(283, 'Senior Systems Analyst/Senior Systems Programmer'),
(284, 'Programmer/Web Master/IT System Administrator'),
(285, 'Assistant Analyst/Systems Programmer'),
(286, 'Director of Health Services'),
(287, 'Deputy Director of Medical Services'),
(288, 'Principal Medical Officer/Medical Consultant'),
(289, 'Senior Dental Surgeon'),
(290, 'Senior Medical Officer'),
(291, 'Medical Officer'),
(292, 'Senior Pharmacist'),
(293, 'Pharmacist'),
(294, 'Assistant Pharmacist'),
(295, 'Hospital Administrator'),
(296, 'Head, Security Service'),
(297, 'Deputy Head, Security Service'),
(298, 'Principal  Archivist'),
(299, 'Senior Archivist'),
(300, 'Archivist'),
(301, 'Director of Sports'),
(302, 'Deputy Director of Sports'),
(303, 'Senior Coach'),
(304, 'Coach'),
(305, 'Director of Counselling'),
(306, 'Senior Counselling'),
(307, 'Deputy Director of Counselling'),
(308, 'Counsellor'),
(309, 'Program Manager'),
(310, 'In-House Counsel'),
(311, 'Institutional Research Expect'),
(312, 'Marketing Manager'),
(313, 'Information Communication Manager'),
(314, 'Librarian'),
(315, 'Deputy Librarian'),
(316, 'Senior Assistant Librarian'),
(317, 'Assistant Librarian'),
(318, 'University Printer/Printing Press Manager'),
(319, 'Manager of Hotels'),
(320, 'Business Development Manager'),
(321, 'Public Relations Coordinator'),
(322, 'Research Development Officer'),
(323, 'Coordinator'),
(324, 'Head of Counselling/Chaplain'),
(325, 'Quality Assurance Officer'),
(326, 'Senior ICT Assistant');

-- --------------------------------------------------------

--
-- Table structure for table `uhas_staff_category`
--

CREATE TABLE `uhas_staff_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uhas_staff_category`
--

INSERT INTO `uhas_staff_category` (`id`, `name`) VALUES
(1, 'Senior Administrative Staff'),
(2, 'Academic Staff'),
(3, 'Non Academic Staff'),
(4, 'Junior Staff'),
(5, 'National Service Personnel (NSP)'),
(6, 'Professional Staff'),
(7, 'Technical Staff');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','uploader','viewer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vacation_of_post`
--

CREATE TABLE `vacation_of_post` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `DoB` date DEFAULT NULL,
  `hometown` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `staff_category` text DEFAULT NULL,
  `years_in_uhas` int(11) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `date_of_vacation` date NOT NULL,
  `reason_for_vacation` text DEFAULT NULL,
  `campus` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `files` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_rank`
--
ALTER TABLE `academic_rank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id_calendar`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conferences`
--
ALTER TABLE `conferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deceased`
--
ALTER TABLE `deceased`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `directories`
--
ALTER TABLE `directories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_status`
--
ALTER TABLE `employee_status`
  ADD PRIMARY KEY (`id_employee_status`);

--
-- Indexes for table `highest_qualification`
--
ALTER TABLE `highest_qualification`
  ADD PRIMARY KEY (`id_highest_qualification`);

--
-- Indexes for table `hr_member`
--
ALTER TABLE `hr_member`
  ADD PRIMARY KEY (`hr_id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave`
--
ALTER TABLE `leave`
  ADD PRIMARY KEY (`id_leave`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nss`
--
ALTER TABLE `nss`
  ADD PRIMARY KEY (`nss_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orientations`
--
ALTER TABLE `orientations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `part_time`
--
ALTER TABLE `part_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `personnel_file`
--
ALTER TABLE `personnel_file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `post_retirement_contract`
--
ALTER TABLE `post_retirement_contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resignation`
--
ALTER TABLE `resignation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retiree`
--
ALTER TABLE `retiree`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id_school`);

--
-- Indexes for table `seminars`
--
ALTER TABLE `seminars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uhas_designation`
--
ALTER TABLE `uhas_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uhas_staff_category`
--
ALTER TABLE `uhas_staff_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `vacation_of_post`
--
ALTER TABLE `vacation_of_post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_rank`
--
ALTER TABLE `academic_rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `conferences`
--
ALTER TABLE `conferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deceased`
--
ALTER TABLE `deceased`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `directories`
--
ALTER TABLE `directories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employee_status`
--
ALTER TABLE `employee_status`
  MODIFY `id_employee_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `highest_qualification`
--
ALTER TABLE `highest_qualification`
  MODIFY `id_highest_qualification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hr_member`
--
ALTER TABLE `hr_member`
  MODIFY `hr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `leave`
--
ALTER TABLE `leave`
  MODIFY `id_leave` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orientations`
--
ALTER TABLE `orientations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `part_time`
--
ALTER TABLE `part_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnel_file`
--
ALTER TABLE `personnel_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `post_retirement_contract`
--
ALTER TABLE `post_retirement_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resignation`
--
ALTER TABLE `resignation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retiree`
--
ALTER TABLE `retiree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id_school` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seminars`
--
ALTER TABLE `seminars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uhas_designation`
--
ALTER TABLE `uhas_designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;

--
-- AUTO_INCREMENT for table `uhas_staff_category`
--
ALTER TABLE `uhas_staff_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vacation_of_post`
--
ALTER TABLE `vacation_of_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `personnel_file`
--
ALTER TABLE `personnel_file`
  ADD CONSTRAINT `personnel_file_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD CONSTRAINT `system_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
