<?php
require_once('fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Footer function
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Monthly Meeting Report - By HMS | Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Function to generate Monthly Meeting PDF
function generateMeetingPDF($conn)
{
    $pdf = new PDF();
    $pdf->AddPage();

    // Add Logo
    $pdf->Image('1.png', 10, 10, 30);
    $pdf->SetXY(50, 20);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(100, 10, 'Society Management', 0, 1, 'C');

    // Move below logo
    $pdf->SetY(45);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Monthly Meeting Report', 1, 1, 'C');
    $pdf->Ln(10);

    // Table headers
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 10, 'MeetID', 1);
    $pdf->Cell(30, 10, 'Meeting Date', 1);
    $pdf->Cell(30, 10, 'Notice Date', 1);
    $pdf->Cell(40, 10, 'Notice Issued By', 1);
    $pdf->Cell(70, 10, 'Meeting Reason', 1);
    //$pdf->Cell(50, 10, 'Agenda Photo', 1);
    $pdf->Ln();

    // Fetch data from MonthlyMeeting table
    $query = "SELECT * FROM MonthlyMeeting";
    $result = mysqli_query($conn, $query);

    $pdf->SetFont('Arial', '', 10);

    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(20, 10, $row['MeetID'], 1);
        $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['MDate'])), 1);
        $pdf->Cell(30, 10, date('d-m-Y', strtotime($row['NDate'])), 1);
        $pdf->Cell(40, 10, $row['NoticeIssuedBy'], 1);
        $pdf->Cell(70, 10, $row['Designation'], 1);
    
        /* Image handling
        $imagePath = 'uploads/' . $row['AgendaPhotoPath'];// Assuming filename is stored in AgendaPhotoPath
        if (!empty($row['AgendaPhotoPath']) && file_exists($imagePath)) {
            $pdf->Cell(50, 10, '', 1, 0); // Reserve space for image
            $pdf->Image($imagePath, $pdf->GetX() - 50, $pdf->GetY(), 10, 10); // Adjust size accordingly
        } else {
            $pdf->Cell(50, 10, 'No Photo', 1, 0, 'C'); // Text if no image
        }*/
    
        $pdf->Ln();
    }
    

    // Send headers to display PDF in browser


    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=MonthlyMeeting_Report.pdf");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Output PDF
    $pdf->Output();
    exit;
}


?>
