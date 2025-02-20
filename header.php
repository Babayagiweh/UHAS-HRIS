<?php
// Database connection (update with your credentials)
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch counts based on duty_status
$query = "
    SELECT 
        duty_status, 
        COUNT(*) as count 
    FROM staff 
    WHERE duty_status IN ('AT POST', 'STUDY LEAVE WITH PAY', 'STUDY LEAVE WITHOUT PAY', 'LEAVE OF ABSENCE', 'FELLOWSHIP') 
    GROUP BY duty_status";
$result = $conn->query($query);

// Initialize counts
$dutyCounts = [
    'AT POST' => 0,
    'STUDY LEAVE WITH PAY' => 0,
    'STUDY LEAVE WITHOUT PAY' => 0,
    'LEAVE OF ABSENCE' => 0,
    'FELLOWSHIP' => 0,
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dutyCounts[$row['duty_status']] = $row['count'];
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #1E7F36;">
    <div class="container-fluid">
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <a class="navbar-brand text-white fw-bold" href="home.php">
            <img src="uhas_logo.png" alt="UHAS Logo" width="60" height="60" class="d-inline-block align-text-top me-2"> 
             <a style="font-weight: bold; color: white;">UHAS-HR INFORMATION SYSTEM DASHBOARD</a>
        </a>
       <!-- Right-Side Menu -->
            <ul class="navbar-nav ms-auto">

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left-Side Menu -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="staffStatusDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        STAFF STATUS
                    </a>
                    <ul class="dropdown-menu shadow border-0 rounded" style="background-color: #FCD116;">
                        <li><a class="dropdown-item fw-bold" href="at_post_staff.php">AT POST (AP): <?php echo $dutyCounts['AT POST']; ?></a></li>
                        <li><a class="dropdown-item fw-bold" href="study_leave_with_pay.php">STUDY LEAVE WITH PAY (SL(P)): <?php echo $dutyCounts['STUDY LEAVE WITH PAY']; ?></a></li>
                        <li><a class="dropdown-item fw-bold" href="study_leave_without_pay.php">STUDY LEAVE WITHOUT PAY (SL-P): <?php echo $dutyCounts['STUDY LEAVE WITHOUT PAY']; ?></a></li>
                        <li><a class="dropdown-item fw-bold" href="leave_of_absence.php">LEAVE OF ABSENCE: <?php echo $dutyCounts['LEAVE OF ABSENCE']; ?></a></li>
                        <li><a class="dropdown-item fw-bold" href="fellowship.php">FELLOWSHIP: <?php echo $dutyCounts['FELLOWSHIP']; ?></a></li>
                        <li><a class="dropdown-item fw-bold" href="leave_mgt.php">LEAVE RECORDS</a></li>
                        <li><a class="dropdown-item fw-bold" href="seperation_mgt.php">SEPERATION MGT</a></li>
                        <li><a class="dropdown-item fw-bold" href="contracts.php">POST-RETIREMENTS CONTRACTS MGT</a></li>
                         <li><a class="dropdown-item fw-bold" href="others_mgt.php">OTHER STAFF</a></li>
                        <!--<li><a class="dropdown-item fw-bold" href="resignation_mgt.php">RESIGNATION RECORDS</a></li> -->
                    </ul>
                </li>
            </ul>

            
                <!-- Original Menu Items -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        MENU
                    </a>
                    <ul class="dropdown-menu shadow border-0 rounded" style="background-color: #FCD116;">
                        <li><a class="dropdown-item fw-bold" href="campuses.php">Campuses</a></li>
                        <li><a class="dropdown-item fw-bold" href="all_staff.php">All Personnel</a></li>
                        <li><a class="dropdown-item fw-bold" href="add_staff.php">Add Personnel</a></li>
                        <li><a class="dropdown-item fw-bold" href="add_bulk_staff.php">Add Bulk Staff Personnel</a></li>
                        <li><a class="dropdown-item fw-bold" href="upload_files.php">Add Personnel Files</a></li>
                        <li><a class="dropdown-item fw-bold" href="leave_mgt.php">Leave Mangement</a></li>
                        <li><a class="dropdown-item fw-bold" href="institutes.php">Institutes</a></li>
                        <li><a class="dropdown-item fw-bold" href="schools.php">Schools</a></li>
                        <li><a class="dropdown-item fw-bold" href="directories.php">Directories</a></li>
                        <!--<li><a class="dropdown-item fw-bold" href="departments_units_mgt.php">Departments | Units</a></li> -->
                        <!--<li><a class="dropdown-item fw-bold" href="departments.php">Departments</a></li>-->
                        <li><a class="dropdown-item fw-bold" href="faculties.php">Faculties By Qualifications</a></li>
                        
                        <li><a class="dropdown-item fw-bold" href="reports.php">Reports</a></li>
                         <li><a class="dropdown-item fw-bold" href="staff_details.php">Individual Staff Details</a></li>
                          <li><a class="dropdown-item fw-bold" href="staff_details.php">Update Individual Staff Details</a></li>

                    </ul>
                </li>
                <!-- Events Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="eventsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        EVENTS
                    </a>
                    <ul class="dropdown-menu shadow border-0 rounded" style="background-color: #FCD116;">
                        <li><a class="dropdown-item fw-bold" href="counts.php">COUNTS</a></li>
                        <li><a class="dropdown-item fw-bold" href="training.php">Training Sessions</a></li>
                        <li><a class="dropdown-item fw-bold" href="conferences.php">Conference</a></li>
                        <li><a class="dropdown-item fw-bold" href="meetings.php">Meetings</a></li>
                        <li><a class="dropdown-item fw-bold" href="serminars.php">Seminars</a></li>
                        <li><a class="dropdown-item fw-bold" href="orientations.php">Orientations</a></li>
                        <li><a class="dropdown-item fw-bold" href="system_logs.php">System Logs</a></li>
                    </ul>
                </li>
                <!-- Other Nav Items -->
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="upload_files.php">FOLDER</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="counts.php">COUNTS</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="calendar_activities.php">CALENDAR ACTIVITIES</a></li>
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="hr_team.php">HR TEAM</a></li>
               <!-- <li class="nav-item"><a class="nav-link text-white fw-bold" href="system_logs.php">System Logs</a></li>-->
                <li class="nav-item"><a class="nav-link text-white fw-bold" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
