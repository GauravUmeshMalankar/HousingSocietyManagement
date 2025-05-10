<?php
require_once('fpdf186/fpdf.php');

class FinePDF extends FPDF
{
    // Footer method
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Fine Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Function to generate Fine PDF report
function generateFinePDF($conn)
{
    $pdf = new FinePDF();
    $pdf->AddPage();

    // Add Logo (Adjust path accordingly)
    $pdf->Image('1.png', 10, 10, 30);

    // Title beside logo
    $pdf->SetXY(50, 20);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');

    // Move below logo
    $pdf->SetY(45);

    // Report title
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Fine Report', 1, 1, 'C');
    $pdf->Ln(10);

    // Table headers
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 10, 'Fine ID', 1);
    $pdf->Cell(20, 10, 'Member ID', 1);
    $pdf->Cell(40, 10, 'Member Name', 1);
    $pdf->Cell(40, 10, 'Fine Amount', 1);
    $pdf->Cell(70, 10, 'Details', 1);
    $pdf->Ln();

    // Fetch data from Fine table
    $query = "SELECT * FROM Fine";
    $result = mysqli_query($conn, $query);

    $pdf->SetFont('Arial', '', 10);

    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(20, 10, $row['FID'], 1);
        $pdf->Cell(20, 10, $row['MID'], 1);
        $pdf->Cell(40, 10, $row['MName'], 1);
        $pdf->Cell(40, 10, $row['FAmount'], 1);
        $pdf->Cell(70, 10, $row['Details'], 1);
        $pdf->Ln();
    }

    /* Send headers to display PDF in browser
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=Fine_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    */

    
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=Fine_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");


    // Output the PDF
    $pdf->Output();
    exit;
}


?>
