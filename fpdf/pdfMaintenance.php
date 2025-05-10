<?php
include('../db.php');
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Maintenance Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

if (isset($_GET['BNO'])) {
    $bno = $_GET['BNO'];

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->Image('1.png', 10, 10, 30);
    $pdf->SetXY(50, 20);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');
    $pdf->SetY(45);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, "Maintenance Report for Bill No: $bno", 1, 1, 'C');
    $pdf->Ln(10);

    // Table Headers
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFillColor(200, 0, 0);// Red color for columns
    $pdf->Cell(13, 10, 'Bill No', 1, 0, 'C', true);
    $pdf->Cell(23, 10, 'Bill Date', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'Member ID', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Member Name', 1, 0, 'C', true);
    $pdf->Cell(23, 10, 'Start Date', 1, 0, 'C', true);
    $pdf->Cell(23, 10, 'End Date', 1, 0, 'C', true);
    $pdf->Cell(20, 10, 'Amount', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Bill Details', 1, 1, 'C', true);

    $query = "SELECT * FROM Maintenance WHERE BNo = '$bno'";
    $result = mysqli_query($conn, $query);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);

    if ($row = mysqli_fetch_assoc($result)) {
        // Light gray background
        $pdf->SetFillColor(240, 240, 240); 
        $fill = true;
        

        $pdf->Cell(13, 10, $row['BNo'], 1, 0, 'C', $fill);
        $pdf->Cell(23, 10, date('d-m-Y', strtotime($row['BDate'])), 1, 0, 'C', $fill);
        $pdf->Cell(20, 10, $row['MID'], 1, 0, 'C', $fill);
        $pdf->Cell(40, 10, $row['MName'], 1, 0, 'C', $fill);
        $pdf->Cell(23, 10, date('d-m-Y', strtotime($row['SDate'])), 1, 0, 'C', $fill);
        $pdf->Cell(23, 10, date('d-m-Y', strtotime($row['EDate'])), 1, 0, 'C', $fill);
        $pdf->Cell(20, 10, $row['Amount'], 1, 0, 'C', $fill);
        $pdf->Cell(25, 10, substr($row['BDetails'], 0, 20), 1, 1, 'C', $fill);
    } else {
        $pdf->Cell(0, 10, 'No records found for this Bill No.', 1, 1, 'C');
    }

    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=Maintenance_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    $pdf->Output();
    exit;
}
?>
