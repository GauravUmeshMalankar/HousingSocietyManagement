<?php
include('../db.php');
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Election Details Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

if (isset($_GET['EID'])) {
    $eid = $_GET['EID'];

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->Image('1.png', 10, 10, 30); 
    $pdf->SetXY(50, 20); 
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');

    $pdf->SetY(45);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, "Election Details Report for EID: $eid", 1, 1, 'C');
    $pdf->Ln(10);

    // Table header
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFillColor(200, 0, 0);
    $pdf->Cell(12, 10, 'EID', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Date', 1, 0, 'C', true);
    $pdf->Cell(35, 10, 'Notice By Sec.', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Chairman', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Start Date', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'End Date', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Position', 1, 0, 'C', true);
    $pdf->Cell(18, 10, 'Members', 1, 1, 'C', true);

    $query = "SELECT * FROM ElectionDetails WHERE EID = '$eid'";
    $result = mysqli_query($conn, $query);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0, 0, 0);


    if ($row = mysqli_fetch_assoc($result)) {
        // Light gray background
        $pdf->SetFillColor(240, 240, 240); 
        $fill = true;

        $pdf->Cell(12, 10, $row['EID'], 1, 0, 'C', $fill);
        $pdf->Cell(25, 10, date('d-m-Y', strtotime($row['EDate'])), 1, 0, 'C', $fill);
        $pdf->Cell(35, 10, $row['NSecreatary'], 1, 0, 'C', $fill);
        $pdf->Cell(25, 10, $row['Chairman'], 1, 0, 'C', $fill);
        $pdf->Cell(25, 10, date('d-m-Y', strtotime($row['PStartDate'])), 1, 0, 'C', $fill);
        $pdf->Cell(25, 10, date('d-m-Y', strtotime($row['PEndDate'])), 1, 0, 'C', $fill);
        $pdf->Cell(25, 10, $row['EPosition'], 1, 0, 'C', $fill);
        $pdf->Cell(18, 10, $row['CMembers'], 1, 1, 'C', $fill);
    } else {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(100, 0, 0);
        $pdf->Cell(0, 10, 'No records found for this Election ID.', 1, 1, 'C');
    }

    // Output PDF to browser
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=Election_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    $pdf->Output();
    exit;
}
?>
