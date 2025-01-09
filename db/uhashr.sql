-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2024 at 09:41 PM
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
(1, 'uhashr', '7bcc2f69919a98797e4dbfbeac0b4ec5', 'Hr', 'uhas', 'hr@uhas.edu.gh', '2024-12-13 12:29:09'),
(4, 'Gabby', 'ecfed160b579578bad2ca8bd1c1c9070', 'Gabriel', 'Akikor', 'gakikor@uhas.edu.gh', '2024-12-17 14:49:03');

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

-- --------------------------------------------------------

--
-- Table structure for table `directories`
--

CREATE TABLE `directories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_status`
--

CREATE TABLE `employee_status` (
  `id_employee_status` int(11) NOT NULL,
  `employee_status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 'uhashr', 'Hr', 'uhas', 'hr@uhas.edu.gh', '2024-12-17 15:40:56', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0');

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
  `duty_status` varchar(20) NOT NULL,
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
(186, 'UHAS-00458', '7031', 'GHA-328743953-4', 'AT POST', 'Active', '0000-00-00', '0000-00-00', 'Alhassan', 'Robert', 'Kaba', 'Dr.', 'Alhassan Robert Kaba Dr.', 'Director of Human Resource', 'AT POST', '2024-12-16', 'Associate Professor', '2004-12-16', 'Single', 'Male', 'Ga Mashi', 'MSc HRM', 'PhD in HRM', 'Masters', 'HRM', '2024-11-01', '2024-11-01', '2024-11-01', 'HOD', '2024-11-01', '2025-11-01', 'Senior Administrative staff', 'PROCUREMENT', 'Allocation', 'GTEC', 'Hohoe', '0000-00-00', 20, '+233 598-121-33', 'yie@gmail.com', 'yie@gmail.com', '1999-12-16', 'img.67'),
(187, 'UHAS-00911', '1303', 'GHA-948539559-7', 'AT POST', 'Active', '0000-00-00', '0000-00-00', 'Mottey', 'Elsie', 'Ewoenam', 'Ms.', 'Mottey Elsie Ewoenam Ms.', 'Assistant Registrar', 'AT POST', '2024-12-16', 'Professor (Post-Retirement Contract)', '1994-12-16', 'Married', 'Female', 'Tema', 'MTech', 'PhD in HRM', 'Phd', 'medicine', '2024-11-01', '2024-11-01', '2024-11-01', 'Director', '2024-11-01', '2026-11-01', 'Junior  Staff', 'Directorate of ICT', 'administrative computing', '', 'Main campus phase 1', '0000-00-00', 10, '+233 598-121-34', 'com@gmail.com', 'jimmy@gmail. com', '1999-12-17', 'img.68'),
(188, 'UHAS-00765', '9103', 'GHA-572348249-8', 'LEAVE OF ABSENCE', 'inactive', '2024-11-01', '2025-11-01', 'Mottey', 'Elorm', 'Barbara', 'Ms.', 'Mottey Elorm Barbara  Ms.', 'Senior Assistant Registrar', 'LEAVE OF ABSENCE', '2024-12-16', 'Professor (Post-Retirement Contract)', NULL, 'Single', 'Female', 'Nakpaduri', 'HND', 'MBA in HRM', 'Diploma', 'Medicine', '2024-11-01', '2024-11-01', '2024-11-01', 'Heads of Unit', '2024-11-01', '2027-11-01', 'Junior staff', 'Directorate of Human Resource', 'Benefits and Compensations', '', 'Main campus phase 2', '0000-00-00', 15, '+233 598-121-34', 'junior@gmail.com', 'candy@gmail.com', '1999-01-17', 'ipj.1'),
(189, 'UHAS-00314', '3011', 'GHA-486299237-1', 'STUDY LEAVE WITH PAY', 'Inactive', '2024-11-01', '2025-11-01', 'Senaya', 'Stephen', 'Kwame', 'Mr.', 'Senaya Stephen Kwame Mr.', 'Principal Administrative Assistant', 'STUDY LEAVE WITH PAY', '2024-12-16', 'Professor (Post-Retirement Contract)', '1994-01-10', 'Divorced', 'Male', 'North', 'Mphil ICT', 'PhD in HRM', 'Degree', 'ICT', '2024-11-01', '2024-11-01', '2024-11-01', 'Dean', '2024-11-01', '2028-11-01', 'Academic staff', 'Directorate of Finance', 'Payroll unit', '', 'Tralfagar', '0000-00-00', 4, '+233 598-121-34', 'kam@gmail.com', 'jamma@gmail.com', '1999-01-10', 'jpg'),
(190, 'UHAS-00976', '4311', 'GHA-782982810-9', 'STUDY LEAVE WITHOUT ', 'Inactive', '2024-11-01', '2025-11-01', 'Mohammed', 'Issaka', 'Aziz', 'Mr.', 'Mohammed Issaka Mr.', 'Former Director of Human Resource', 'STUDY LEAVE WITHOUT PAY', '2024-12-16', 'Professor (Post-Retirement Contract)', '1994-01-10', 'Married', 'Male', 'Osu', 'Degree', 'PhD in HRM', 'PhD', 'Cyber Crime', '2024-11-01', '2024-11-01', '2024-11-01', 'Coordinator', '2024-11-01', '2027-11-01', 'Professional Staff', 'Directorate of Works and Physical Development ', 'estates', '', 'Tralfagar', '0000-00-00', 8, '+233 598-121-34', 'kamkam@gmail.com', 'azaro@gmail.com', '1999-01-10', 'ng.01');

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

-- --------------------------------------------------------

--
-- Table structure for table `uhas_staff_category`
--

CREATE TABLE `uhas_staff_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `directories`
--
ALTER TABLE `directories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_status`
--
ALTER TABLE `employee_status`
  MODIFY `id_employee_status` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `highest_qualification`
--
ALTER TABLE `highest_qualification`
  MODIFY `id_highest_qualification` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_member`
--
ALTER TABLE `hr_member`
  MODIFY `hr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave`
--
ALTER TABLE `leave`
  MODIFY `id_leave` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uhas_staff_category`
--
ALTER TABLE `uhas_staff_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
