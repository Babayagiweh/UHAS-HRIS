<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Menu</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 20px;
            margin-top: 60px; /* Space for fixed header (if any) */
            background-color: #f4f7fa;
            border-radius: 8px;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: green;
            text-align: center;
        }
        p1 {
            font-size: 1.2rem;
            color: white;
            text-align: center;
        }

        .report-list-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .report-item {
            flex: 1 1 calc(33.333% - 16px); /* 3 items per row */
            max-width: 300px;
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .report-item:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .report-item a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            display: block;
        }

        .footer {
            background-color: green;
            text-color: white;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 992px) {
            .report-item {
                flex: 1 1 calc(50% - 16px); /* 2 items per row on medium screens */
            }
        }

        @media (max-width: 576px) {
            .report-item {
                flex: 1 1 100%; /* 1 item per row on small screens */
            }

            h1 {
                font-size: 1.5rem;
            }

            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="content">
    <h1>Reports Page</h1>
    <p>Select a report from the list to view its details.</p>
    <a href="home.php" class="btn btn-success mb-3">Back to Home</a>
    <div class="report-list-container">
        <!-- Dynamic list items -->
        <div class="report-item"><a href="staff_details.php">1. Individual Reports</a></div>
        <div class="report-item"><a href="retirement_report.php">2. Retirement</a></div>
        <div class="report-item"><a href="senior_lecturer_report.php">3. Profile by Senior Lecturers</a></div>
        <div class="report-item"><a href="male_senior_lecturer_report.php">4. Male Senior Lecturers</a></div>
        <div class="report-item"><a href="female_senior_lecturer_report.php">5. Profile list by Female Senior Lecturers</a></div>
        <div class="report-item"><a href="lecturer_report.php">6. Profile list by Lecturers</a></div>
        <div class="report-item"><a href="male_lecturer_report.php">7. Profile list by Male Lecturers</a></div>
        <div class="report-item"><a href="female_lecturer_report.php">8. Profile list by Female Lecturers</a></div>
        <div class="report-item"><a href="assistant_lecturer_report.php">9. Profile list by Assistant Lecturers</a></div>
        <div class="report-item"><a href="male_assistant_lecturer_report.php">10. Profile list by Male Assistant Lecturers</a></div>
        <div class="report-item"><a href="female_assistant_lecturer_report.php">11. Profile list by Female Assistant Lecturers</a></div>
        <div class="report-item"><a href="research_assistant_report.php">12. Profile list by Research Assistants</a></div>
        <div class="report-item"><a href="male_research_assistant_report.php">13. Profile list by Male Research Assistants</a></div>
        <div class="report-item"><a href="female_research_assistant_report.php">14. Profile list by Female Research Assistants</a></div>
        <div class="report-item"><a href="faculties.php">15. Educational Qualifications</a></div>
        <div class="report-item"><a href="campuses.php">16. Numbers in the Campus</a></div>
        <div class="report-item"><a href="male_report.php">17. Profile by Male</a></div>
        <div class="report-item"><a href="female_report.php">18. Profile by Female</a></div>
        <div class="report-item"><a href="Faculty_profile_by_degree.php">19. Faculty Profile by Degree</a></div>
        <div class="report-item"><a href="faculties.php">20. Faculty Profile by Academic Rank</a></div>
        <div class="report-item"><a href="breakdown_of_faculty_profile.php">21. Breakdown Of Faculty</a></div>
        <div class="report-item"><a href="Senior_Administrative_staff_report.php">22. UHAS Senior Administrative Staff</a></div>
        <div class="report-item"><a href="junior_staff_report.php">23. UHAS Junior Staff</a></div>
        <div class="report-item"><a href="nss_report.php">24. UHAS National Service Staff</a></div>
        <div class="report-item"><a href="permanent_staff_report.php">25. Number of UHAS Permanent Staff</a></div>
        <div class="report-item"><a href="Part-time_report.php">26. Number of Part-time Staff</a></div>
        <div class="report-item"><a href="Contract_staff_report.php">27. Number of Contract Staff</a></div>
        <div class="report-item"><a href="phd_report.php">28. UHAS PhD's</a></div>
        <div class="report-item"><a href="male_phd_report.php">29. UHAS Male PhD's</a></div>
        <div class="report-item"><a href="female_phd_report.php">30. UHAS Female PhD's</a></div>
        <div class="report-item"><a href="prof_report.php">31. UHAS Professors</a></div>
        <div class="report-item"><a href="male_prof_report.php">32. UHAS Male Professors</a></div>
        <div class="report-item"><a href="female_prof_report.php">33. UHAS Female Professors</a></div>
        <div class="report-item"><a href="associate_prof_report.php">34. UHAS Associate Professors</a></div>
        <div class="report-item"><a href="male_associate_prof_report.php">35. UHAS Male Associate Professors</a></div>
        <div class="report-item"><a href="female_associate_prof_report.php">36. UHAS Female Associate Professors</a></div>
        <div class="report-item"><a href="Post-Retirement_Contract_report.php">37. UHAS Personnel Post-Retirement Contract</a></div>
        <div class="report-item"><a href="directors_report.php">38. UHAS Directors</a></div>
        <div class="report-item"><a href="deans_report.php">39. UHAS Deans</a></div>
        <div class="report-item"><a href="hods_report.php">40. UHAS HoD's</a></div>
        <div class="report-item"><a href="hu_report.php">41. UHAS Head of Units</a></div>
        <div class="report-item"><a href="hall_tutors_report.php">42. UHAS Hall Tutors</a></div>
        <div class="report-item"><a href="director_of_center_report.php">43. UHAS Directors of Center</a></div>
        <div class="report-item"><a href="exam_registration_report.php">44. UHAS Examination/Registration Officers</a></div>
        <div class="report-item"><a href="coordinators_report.php">45. UHAS Coordinators</a></div>
        <div class="report-item"><a href="below_30_report.php">46. UHAS Faculty Age Below 30</a></div>
        <div class="report-item"><a href="30_to_40years_report.php">47. UHAS Faculty Age 30 to 40</a></div>
        <div class="report-item"><a href="30_to_60years_report.php">48. UHAS Faculty Age 30 to 60</a></div>
        <div class="report-item"><a href="60years_above_report.php">49. UHAS Faculty Age 60+</a></div>
        <div class="report-item"><a href="end_of_contract_report.php">50. UHAS End of Contract list</a></div>
           
        <!-- Add remaining items dynamically as above -->
    </div>
</div>

<div class="footer">
    <p1>&copy; 2024 UHAS - University of Health and Allied Sciences | All Rights Reserved</p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
