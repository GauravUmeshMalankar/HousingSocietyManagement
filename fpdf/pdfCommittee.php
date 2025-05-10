<?php
include('../db.php');
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Committee Master Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

if (isset($_GET['CID'])) {
    $cid = $_GET['CID'];

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->Image('1.png', 10, 10, 30); 
    $pdf->SetXY(50, 20); 
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');
    $pdf->SetY(45);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, "Committee Report for CID: $cid", 1, 1, 'C');
    $pdf->Ln(10);

    // Header style
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(255, 255, 255); // White text
    $pdf->SetFillColor(200, 0, 0);     // Red background
    $pdf->Cell(10, 10, 'CID', 1, 0, 'C', true);
    $pdf->Cell(10, 10, 'MID', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Name', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Contact', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Aadhar No', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Designation', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'A.Date', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'D.Date', 1, 1, 'C', true);

    $query = "SELECT * FROM CommitteeMaster WHERE CID = '$cid'";
    $result = mysqli_query($conn, $query);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0); // Black text

    if ($row = mysqli_fetch_assoc($result)) {
        // Light gray background
        $pdf->SetFillColor(240, 240, 240); 
        $fill = true;

        $pdf->Cell(10, 10, $row['CID'], 1, 0, 'C', $fill);
        $pdf->Cell(10, 10, $row['MID'], 1, 0, 'C', $fill);
        $pdf->Cell(40, 10, $row['MName'], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, $row['ContactNo'], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, $row['AadharNo'], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, $row['Designation'], 1, 0, 'C', $fill);
        $pdf->Cell(20, 10, date('d-m-Y', strtotime($row['ADate'])), 1, 0, 'C', $fill);
        $pdf->Cell(20, 10, date('d-m-Y', strtotime($row['DDate'])), 1, 1, 'C', $fill);
    } else {
        $pdf->Cell(0, 10, 'No records found for this Committee ID.', 1, 1, 'C');
    }

    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=Committee_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    $pdf->Output();
    exit;
}
?>
