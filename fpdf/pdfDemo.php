<?php 

require('fpdf/fpdf.php'); 

class PDF extends FPDF { 

	// Page header 
	function Header() { 
		
		// Add logo to page 
		$this->Image('z.jpg',10,8,33); 
		
		// Set font family to Arial bold 
		$this->SetFont('Arial','B',40); 
		
		// Move to the right 
		$this->Cell(80); 
		
		// Header 
		$this->Cell(50,10,'Heading',1,0,'C'); 
		
		// Line break 
		$this->Ln(20); 
	} 

	// Page footer 
	function Footer() { 
		
		// Position at 1.5 cm from bottom 
		$this->SetY(-15); 
		
		// Arial italic 8 
		$this->SetFont('Arial','I',8); 
		
		// Page number 
		$this->Cell(0,10,'Page ' . 
			$this->PageNo() . '/{nb}',0,0,'C'); 
	} 
} 

// Instantiation of FPDF class 
$pdf = new PDF(); 

// Define alias for number of pages 
$pdf->AliasNbPages(); 
$pdf->AddPage(); 
$pdf->SetFont('Times','',14); 
/*
for($i = 1; $i <= 30; $i++) 
	$pdf->Cell(0, 10, 'line number '
			. $i, 0, 1); 
$pdf->Cell(0, 10, 'line number '
			. $i, 0, 1); 
*/
$conn = mysqli_connect("localhost","root","","agri");

// Check connection
if (mysqli_connect_errno()) {
 	 $pdf->Cell(0, 10,  "Failed to connect to MySQL: " . mysqli_connect_error(),0,1);
  	exit();
	}


$sql="select * from farmer where FId='".$_POST["txtFId"]."'";
$r=mysqli_query($conn,$sql);
$pdf->ln(25);
//$pdf->Cell(0, 10, " ID	Name	Address	Contact " ,0,1);
if(mysqli_num_rows($r) >0)
{
	//while($x=mysqli_fetch_row($r))
	while($x=mysqli_fetch_assoc($r))
	{
	$pdf->Cell(0, 10, "ID:		".$x['FId']."		" , 0 ,1);
	$pdf->ln();
	$pdf->Cell(0, 10, "Name:		".$x['Name'] , 0 ,1);
	$pdf->ln();
	$pdf->Cell(0, 10, "Address	".$x['Addr'] , 0 ,1);
	$pdf->ln();
	$pdf->Cell(0, 10,"Contact:	".$x['Contact'] , 0 ,1);
	$pdf->ln();
//$pdf->Cell(0, 10, 'line number ' "	".$x[0]."	".$x[1]."	".$x[2]."	".$x[3]."	",0,1);

	}
}
else
{
	$pdf->Cell(0, 10, "	No Records found in Farmer Table	" , 0 ,1);
}
$pdf->Cell(0, 10, "		" ,0,1);
mysqli_close($conn);

$pdf->Output(); 

?>
