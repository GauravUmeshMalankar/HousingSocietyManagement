<?php 
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php");
    exit();
}

$stmt = $conn->prepare("SELECT user_type FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user || $user['user_type'] !== 'admin') {
    session_destroy();
    echo "<script>alert('Access Denied! Only Admins can access this page.'); window.location.href='Login1/login.php';</script>";
    exit();
}


//include('fpdf/pdfCommittee.php');

if (isset($_POST["btnReport"])) {
    $cid = $_POST["txtCId"];
    if (!empty($cid)) {
        header("Location: fpdf/pdfCommittee.php?CID=" . $cid);
        exit();
    } else {
        echo "<script>alert('Please enter a Committee ID');</script>";
    }
}

// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    // Generate the next Committee ID
    $sql = "SELECT MAX(CID) AS MaxID FROM CommitteeMaster";
    $result = mysqli_query($conn, $sql);
    $newCID = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newCID = $row['MaxID'] + 1; // Increment the max ID
    }

    // Store the new ID in the session
    $_SESSION['newCID'] = $newCID;
}


// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    // Insert data into CommitteeMaster table
    $cid = $_POST["txtCId"];
    $mid = $_POST["txtMId"] ?? "";
    $name = $_POST["txtMName"] ?? "";
    $contact = $_POST["txtContact"];
    $aadhar = $_POST["txtAadharNo"];
    $designation = $_POST["txtDesignation"] ?? "";
    $adate = $_POST["txtAppointmentDate"];
    $ddate = $_POST["txtDueDate"];

    // Check if all fields are filled
    if ($cid != NULL && $mid != NULL && $name != NULL && $contact != NULL && $aadhar != NULL && $designation != NULL && $adate != NULL && $ddate != NULL) {
        $sql = "INSERT INTO CommitteeMaster (CID, MID, MName, ContactNo, AadharNo, Designation, ADate, DDate) 
                VALUES ($cid, $mid, '$name', '$contact', '$aadhar', '$designation', '$adate', '$ddate')";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Committee member added successfully.')</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Functionality when 'Update' button is clicked
if (isset($_POST["btnUpdate"])) {
    // Get values from the form
    $cid = $_POST["txtCId"];
    $mid = $_POST["txtMId"] ?? "";
    $name = $_POST["txtMName"] ?? "";
    $contact = $_POST["txtContact"];
    $aadhar = $_POST["txtAadharNo"];
    $designation = $_POST["txtDesignation"] ?? "";
    $adate = $_POST["txtAppointmentDate"];
    $ddate = $_POST["txtDueDate"];

    // Check if all fields are filled
    if ($cid != NULL) {
        // Update query
        $sql = "UPDATE CommitteeMaster 
                SET MID='$mid', MName='$name', ContactNo='$contact', AadharNo='$aadhar', 
                    Designation='$designation', ADate='$adate', DDate='$ddate' 
                WHERE CID=$cid";
        
        $r = mysqli_query($conn, $sql);
        
        if ($r) {
            echo "<script>alert('Committee member updated successfully.')</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Functionality when 'Delete' button is clicked
if (isset($_POST["btnDelete"])) {
    // Get Committee ID from the form
    $cid = $_POST["txtCId"];
    
    // Check if Committee ID is provided
    if ($cid != NULL) {
        // Delete query
        $sql = "DELETE FROM CommitteeMaster WHERE CID='$cid'";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Committee member deleted successfully.')</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Functionality for 'Cancel' button
if (isset($_POST["btnCancel"])) {
    unset($_SESSION['mid']);
    $_SESSION['name'] = "";
    $_SESSION['contact'] = "";
    $_SESSION['aadhar'] = "";
    unset($_SESSION['newCID']);
    //$_POST = array();
}

// Functionality when 'Search' button is clicked
if (isset($_POST["btnSearch"])) {
    $mid = $_POST["txtMId"];
    
    $conn1 = mysqli_connect("localhost", "root", "", "housingsociety");

    if (!empty($mid) && $conn) {
        $sql1 = "SELECT MID, MName, ContactNo, AadharNo FROM membermaster WHERE MID = '$mid'";
        $result = mysqli_query($conn1, $sql1);

        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['mid'] = $row['MID'];
            $_SESSION['name'] = $row['MName'];
            $_SESSION['contact'] = $row['ContactNo'];
            $_SESSION['aadhar'] = $row['AadharNo'];
        } else {
            echo "<script>alert('No member found with this ID.');</script>";
        }
    } else {
        echo "<script>alert('Please enter a Member ID to search.');</script>";
    }
    
}



// Function to display all data in the CommitteeMaster table
function showData($conn)
{
    $sql = "SELECT * FROM CommitteeMaster";
    $r = mysqli_query($conn, $sql);

    echo "<table border='1' class='table table-dark table-striped'><thead>
          <tr><th>Committee ID</th><th>Member ID</th><th>Member Name</th><th>Contact</th>
          <th>Aadhar</th><th>Designation</th><th>Appointment Date</th><th>Due Date</th></tr></thead><tbody>";

    if (mysqli_num_rows($r) > 0) {
        while ($x = mysqli_fetch_assoc($r)) {
            echo "<tr>
                   <td>" . $x['CID'] . "</td>
                   <td>" . $x['MID'] . "</td>
                   <td>" . $x['MName'] . "</td>
                   <td>" . $x['ContactNo'] . "</td>
                   <td>" . $x['AadharNo'] . "</td>
                   <td>" . $x['Designation'] . "</td>
                   <td>" . $x['ADate']. "</td>
                   <td>" . $x['DDate'] . "</td>
                   </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No records found in CommitteeMaster table</td></tr>";
    }
    echo "</tbody></table>";
}
$sql = "SELECT MID FROM MemberMaster";
$result = mysqli_query($conn, $sql);
// Call the function to display data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housing Society Management - Committee Master</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('Sidebar.php'); ?>  <!-- Sidebar should be here -->
    <link rel="stylesheet" href="css/styleMaster.css">
  
   
</head>
<body>



<div class="home-section">
     <!-- Navbar -->

       <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Committee Master</h1>
        <?php
            include 'AdminDropDown.php';
        ?>
      </nav>

        
    <div class="member-master-page">
    
        <div class="form-container">
       
            <h2 class="text-center mb-4">Committee  Master</h2>
            <form method="post" action="">
                <!-- Committee ID -->
                <div class="row form-row align-items-center">
                    <label for="committeeId" class="col-sm-3 col-form-label text-end">Committee ID:</label>
                    <div class="col-sm-6 d-flex">
                    <input type="number" class="form-control me-2" id="committeeId" name="txtCId"
                    value="<?php if(isset($_SESSION['newCID'])) echo $_SESSION['newCID']; ?>" placeholder="Enter Committee ID">
                    <button type="submit" name="btnNew" class="btn btn-primary">New</button>
                    </div>
                </div>

                <!-- Member ID -->
                <div class="row form-row align-items-center mt-2">
                <label for="memberId" class="col-sm-3 col-form-label text-end">Member ID:</label>
                    <div class="col-sm-6 d-flex">
                        <select class="form-select me-2" id="memberId" name="txtMId">
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
                

                <!-- Contact -->
                <div class="row form-row">
                    <label for="contact" class="col-sm-3 col-form-label text-end">Contact:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="contact" name="txtContact"
                        value="<?php if(isset($_SESSION['contact'])) echo $_SESSION['contact']; ?>" placeholder="Enter Contact Number"
                        pattern="[0-9]{10}" maxlength="10"
                        title="Enter a valid 10-digit contact number">

                    
                    </div>
                </div>

                <!-- Aadhaar Number -->
                <div class="row form-row">
                    <label for="aadharNo" class="col-sm-3 col-form-label text-end">Aadhaar No:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="aadharNo" name="txtAadharNo"
                        value="<?php if(isset($_SESSION['aadhar'])) echo $_SESSION['aadhar']; ?>" placeholder="Enter Aadhaar Number"
                        pattern="\d{12}" maxlength="12"
                        title="Enter a valid 12-digit Aadhar number">
            
                    </div>
                </div>

                <!-- Designation -->
                <div class="row form-row align-items-center" >
                    <label for="designation" class="col-sm-3 col-form-label text-end">Designation:</label>
                    <div class="col-sm-6">
                        <select class="form-select" id="designation" name="txtDesignation">
                            <option value="" disabled selected>Select Designation</option>
                            <option value="Chairman">Chairman</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Tresaury">Tresasury</option>
                            <option value="Manager">Manager</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>
                </div>

                <!-- Appointment Date -->
                <div class="row form-row">
                    <label for="appointmentDate" class="col-sm-3 col-form-label text-end">Appointment Date:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="appointmentDate" name="txtAppointmentDate">
                    </div>
                </div>

                <!-- Due Date -->
                <div class="row form-row">
                    <label for="dueDate" class="col-sm-3 col-form-label text-end">Due Date:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="dueDate" name="txtDueDate">
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
                        echo '<h3 class="mt-4">Committee Records</h3>';
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