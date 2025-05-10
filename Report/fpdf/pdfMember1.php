<?php
require_once('fpdf186/fpdf.php');
//require_once(__DIR__ . '/fpdf.php');
class MemberPDF extends FPDF
{
    // Footer method
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Member Master Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Function to generate and preview PDF
function generateMemberPDF($conn)
{
    // Create a new PDF instance
    $pdf = new MemberPDF();
    $pdf->SetLeftMargin(10); // Set left margin
    $pdf->SetRightMargin(10); // Set right margin
    $pdf->AddPage();

    // Add Logo (Adjust path, position, and size as needed)
    $pdf->Image('1.png', 10, 10, 30); // (file, x, y, width)

    // Move to the right of the image
    $pdf->SetXY(50, 20);

    // Title beside the logo
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');

    // Move below the logo
    $pdf->SetY(45);

    // Title for the report
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Member Master Report', 1, 1, 'C');
    $pdf->Ln(10);

    // Table headers
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(12, 10, 'MID', 1);
    $pdf->Cell(30, 10, 'Name', 1);
    $pdf->Cell(25, 10, 'Aadhar No', 1);
    $pdf->Cell(15, 10, 'Flat No', 1);
    $pdf->Cell(25, 10, 'Contact No', 1);
    $pdf->Cell(40, 10, 'Email ID', 1);
    $pdf->Cell(15, 10, 'Area', 1);
    $pdf->Cell(28, 10, 'Reg Date', 1);
    $pdf->Ln();

    // Fetch data from MemberMaster table
    $query = "SELECT * FROM MemberMaster";
    $result = mysqli_query($conn, $query);

    $pdf->SetFont('Arial', '', 9);

    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(12, 10, $row['MID'], 1);
        $pdf->Cell(30, 10, $row['MName'], 1);
        $pdf->Cell(25, 10, $row['AadharNo'], 1);
        $pdf->Cell(15, 10, $row['FlatNo'], 1);
        $pdf->Cell(25, 10, $row['ContactNo'], 1);
        
        // MultiCell for Email (Wrap text if long)
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell(40, 10, $row['Email'], 1);
        $pdf->SetXY($x + 40, $y); // Reset position

        $pdf->Cell(15, 10, $row['AreaSqFeet'], 1);
        $pdf->Cell(28, 10, date('d-m-Y', strtotime($row['RegDate'])), 1);
        $pdf->Ln();
    }

    // Send headers to display PDF in browser
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=MemberMaster_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Output the PDF
    $pdf->Output();
    exit;
}
?>
