<?php
// Include the necessary database connection and fetch orientations for the calendar.
include('config.php');

// Initialize variables to handle form data
$search_date_from = isset($_POST['date_from']) ? $_POST['date_from'] : '';
$search_date_to = isset($_POST['date_to']) ? $_POST['date_to'] : '';
$search_directorate = isset($_POST['department']) ? $_POST['department'] : '';

// Query to fetch orientations based on form input
$query = "SELECT * FROM orientations WHERE 1";

// Add filters to the query based on form input
if ($search_date_from) {
    $query .= " AND date >= :orientation_date";
}
if ($search_date_to) {
    $query .= " AND date <= :date_to";
}
if ($search_directorate) {
    $query .= " AND department = :department";
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
    $stmt->bindParam(':department', $search_directorate);
}
$stmt->execute();
$orientations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orientation Calendar | UHAS</title>
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
            background-color: green;
            color: white;
        }

        .footer {
            background-color: green;
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
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: green;">
        <a class="navbar-brand" href="home.php">UHAS-HR</a>
    </nav>

    <div class="container">
        <!-- Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="text-center">Filter Orientations</h3>
                <form action="orientations.php" method="POST" class="bg-light p-4 rounded">
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
                                <option value="Directorate of Student Affairs" <?php echo ($search_directorate == 'Directorate of Student Affairs') ? 'selected' : ''; ?>>Directorate of Student Affairs</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-custom">Filter Orientations</button>
                        <a href="add_orientation.php" class="btn btn-custom">Add New Orientation</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="row">
            <div class="col-lg-8 calendar-container">
                <h3 class="text-center mb-4">Orientation Calendar</h3>
                <div id="calendar"></div>
            </div>

            <!-- Orientation List Section -->
            <div class="col-lg-4">
                <h3 class="text-center">Upcoming Orientations</h3>
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-calendar"></i> Orientation List
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/No</th>
                                    <th>Title</th>
                                    <th>Date & Time</th>
                                    <th>Venue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($orientations as $orientation) {
                                    echo "<tr data-bs-toggle='modal' data-bs-target='#orientationModal' data-title='{$orientation['orientation_title']}' data-date='{$orientation['orientation_date']} {$orientation['orientation_time']}' data-venue='{$orientation['venue']}' data-directorate='{$orientation['department']}'>";
                                    echo "<td>{$i}</td>";
                                    echo "<td>{$orientation['orientation_title']}</td>";
                                    echo "<td>{$orientation['orientation_date']} {$orientation['orientation_time']}</td>";
                                    echo "<td>{$orientation['venue']}</td>";
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

        <!-- Modal for Orientation Details -->
        <div class="modal fade" id="orientationModal" tabindex="-1" aria-labelledby="orientationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orientationModalLabel">Orientation Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Title:</strong> <span id="modal-title"></span></p>
                        <p><strong>Date & Time:</strong> <span id="modal-date"></span></p>
                        <p><strong>Venue:</strong> <span id="modal-venue"></span></p>
                        <p><strong>Directorate:</strong> <span id="modal-directorate"></span></p>
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
                    <?php foreach ($orientations as $orientation): ?>
                    {
                        title: '<?php echo $orientation['orientation_title']; ?>',
                        start: '<?php echo $orientation['orientation_date'] . " " . $orientation['orientation_time']; ?>',
                        description: '<?php echo addslashes($orientation['description']); ?>',
                        location: '<?php echo addslashes($orientation['venue']); ?>',
                    },
                    <?php endforeach; ?>
                ],
                eventClick: function(calEvent, jsEvent, view) {
                    $('#orientationModal').modal('show');
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
