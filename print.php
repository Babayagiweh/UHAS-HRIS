<?php
// Database connection
require_once 'db.connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current month and year
$current_month = date("F Y");

// Pop-up fields
$data_retrieved_by = isset($_POST['retrieved_by']) ? $_POST['retrieved_by'] : '';
$approved_by = isset($_POST['approved_by']) ? $_POST['approved_by'] : '';

// Content to print (passed via GET or POST from other pages)
$content = isset($_POST['content']) ? $_POST['content'] : 'No data provided.';

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #fff;
            font-family: 'Arial', sans-serif;
        }
        .print-frame {
            
            margin: 0 auto;
            border: 2px solid green;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .uhas-logo {
            display: block;
            margin: 0 auto 10px;
            max-width: 120px;
        }
        .header, .footer {
            text-align: center;
            color: green;
        }
        .header h1 {
            font-size: 24px;
            margin: 10px 0;
        }
        .content {
            margin: 20px 0;
            font-size: 16px;
        }
        .contacts {
            margin-top: 20px;
        }
        .contacts p {
            margin: 0;
        }
        .footer {
            border-top: 1px solid green;
            padding-top: 10px;
            font-size: 14px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="print-frame">
    <!-- Header -->
    <div class="header">
        <img src="uhas_logo.png" alt="UHAS Logo" class="uhas-logo">
         <h2> UNIVERSITY OF HEALTH AND ALLIED SCIENCES, HO</h2>
        <h1> DIRECTORATE OF HUMAN RESOURCE</h1>
        <p>Data Printed for: <?= $current_month; ?></p>
    </div>

    <!-- Content -->
    <div class="content">
        <?= $content; ?>
    </div>

    <!-- Contacts -->
    <div class="contacts text-center">
        <p><strong>University of Health and Allied Sciences</strong></p>
        <p>PMB 31, Ho, Volta Region, Ghana</p>
        <p>Email: hr@uhas.edu.gh | Phone: +233-362-196-122</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© <?= date("Y"); ?> University of Health and Allied Sciences. All Rights Reserved.</p>
    </div>
</div>

<!-- Print and Input Dialog -->
<div class="no-print text-center mt-4">
    <button class="btn btn-success" onclick="showPrintDialog()">Print</button>
</div>

<script>
    function showPrintDialog() {
        // Prompt for input fields
        const retrievedBy = prompt("Data Retrieved By:");
        const approvedBy = prompt("Approved By:");
        
        if (retrievedBy && approvedBy) {
            // Display the retrieved/approved info dynamically
            const header = document.querySelector('.header');
            const approvalInfo = document.createElement('div');
            approvalInfo.style.textAlign = 'center';
            approvalInfo.style.marginTop = '20px';
            approvalInfo.innerHTML = `
                <p><strong>Data Retrieved By:</strong> ${retrievedBy}</p>
                <p><strong>Approved By:</strong> ${approvedBy}</p>
            `;
            header.appendChild(approvalInfo);

            // Trigger the print dialog
            window.print();
        } else {
            alert("Both 'Data Retrieved By' and 'Approved By' are required to print.");
        }
    }
</script>

</body>
</html>
