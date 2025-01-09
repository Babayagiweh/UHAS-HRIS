<?php
// Database connection
require_once 'db.connect.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current date and calculate the date for 5 months ago
$current_date = date('Y-m-d');
$date_5_months_ago = date('Y-m-d', strtotime('-5 months', strtotime($current_date)));

// Fetch data of newly recruited staff
$sql = "SELECT * FROM staff WHERE date_hired >= '$date_5_months_ago'";
$result = $conn->query($sql);

// Check if data exists
if ($result->num_rows == 0) {
    die("No data available to export.");
}

// Export to Excel
if (isset($_GET['export_excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=newly_recruited_staff.xls");

    echo "S/No\tStaff ID\tFull Name\tDate Hired\tDesignation\tDepartment\tEmail\tPhone\n";

    $sn = 1;
    while ($row = $result->fetch_assoc()) {
        echo $sn++ . "\t" . $row['staff_id'] . "\t" . $row['full_name'] . "\t" . $row['date_hired'] . "\t" . 
             $row['designation'] . "\t" . $row['department'] . "\t" . $row['email'] . "\t" . $row['phone'] . "\n";
    }
    exit();
}

// Export to PDF
if (isset($_GET['export_pdf'])) {
    require_once('fpdf/fpdf.php');

    class PDF extends FPDF {
        // Header
        function Header() {
            $this->SetFont('Arial', 'B', 12);
            $this->SetTextColor(255, 255, 255);
            $this->SetFillColor(0, 128, 0); // Green color
            $this->Cell(0, 10, 'Newly Recruited Staff - Last 5 Months', 0, 1, 'C', true);
            $this->Ln(5);
        }

        // Footer
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);

    // Table header
    $pdf->SetFillColor(0, 128, 0);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(10, 10, 'S/No', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Staff ID', 1, 0, 'C', true);
    $pdf->Cell(50, 10, 'Full Name', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Date Hired', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Designation', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Department', 1, 1, 'C', true);

    // Table data
    $pdf->SetTextColor(0, 0, 0);
    $sn = 1;
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $sn++, 1);
        $pdf->Cell(30, 10, $row['staff_id'], 1);
        $pdf->Cell(50, 10, $row['full_name'], 1);
        $pdf->Cell(30, 10, $row['date_hired'], 1);
        $pdf->Cell(40, 10, $row['designation'], 1);
        $pdf->Cell(40, 10, $row['department'], 1, 1);
    }

    $pdf->Output('D', 'newly_recruited_staff.pdf'); // Force download
    exit();
}

$conn->close();
?>
