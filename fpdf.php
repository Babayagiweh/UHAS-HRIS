<?php



require('fpdf/fpdf.php');

class PDF extends FPDF {
    // Header
    function Header() {
        // Add UHAS logo
        $this->Image('uhas_logo.png', 10, 6, 30); // Replace with the path to your UHAS logo
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(0, 128, 0); // Green color
        $this->Cell(0, 15, 'Newly Recruited Staff - Last 5 Months', 0, 1, 'C', true);
        $this->Ln(10);
    }

    // Footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Table Header
    function TableHeader() {
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(0, 128, 0); // Green background
        $this->SetTextColor(255, 255, 255); // White text
        $this->Cell(10, 10, 'S/No', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Staff ID', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Full Name', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Date Hired', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Designation', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Department', 1, 1, 'C', true);
    }

    // Table Rows
    function TableRows($data) {
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0); // Black text
        $fill = false; // Alternating row colors

        foreach ($data as $index => $row) {
            $this->SetFillColor(240, 240, 240); // Light grey for alternate rows
            $this->Cell(10, 10, $index + 1, 1, 0, 'C', $fill);
            $this->Cell(30, 10, $row['staff_id'], 1, 0, 'C', $fill);
            $this->Cell(50, 10, $row['full_name'], 1, 0, 'L', $fill);
            $this->Cell(30, 10, $row['date_hired'], 1, 0, 'C', $fill);
            $this->Cell(40, 10, $row['designation'], 1, 0, 'C', $fill);
            $this->Cell(40, 10, $row['department'], 1, 1, 'C', $fill);
            $fill = !$fill; // Alternate row color
        }
    }
}

// Database connection
$conn = new mysqli("localhost", "root", "", "uhashr");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch newly recruited staff
$current_date = date('Y-m-d');
$date_5_months_ago = date('Y-m-d', strtotime('-5 months', strtotime($current_date)));
$sql = "SELECT * FROM staff WHERE date_hired >= '$date_5_months_ago'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $staff_data = [];
    while ($row = $result->fetch_assoc()) {
        $staff_data[] = $row;
    }

    // Generate PDF
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->TableHeader();
    $pdf->TableRows($staff_data);
    $pdf->Output('D', 'newly_recruited_staff.pdf'); // Forces download
} else {
    echo "No newly recruited staff found within the last 5 months.";
}

$conn->close();
?>
