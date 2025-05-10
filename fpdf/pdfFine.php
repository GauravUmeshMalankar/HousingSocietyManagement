<?php
include('../db.php');
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Fine Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

if (isset($_GET['FID'])) {
    $fid = $_GET['FID'];

    $pdf = new PDF();
    $pdf->AddPage();

    // Add Logo
    $pdf->Image('1.png', 10, 10, 30);

    // Title beside logo
    $pdf->SetXY(50, 20);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');

    // Move below logo
    $pdf->SetY(45);

    // Report title with border and center alignment (like Monthly Meeting)
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, "Fine Report - ID: $fid", 1, 1, 'C');
    $pdf->Ln(10);

    // Table headers
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFillColor(200, 0, 0); // Red background
    $pdf->Cell(20, 10, 'Fine ID', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'Member ID', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Member Name', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Fine Amount', 1, 0, 'C', true);
    $pdf->Cell(70, 10, 'Details', 1, 1, 'C', true);

    // Fetch data from Fine table
    $query = "SELECT * FROM Fine WHERE FID = '$fid'";
    $result = mysqli_query($conn, $query);

    // Table body
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    if ($row = mysqli_fetch_assoc($result)) {
        $pdf->SetFillColor(240, 240, 240);
        $fill = true;

        $pdf->Cell(20, 10, $row['FID'], 1, 0, 'C', $fill);
        $pdf->Cell(20, 10, $row['MID'], 1, 0, 'C', $fill);
        $pdf->Cell(40, 10, $row['MName'], 1, 0, 'C', $fill);
        $pdf->Cell(40, 10, $row['FAmount'], 1, 0, 'C', $fill);
        $pdf->Cell(70, 10, $row['Details'], 1, 1, 'C', $fill);
    } else {
        $pdf->Cell(190, 10, 'No Fine found with this ID.', 1, 1, 'C');
    }

    // Output settings
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=Fine_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    $pdf->Output();
    exit;
}
?>
