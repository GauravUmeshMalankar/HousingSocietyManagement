<?php
include('../db.php');
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Monthly Meeting Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

if (isset($_GET['MeetID'])) {
    $meetId = $_GET['MeetID'];


    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->Image('1.png', 10, 10, 30);
    $pdf->SetXY(50, 20);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');

    $pdf->SetY(45);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, "Monthly Meeting Report - ID: $meetId", 1, 1, 'C');
    $pdf->Ln(10);

    // Table header
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFillColor(200, 0, 0);// Red color for columns
    $pdf->Cell(20, 10, 'MeetID', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Meeting Date', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Notice Date', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Notice By', 1, 0, 'C', true);
    $pdf->Cell(70, 10, 'Meeting Reason', 1, 1, 'C', true);

    $query = "SELECT * FROM MonthlyMeeting WHERE MeetID = '$meetId'";
    $result = mysqli_query($conn, $query);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    if ($row = mysqli_fetch_assoc($result)) {
        // Light gray background
        $pdf->SetFillColor(240, 240, 240); 
        $fill = true;
    
        $pdf->Cell(20, 10, $row['MeetID'], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['MDate'])), 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['NDate'])), 1, 0, 'C', $fill);
        $pdf->Cell(40, 10, $row['NoticeIssuedBy'], 1, 0, 'C', $fill);
        $pdf->Cell(70, 10, $row['Designation'], 1, 1, 'C', $fill);
    } else {
        $pdf->Cell(190, 10, 'No meeting found with this ID.', 1, 1, 'C');
    }
    

    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=MonthlyMeeting_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    $pdf->Output();
    exit;
}
?>
