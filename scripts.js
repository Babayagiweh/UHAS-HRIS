$(document).ready(function() {
    // Back to home button
    $('#backButton').click(function() {
        window.location.href = 'departments.php';
    });

    // Print button
    $('#printButton').click(function() {
        window.print();
    });

    // Export to Excel
    $('#exportExcel').click(function() {
        var table = document.getElementById('staffTable');
        var wb = XLSX.utils.table_to_book(table, {sheet: "Staff Data"});
        XLSX.writeFile(wb, 'staff_data.xlsx');
    });

    // Export to PDF
    $('#exportPdf').click(function() {
        var doc = new jsPDF();
        doc.autoTable({ html: '#staffTable' });
        doc.save('staff_data.pdf');
    });

    // Search functionality
    $('#staffTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10
    });
});
