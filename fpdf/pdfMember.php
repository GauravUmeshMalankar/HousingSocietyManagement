<?php 
include('../db.php');
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Footer method
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Member Master Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

if (isset($_GET['MID'])) {
    $mid  = $_GET['MID'];

    $pdf = new PDF();
    $pdf->SetLeftMargin(10);
    $pdf->SetRightMargin(10);
    $pdf->AddPage();

    // Add Logo
    $pdf->Image('1.png', 10, 10, 30);
    $pdf->SetXY(50, 20);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');
    $pdf->SetY(45);

    // Report Title
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(195, 10, "Member Master Report - ID: $mid", 1, 1, 'C');
    $pdf->Ln(10);

    // Table Header
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFillColor(200, 0, 0);// Red color for columns
    $pdf->Cell(12, 10, 'MID', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Name', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Aadhar No', 1, 0, 'C', true);
    $pdf->Cell(15, 10, 'Flat', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Contact', 1, 0, 'C', true);
    $pdf->Cell(45, 10, 'Email', 1, 0, 'C', true);
    $pdf->Cell(15, 10, 'Area', 1, 0, 'C', true);
    $pdf->Cell(28, 10, 'Reg Date', 1, 1, 'C', true);

    // Query MemberMaster
    $query = "SELECT * FROM MemberMaster WHERE MID = '$mid'";
    $result = mysqli_query($conn, $query);


    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);

    if ($row = mysqli_fetch_assoc($result)) {
        $pdf->SetFillColor(240, 240, 240); 
        $fill = true;

        $pdf->Cell(12, 10, $row['MID'], 1, 0, 'C', $fill);
        $pdf->Cell(30, 10, $row['MName'], 1, 0, 'C', $fill);
        $pdf->Cell(25, 10, $row['AadharNo'], 1, 0, 'C', $fill);
        $pdf->Cell(15, 10, $row['FlatNo'], 1, 0, 'C', $fill);
        $pdf->Cell(25, 10, $row['ContactNo'], 1, 0, 'C', $fill);

        // Handle Email properly with MultiCell and alignment
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell(45, 10, $row['Email'], 1, 'C', $fill);
        $pdf->SetXY($x + 45, $y);

        $pdf->Cell(15, 10, $row['AreaSqFeet'], 1, 0, 'C', $fill);
        $pdf->Cell(28, 10, date('d-m-Y', strtotime($row['RegDate'])), 1, 1, 'C', $fill);
    } else {
        $pdf->Cell(195, 10, 'No member found with this ID.', 1, 1, 'C');
    }
    // Headers for browser PDF view
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=MemberMaster_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    $pdf->Output();
    exit;
}

?>
