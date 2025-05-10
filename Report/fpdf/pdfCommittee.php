<?php
require_once('fpdf186/fpdf.php');

class CommittePDF extends FPDF
{

    function Footer()
    {
      
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Committee Master Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}


function generateCommitteePDF($conn)
{
    $pdf = new CommittePDF();
    $pdf->AddPage();
    $pdf->Image('1.png', 10, 10, 30); 
    $pdf->SetXY(50, 20); 
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');
    $pdf->SetY(45);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Committee Master Report', 1, 1, 'C');
    $pdf->Ln(10);


    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, 'CID', 1);
    $pdf->Cell(10, 10, 'MID', 1);
    $pdf->Cell(40, 10, 'Name', 1);
    $pdf->Cell(30, 10, 'Contact', 1);
    $pdf->Cell(30, 10, 'Aadhar No', 1);
    $pdf->Cell(30, 10, 'Designation', 1);
    $pdf->Cell(20, 10, 'A.Date', 1);
    $pdf->Cell(20, 10, 'D.Date', 1);
    $pdf->Ln();


    $query = "SELECT * FROM CommitteeMaster";
    $result = mysqli_query($conn, $query);
    $pdf->SetFont('Arial', '', 10);

    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(10, 10, $row['CID'], 1);
        $pdf->Cell(10, 10, $row['MID'], 1);
        $pdf->Cell(40, 10, $row['MName'], 1);
        $pdf->Cell(30, 10, $row['ContactNo'], 1);
        $pdf->Cell(30, 10, $row['AadharNo'], 1);
        $pdf->Cell(30, 10, $row['Designation'], 1);
        $pdf->Cell(20, 10, date('d-m-Y', strtotime($row['ADate'])), 1);
        $pdf->Cell(20, 10, date('d-m-Y', strtotime($row['DDate'])), 1);
        $pdf->Ln();
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
