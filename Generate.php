
<?php 

//include('fpdf01/pdfMember.php');
include('fpdf01/pdfCommittee.php');
//include('fpdf01/pdfElection.php');
//include('fpdf01/pdfMaintenance.php');
//include('fpdf01/pdfMonthlyMeeting.php');
//include('fpdf01/pdfFine.php');

if (isset($_POST['btnReport']) && isset($_POST['reportType'])) {
    $reportType = $_POST['reportType'];
    $conn = mysqli_connect("localhost", "root", "", "housingsociety");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    switch ($reportType) {
        case 'Member':
            generateMemberPDF($conn);
            break;
        case 'Committee':
            generateCommitteePDF($conn); // You should define similar functions in other files
            break;
        case 'Election':
            generateElectionPDF($conn);
            break;
        case 'Maintenance':
            generateMaintenancePDF($conn);
            break;
        case 'Meeting':
            generateMeetingPDF($conn);
            break;
        case 'Fine':
            generateFinePDF($conn);
            break;
        default:
            echo "<script>alert('Invalid report type selected.');</script>";
            break;
    }
    exit; // Stop HTML from rendering after PDF generation
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('Sidebar.php'); ?>
    <link rel="stylesheet" href="css/styleMaster.css">

</head>
<body>
<div class="home-section">
    <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Generate Reports</h1>
        <?php include 'AdminDropDown.php'; ?>
    </nav>
    
    <div class="member-master-page">
        <div class="form-container">
            <h2 class="text-center mb-4">Generate Reports</h2>
            <form method="post">
                <div class="row form-row align-items-center">
                    <label for="memberId" class="col-sm-3 col-form-label text-end">Generate Report:</label>
                    <div class="col-sm-8 d-flex">
                        <select class="form-select me-3" id="reportType" name="reportType">
               
                            <option value="" disabled selected>Select Report</option>
                            <option value="Member" >Member Report</option>
                            <option value="Committee" >Committee Report</option>
                            <option value="Election" >Election Report</option>
                            <option value="Maintenance" >Maintenance Report</option>
                            <option value="Meeting" >Meeting Report</option>
                            <option value="Fine" >Fine Report</option>
                     
                        </select>
                        <button type="submit" name="btnReport" class="btn btn-primary">Report</button>
                    </div>
                </div>
            </form>
            
          
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
