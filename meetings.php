<?php
// Include the necessary database connection and fetch meetings for the calendar.
include('config.php');

// Initialize variables to handle form data
$search_date_from = isset($_POST['date_from']) ? $_POST['date_from'] : '';
$search_date_to = isset($_POST['date_to']) ? $_POST['date_to'] : '';
$search_directorate = isset($_POST['directorate']) ? $_POST['directorate'] : '';

// Query to fetch meetings based on form input
$query = "SELECT * FROM meetings WHERE 1";

// Add filters to the query based on form input
if ($search_date_from) {
    $query .= " AND date >= :date_from";
}
if ($search_date_to) {
    $query .= " AND date <= :date_to";
}
if ($search_directorate) {
    $query .= " AND directorate = :directorate";
}

// Prepare and execute the query
$stmt = $pdo->prepare($query);
if ($search_date_from) {
    $stmt->bindParam(':date_from', $search_date_from);
}
if ($search_date_to) {
    $stmt->bindParam(':date_to', $search_date_to);
}
if ($search_directorate) {
    $stmt->bindParam(':directorate', $search_directorate);
}
$stmt->execute();
$meetings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Meeting Calendar | UHAS</title>
    <!-- Bootstrap 5 and Font Awesome for Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet"> <!-- AOS for animations -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.css" rel="stylesheet"> <!-- FullCalendar -->
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            background-image: url('bg.jp');
        }

        .container {
            margin-top: 20px;
        }

        .card-header {
            background-color: #28a745;
            color: white;
        }

        .footer {
            background-color: #28a745;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .btn-custom {
            background-color: #ffc107;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #e0a800;
        }

        /* FullCalendar */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Modal */
        .modal-title {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #28a745;">
        <a class="navbar-brand" href="home.php">UHAS</a>
    </nav>

    <div class="container">
        <!-- Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="text-center">Filter Meetings</h3>
                <form action="meetings.php" method="POST" class="bg-light p-4 rounded">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="date_from" class="form-label">Date From:</label>
                            <input type="date" class="form-control" name="date_from" id="date_from" value="<?php echo $search_date_from; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="date_to" class="form-label">Date To:</label>
                            <input type="date" class="form-control" name="date_to" id="date_to" value="<?php echo $search_date_to; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="directorate" class="form-label">Directorate:</label>
                            <select class="form-control" name="directorate" id="directorate">
                                <option value="">Select Directorate</option>
                                <option value="Directorate of ICT" <?php echo ($search_directorate == 'Directorate of ICT') ? 'selected' : ''; ?>>Directorate of ICT</option>
                                <option value="Directorate of Academic Affairs" <?php echo ($search_directorate == 'Directorate of Academic Affairs') ? 'selected' : ''; ?>>Directorate of Academic Affairs</option>
                                <option value="Directorate of Finance" <?php echo ($search_directorate == 'Directorate of Finance') ? 'selected' : ''; ?>>Directorate of Finance</option>
                                 <option value="Directorate of PROCUREMENT" <?php echo ($search_directorate == 'Directorate of PROCUREMENT') ? 'selected' : ''; ?>>Directorate of Procurement</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-custom">Filter Meetings</button>
                        <a href="add_meeting.php" class="btn btn-custom">Add New Meeting</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="row">
            <div class="col-lg-8 calendar-container">
                <h3 class="text-center mb-4">Calendar of Meetings</h3>
                <div id="calendar"></div>
            </div>

            <!-- Meeting List Section -->
            <div class="col-lg-4">
                <h3 class="text-center">Upcoming Meetings</h3>
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-calendar"></i> Meeting List
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/No</th>
                                    <th>Title</th>
                                    <th>Date & Time</th>
                                    <th>Venue</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($meetings as $meeting) {
                                    echo "<tr data-bs-toggle='modal' data-bs-target='#meetingModal' data-title='{$meeting['meeting_title']}' data-date='{$meeting['meeting_date']} {$meeting['meeting_time']}' data-venue='{$meeting['venue']}' data-directorate='{$meeting['department']}' {$meeting['remarks']}'>";
                                    echo "<td>{$i}</td>";
                                    echo "<td>{$meeting['meeting_title']}</td>";
                                    echo "<td>{$meeting['meeting_date']} {$meeting['meeting_time']}</td>";
                                    echo "<td>{$meeting['venue']}</td>";
                                     echo "<td>{$meeting['remarks']}</td>";
                                    echo "</tr>";
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Meeting Details -->
        <div class="modal fade" id="meetingModal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="meetingModalLabel">Meeting Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Title:</strong> <span id="modal-title"></span></p>
                        <p><strong>Date & Time:</strong> <span id="modal-date"></span></p>
                        <p><strong>Venue:</strong> <span id="modal-venue"></span></p>
                        <p><strong>Directorate:</strong> <span id="model-directorate"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 UHAS - University of Health and Allied Sciences. All Rights Reserved.</p>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                events: [
                    <?php foreach ($meetings as $meeting): ?>
                    {
                        title: '<?php echo $meeting['meeting_title']; ?>',
                        start: '<?php echo $meeting['meeting_date'] . " " . $meeting['meeting_time']; ?>',
                        description: '<?php echo addslashes($meeting['remarks']); ?>',
                        location: '<?php echo addslashes($meeting['venue']); ?>',
                    },
                    <?php endforeach; ?>
                ],
                eventClick: function(calEvent, jsEvent, view) {
                    $('#meetingModal').modal('show');
                    $('#modal-title').text(calEvent.title);
                    $('#modal-date').text(calEvent.start.format('YYYY-MM-DD HH:mm'));
                    $('#modal-venue').text(calEvent.location);
                    $('#modal-directorate').text(calEvent.description);
                }
            });
        });
    </script>
</body>
</html>
