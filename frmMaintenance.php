<?php 
session_start();
include('db.php');

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php");
    exit();
}

//include('fpdf/pdfMaintenance.php');
if (isset($_POST["btnReport"])) {
    $bno = $_POST["txtBNo"];
    if (!empty($bno)) {
        header("Location: fpdf/pdfMaintenance.php?BNO=" . $bno);
        exit();
    } else {
        echo "<script>alert('Please enter a Bill Number');</script>";
    }
}
// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    
    $sql = "SELECT MAX(BNo) AS MaxID FROM Maintenance";
    $result = mysqli_query($conn, $sql);
    $newBillNo = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newBillNo = $row['MaxID'] + 1;
    }

    
    // Store the new ID in the session
    $_SESSION['newBillNo'] = $newBillNo;
}

// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    $bno = $_POST["txtBNo"];
    $bdate = $_POST["txtDate"];
    $mid = $_POST["txtMId"] ?? "";
    $name = $_POST["txtMName"] ?? "";
    $sdate = $_POST["txtSDate"];
    $edate = $_POST["txtEDate"];
    $amount = $_POST["txtAmount"];
    $billDetails = $_POST["txtBillDisplay"];

    if ($bno != NULL && $bdate != NULL && $mid != NULL && $name != NULL && $sdate != NULL && $edate != NULL && $amount != NULL) {
        $sql = "INSERT INTO Maintenance (BNo, BDate, MID, MName, SDate, EDate, Amount, BDetails) 
                VALUES ('$bno', '$bdate', '$mid', '$name', '$sdate', '$edate', '$amount', '$billDetails')";
        
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Maintenance record added successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Functionality when 'Update' button is clicked
if (isset($_POST["btnUpdate"])) {
    $bno = $_POST["txtBNo"];
    $bdate = $_POST["txtDate"];
    $mid = $_POST["txtMId"] ?? "";
    $name = $_POST["txtMName"] ?? "";
    $sdate = $_POST["txtSDate"];
    $edate = $_POST["txtEDate"];
    $amount = $_POST["txtAmount"];
    $billDetails = $_POST["txtBillDisplay"];

    if ($bno != NULL && $bdate != NULL && $mid != NULL && $name != NULL && $sdate != NULL && $edate != NULL && $amount != NULL) {
        $sql = "UPDATE Maintenance SET BDate='$bdate', MID='$mid', MName='$name', SDate='$sdate', EDate='$edate', Amount='$amount', BDetails='$billDetails' WHERE BNo='$bno'";
        
        $r = mysqli_query($conn, $sql);
        
        if ($r) {
            echo "<script>alert('Maintenance record updated successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Functionality when 'Delete' button is clicked
if (isset($_POST["btnDelete"])) {
    $bno = $_POST["txtBNo"];
    
    if ($bno != NULL) {
        $sql = "DELETE FROM Maintenance WHERE BNo='$bno'";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Maintenance record deleted successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Please enter a valid Bill No to delete.');</script>";
    }
}

// Function to display all data in the Maintenance table
function showData($conn)
{
    $sql = "SELECT * FROM Maintenance";
    $r = mysqli_query($conn, $sql);

    echo "<table border='1' class='table table-dark table-striped'><thead>
          <tr><th>Bill No</th><th>Bill Date</th><th>Member ID</th><th>Member Name</th>
          <th>Start Date</th><th>End Date</th><th>Amount</th><th>Bill Details</th></tr></thead><tbody>";

    if (mysqli_num_rows($r) > 0) {
        while ($x = mysqli_fetch_assoc($r)) {
             // Format the dates in dd-mm-yy format
             $billDate = date("d-m-y", strtotime($x['BDate']));
             $startDate = date("d-m-y", strtotime($x['SDate']));
             $endDate = date("d-m-y", strtotime($x['EDate']));
 
             echo "<tr>
                   <td>" . $x['BNo'] . "</td>
                   <td>" . $billDate . "</td>
                   <td>" . $x['MID'] . "</td>
                   <td>" . $x['MName'] . "</td>
                   <td>" . $startDate . "</td>
                   <td>" . $endDate . "</td>
                   <td>" . $x['Amount'] . "</td>
                   <td>" . $x['BDetails'] . "</td>
                   </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No records found in Maintenance table</td></tr>";
    }
    echo "</tbody></table>";
}

if (isset($_POST["btnCancel"])) {
    $_SESSION['mid'] = "";
    $_SESSION['name'] = "";
    unset($_SESSION['newBillNo']);
    $_POST = array(); // Clears all form data
}

// Functionality when 'Search' button is clicked
if (isset($_POST["btnSearch"])) {
    $mid = $_POST["txtMId"];
    
    $conn1 = mysqli_connect("localhost", "root", "", "housingsociety");

    if (!empty($mid) && $conn) {
        $sql1 = "SELECT MID, MName FROM membermaster WHERE MID = '$mid'";
        $result = mysqli_query($conn1, $sql1);

        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['mid'] = $row['MID'];
            $_SESSION['name'] = $row['MName'];
        
        } else {
            echo "<script>alert('No member found with this ID.');</script>";
        }
    } else {
        echo "<script>alert('Please enter a Member ID to search.');</script>";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housing Society Management - Maintenance</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('Sidebar.php'); ?>
    
    <link rel="stylesheet" href="css/styleMaster.css">
    
</head>
<body>
<div class="home-section">

     <!-- Navbar -->
     <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Maintenance</h1>
        <?php
            include 'AdminDropDown.php';
        ?>
     </nav>
    <div class="member-master-page">
        <div class="form-container">
            <h2 class="text-center mb-4">Maintenance Form</h2>
            <form method="post" action="">
                <!-- Bill No -->
                <div class="row form-row align-items-center">
                    <label for="billNo" class="col-sm-3 col-form-label text-end">Bill No:</label>
                    <div class="col-sm-6 d-flex">
                        <input type="number" class="form-control me-2" id="billNo" name="txtBNo"
                        value="<?php if(isset($_SESSION['newBillNo'])) echo $_SESSION['newBillNo']; ?>" 
                            placeholder="Enter Bill No">
                        <button type="submit" name="btnNew" class="btn btn-primary">New</button>
                    </div>
                </div>

                <!-- Date -->
                <div class="row form-row">
                    <label for="date" class="col-sm-3 col-form-label text-end">Date:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="date" name="txtDate"
                        value="<?php if(isset($_POST['txtDate'])) echo $_POST['txtDate']; ?>">
                    </div>
                </div>

                <!-- Member ID -->
                <div class="row form-row align-items-center mt-2">
                <label for="memberId" class="col-sm-3 col-form-label text-end">Member ID:</label>
                    <div class="col-sm-6 d-flex">
                        <select class="form-select me-2" id="memberId" name="txtMId" data-bs-container="body">
                            <option value="" disabled selected class="placholder option">Enter Member Id</option>
                            <?php
                                $sql = "SELECT MID FROM MemberMaster";
                                $result = mysqli_query($conn, $sql);
                                $selectedMid = isset($_SESSION['mid']) ? $_SESSION['mid'] : '';

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $isSelected = ($row['MID'] == $selectedMid) ? "selected" : "";
                                        echo "<option value='" . $row['MID'] . "' $isSelected>" . $row['MID'] . "</option>";
                                    }
                                }
                            ?>
                        </select>
                        <button type="submit" name="btnSearch" class="btn btn-primary">Search</button>
                    </div>
                </div>
                

                <!-- Member Name -->
                <div class="row form-row align-items-center mt-2">
                <label for="memberName" class="col-sm-8 col-form-label text-end">Member Name:</label>
                    <div class="col-sm-6 d-flex">
                        <select class="form-select me-2" id="memberName" name="txtMName">
                            <option value="" disabled selected class="placholder option">Enter Member Name</option>
                            <?php
                                $sql = "SELECT MName FROM MemberMaster";
                                $result = mysqli_query($conn, $sql);
                                $selectedMid = isset($_SESSION['name']) ? $_SESSION['name'] : '';

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $isSelected = ($row['MName'] == $selectedMid) ? "selected" : "";
                                        echo "<option value='" . $row['MName'] . "' $isSelected>" . $row['MName'] . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    
                    </div>
                </div>

                <!-- Start Date -->
                <div class="row form-row">
                    <label for="startDate" class="col-sm-3 col-form-label text-end">Start Date:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="startDate" name="txtSDate">
                    </div>
                </div>

                <!-- End Date -->
                <div class="row form-row">
                    <label for="endDate" class="col-sm-3 col-form-label text-end">End Date:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="endDate" name="txtEDate">
                    </div>
                </div>

                <!-- Amount -->
                <div class="row form-row">
                    <label for="amount" class="col-sm-3 col-form-label text-end">Amount:</label>
                    <div class="col-sm-6 d-flex">
                        <input type="number" class="form-control  me-2" id="amount" name="txtAmount" placeholder="Amount" step="0.01" min="0">
                        <button type="button" onclick="location.href='Cashfree_payment_gateway/checkout/start.php'"  class="btn btn-secondary">Payment</button>
                    </div>
                </div>

                <!-- Bill Display -->
                <div class="row form-row">
                    <label for="billDisplay" class="col-sm-3 col-form-label text-end">Bill:</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="billDisplay" name="txtBillDisplay" rows="4" placeholder="Bill Details"></textarea>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center flex-wrap gap-4">
                        <button type="submit" name="btnAdd" class="btn btn-success">Add</button>
                        <button type="submit" name="btnUpdate" class="btn btn-warning">Update</button>
                        <button type="submit" name="btnDelete" class="btn btn-danger">Delete</button>
                        <button type="submit" name="btnCancel" class="btn btn-secondary" >Cancel</button>
                        <button type="submit" name="btnShowData" class="btn btn-info" style="min-width: 120px; white-space: nowrap;">Show Data</button>
                        <button type="submit" name="btnReport" class="btn btn-secondary">Report</button>
                       
                    </div>
                </div>
            </form>
            <!-- Table Wrapper -->
            <div class="table-wrapper">
                <!-- Show data -->
                <?php
                    if (isset($_POST['btnShowData'])) {
                        echo '<h3 class="mt-4">Maintenance Records</h3>';
                        showData($conn);
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Close the database connection at the end of the script
mysqli_close($conn);
?>