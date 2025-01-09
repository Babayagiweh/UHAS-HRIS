<?php
if (isset($_GET['export_excel'])) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="post_retirement_contract.xlsx"');
    // Code to generate Excel from `post_retirement_contract`
}

if (isset($_GET['export_pdf'])) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="post_retirement_contract.pdf"');
    // Code to generate PDF from `post_retirement_contract`
}
?>
