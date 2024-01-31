<?php
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        

        // Set font
        $this->SetFont('Arial', 'B', 12);

        // Move to the right
        $this->Cell(40);

        // School Name
        // $this->Cell(0, 10, 'Republic of the Philippines', 0, 1, 'C');

        // Class Name
        $this->Cell(100, 15, 'Monthly Product Inventory', 0, 1, 'C');

        // Line break
        $this->Ln(10);
    }

    function Footer() {
        // Add a footer if needed
    }
}

// Replace these values with your actual database credentials
$hostname = "your_database_host";
$username = "your_database_username";
$password = "your_database_password";
$database = "your_database_name";

 // Connect to the database
 include("connection.php");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Query to retrieve monthly data
$sql = "SELECT barcodeId, productName, productGroup, SUM(qty) AS qty
        FROM product
        WHERE MONTH(created_at) = $currentMonth AND YEAR(created_at) = $currentYear
        GROUP BY barcodeId, productName, productGroup";

$result = $conn->query($sql);

// Create PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);


// Check if there are results
if ($result->num_rows > 0) {
    // Output table header
    $pdf->SetFont('Arial', 'B',  12);
    $pdf->Cell(55, 10, 'Barcode ID', 1, 0, 'C'); // Center alignment
    $pdf->Cell(55, 10, 'Product Name', 1, 0, 'C'); // Center alignment
    $pdf->Cell(40, 10, 'Product Group', 1, 0, 'C'); // Center alignment
    $pdf->Cell(35, 10, 'Total Qty Sold', 1, 1, 'C'); // Center alignment
    // Use '1' as the last parameter to move to the next line

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(55, 10, $row["barcodeId"], 1, 0, 'C'); // Center alignment
        $pdf->Cell(55, 10, $row["productName"], 1, 0, 'C'); // Center alignment
        $pdf->Cell(40, 10, $row["productGroup"], 1, 0, 'C'); // Center alignment
        $pdf->Cell(35, 10, $row["qty"], 1, 1, 'C'); // Center alignment
        // Use '1' as the last parameter to move to the next line
    }
} else {
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, 'No results found', 0, 1, 'C');
}

// Output PDF
$pdf->Output();

// Close the database connection
$conn->close();
?>
