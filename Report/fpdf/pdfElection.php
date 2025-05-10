<?php
require_once('fpdf186/fpdf.php');

class ElectionPDF extends FPDF
{
    // Footer function
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Election Details Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Function to generate Election Details PDF
function generateElectionPDF($conn)
{
    $pdf = new ElectionPDF();
    $pdf->SetLeftMargin(10); // Set left margin
    $pdf->SetRightMargin(10); // Set right margin
    $pdf->AddPage();

    // Add Logo
    $pdf->Image('1.png', 10, 10, 30);
    $pdf->SetXY(50, 20);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');

    // Move below logo
    $pdf->SetY(45);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Election Details Report', 1, 1, 'C');
    $pdf->Ln(10);

    // Table headers
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(12, 10, 'EID', 1);
    $pdf->Cell(25, 10, 'Date', 1);
    $pdf->Cell(35, 10, 'Notice By Sec.', 1);
    $pdf->Cell(25, 10, 'Chairman', 1);
    $pdf->Cell(25, 10, 'Start Date', 1);
    $pdf->Cell(25, 10, 'End Date', 1);
    $pdf->Cell(25, 10, 'Position', 1);
    $pdf->Cell(18, 10, 'Members', 1);
    $pdf->Ln();

    // Fetch data from ElectionDetails table
    $query = "SELECT * FROM ElectionDetails";
    $result = mysqli_query($conn, $query);

    $pdf->SetFont('Arial', '', 9);

    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(12, 10, $row['EID'], 1);
        $pdf->Cell(25, 10, date('d-m-Y', strtotime($row['EDate'])), 1);
        $pdf->Cell(35, 10, $row['NSecreatary'], 1);
        $pdf->Cell(25, 10, $row['Chairman'], 1);
        $pdf->Cell(25, 10, date('d-m-Y', strtotime($row['PStartDate'])), 1);
        $pdf->Cell(25, 10, date('d-m-Y', strtotime($row['PEndDate'])), 1);
        $pdf->Cell(25, 10, $row['EPosition'], 1);
        $pdf->Cell(18, 10, $row['CMembers'], 1);
        $pdf->Ln();
    }

    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=Election_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Output PDF
    $pdf->Output();
    exit;
}


?>
