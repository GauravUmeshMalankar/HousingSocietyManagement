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



//include('fpdf/pdfMember.php');
if (isset($_POST["btnReport"])) {
    $mid = $_POST["txtMId"];
    if (!empty($mid)) {
        header("Location: fpdf/pdfMember.php?MID=" . $mid);
        exit();
    } else {
        echo "<script>alert('Please enter a Member ID');</script>";
    }
}

// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    // Generate the next Member ID
    $sql = "SELECT MAX(MID) AS MaxID FROM MemberMaster";
    $result = mysqli_query($conn, $sql);
    $newId = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newId = $row['MaxID'] + 1;
    }
     // Store the new ID in the session
     $_SESSION['newId'] = $newId;
}

// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    // Insert data into MemberMaster table
    $id = $_POST["txtMId"];
    $name = $_POST["txtMName"];
    $aadhar = $_POST["txtAadharNo"];
    $flat = $_POST["txtFlatNo"] ?? "";
    $contact = $_POST["txtContactNo"];
    $email = $_POST["txtEmail"]; 
    $area = $_POST["txtArea"];
    $regId = $_POST["txtRegId"];
    $regDate = $_POST["txtRegDate"];
    $checkedBy = $_POST["txtCheckedBy"] ?? "";

    // Check if all fields are filled
    if ($id != NULL && $name != NULL && $aadhar != NULL && $flat != NULL && $contact != NULL && $email != NULL && $area != NULL && $regId != NULL && $regDate != NULL && $checkedBy != NULL) {
        
        $sql = "INSERT INTO MemberMaster (MID, MName, AadharNo, FlatNo, ContactNo, Email, AreaSqFeet, RegID, RegDate, CheckedBy) 
                VALUES ($id, '$name', '$aadhar', '$flat', '$contact', '$email', $area, '$regId', '$regDate', '$checkedBy')";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Member added successfully.')</script>";
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
    $id = $_POST["txtMId"];
    $name = $_POST["txtMName"];
    $aadhar = $_POST["txtAadharNo"];
    $flat = $_POST["txtFlatNo"] ?? "";
    $contact = $_POST["txtContactNo"];
    $email = $_POST["txtEmail"]; 
    $area = $_POST["txtArea"];
    $regId = $_POST["txtRegId"];
    $regDate = $_POST["txtRegDate"];
    $checkedBy = $_POST["txtCheckedBy"] ?? "";

    // Check if all fields are filled
    if ($id != NULL) {

        // Update query
        $sql = "UPDATE MemberMaster 
                SET MName='$name', AadharNo='$aadhar', FlatNo='$flat', ContactNo='$contact', 
                    Email='$email', AreaSqFeet=$area, RegID='$regId', RegDate='$regDate', CheckedBy='$checkedBy' 
                WHERE MID=$id";

        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Member updated successfully.')</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Functionality when 'Delete' button is clicked
if (isset($_POST["btnDelete"])) {
    // Get Member ID from the form
    $id = $_POST["txtMId"];
    
    // Check if Member ID is provided
    if ($id != NULL) {
        // Delete query
        $sql = "DELETE FROM MemberMaster WHERE MID='$id'";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Member deleted successfully.')</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Member ID is required!');</script>";
    }
}

if (isset($_POST["btnCancel"])) {
     // Unset all session variables related to member details
     unset($_SESSION['mid']);
     unset($_SESSION['name']);
     unset($_SESSION['aadharNo']);
     unset($_SESSION['flatNo']);
     unset($_SESSION['contactNo']);
     unset($_SESSION['email']);
     unset($_SESSION['area']);
     unset($_SESSION['regId']);
     unset($_SESSION['regDate']);
     unset($_SESSION['checkedBy']);
     unset($_SESSION['newId']); // Also clear the new ID if any
}

// Functionality when 'Search' button is clicked
if (isset($_POST["btnSearch"])) {
    $mid = $_POST["txtMId"];
    
  

    if (!empty($mid) && $conn) {
        $sql = "SELECT * FROM membermaster WHERE MID = '$mid'";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            // Store all member details in session
            $_SESSION['mid'] = $row['MID'];
            $_SESSION['name'] = $row['MName'];
            $_SESSION['aadharNo'] = $row['AadharNo'];
            $_SESSION['flatNo'] = $row['FlatNo'];
            $_SESSION['contactNo'] = $row['ContactNo'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['area'] = $row['AreaSqFeet'];
            $_SESSION['regId'] = $row['RegID'];
            $_SESSION['regDate'] = $row['RegDate'];
            $_SESSION['checkedBy'] = $row['CheckedBy'];

        } else {
            echo "<script>alert('No member found with this ID.');</script>";
        }
    } else {
        echo "<script>alert('Please enter a Member ID to search.');</script>";
    }
}

// Function to display all data in the MemberMaster table
function showData($conn)
{
    $sql = "SELECT * FROM MemberMaster";
    $r = mysqli_query($conn, $sql);

    echo "<table border='1' class='table table-dark table-striped'><thead>
          <tr><th>Member ID</th><th>Member Name</th><th>Aadhar Number</th><th>Flat Number</th>
          <th>Contact Number</th><th>Email</th><th>Area</th><th>Registration ID</th><th>Registration Date</th><th>Checked By</th></tr></thead><tbody>";

    if (mysqli_num_rows($r) > 0) {
        while ($x = mysqli_fetch_assoc($r)) {
            echo "<tr>
                  <td>" . $x['MID'] . "</td>
                  <td>" . $x['MName'] . "</td>
                  <td>" . $x['AadharNo'] . "</td>
                  <td>" . $x['FlatNo'] . "</td>
                  <td>" . $x['ContactNo'] . "</td>
                  <td>" . $x['Email'] . "</td>
                  <td>" . $x['AreaSqFeet'] . "</td>
                  <td>" . $x['RegID'] . "</td>
                  <td>" . $x['RegDate'] . "</td>
                  <td>" . $x['CheckedBy'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No records found in MemberMaster table</td></tr>";
    }
    echo "</tbody></table>";
}


// Call the function to display data
?>
      

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housing Society Management - Member Master</title>
    

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('Sidebar.php'); ?> 
    <link rel="stylesheet" href="css/styleMaster.css">
 
</head>
<body>

<div class="home-section">

      <!-- Navbar -->
       <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Member Master</h1>
        <?php
            include 'AdminDropDown.php';
        ?>
     </nav>
    <div class="member-master-page">
            <div class="form-container">
                
                <h2 class="text-center mb-4">Member Master</h2>
                <form method="post">
                    <!-- Member ID -->
                    <div class="row form-row align-items-center">
                        <label for="memberId" class="col-sm-3 col-form-label text-end">Member ID:</label>
                        <div class="col-sm-6 d-flex">
                            <input type="number" class="form-control me-2" id="memberId" name="txtMId"
                           value="<?php echo isset($_SESSION['mid']) ? $_SESSION['mid'] : (isset($_SESSION['newId']) ? $_SESSION['newId'] : ''); ?>"
                            placeholder="Enter Member ID">
                            <button type="submit" name="btnNew" class="btn btn-primary me-2">New</button>
                            <button type="submit" name="btnSearch" class="btn btn-primary">Search</button>
                        </div>
                    </div>

                    <!-- Member Name -->
                    <div class="row form-row align-items-center mt-2">
                        <label for="memberName" class="col-sm-3 col-form-label text-end">Member Name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="memberName" name="txtMName" 
                            value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>" 
                            placeholder="Enter Member Name"
                            pattern="[A-Za-z ]+" title="Only alphabetic characters and spaces are allowed">
                        </div>
                    </div>

                    <!-- Aadhar Number -->
                    <div class="row form-row align-items-center mt-2">
                        <label for="aadharNo" class="col-sm-3 col-form-label text-end">Aadhar Number:</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="aadharNo" name="txtAadharNo" 
                            value="<?php echo isset($_SESSION['aadharNo']) ? $_SESSION['aadharNo'] : ''; ?>" placeholder="Enter Aadhar Number"
                            pattern="\d{12}" maxlength="12"
                            title="Enter a valid 12-digit Aadhar number">
                        </div>
                    </div>

                    <!-- Flat Number -->
                    <div class="row form-row align-items-center mt-2">
                        <label for="flatNo" class="col-sm-3 col-form-label text-end">Flat Number:</label>
                        <div class="col-sm-6">
                            <select class="form-select" id="flatNo" name="txtFlatNo" data-bs-container="body">
                                <option value="" disabled selected>Select Flat Number</option>
                                   <!-- Dynamic Flat Numbers -->
                                    <?php
                                    for ($floor = 1; $floor <= 7; $floor++) { 
                                        for ($flat = 1; $flat <= 4; $flat++) { 
                                            $flatNumber = $floor . sprintf("%02d", $flat); 
                                            echo "<option value=\"$flatNumber\">$flatNumber</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Contact Number -->
                    <div class="row form-row align-items-center mt-2">
                        <label for="contactNo" class="col-sm-3 col-form-label text-end">Contact Number:</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="contactNo" name="txtContactNo"
                            value="<?php echo isset($_SESSION['contactNo']) ? $_SESSION['contactNo'] : ''; ?>"  placeholder="Enter Contact Number"
                            pattern="[0-9]{10}" maxlength="10"
                            title="Enter a valid 10-digit contact number">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="row form-row align-items-center mt-2">
                        <label for="contactNo" class="col-sm-3 col-form-label text-end">Email Id:</label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" name="txtEmail"
                            value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>"  placeholder="Enter Email ID">
                        </div>
                    </div>


                    <!-- Area (Sq Feet) -->
                    <div class="row form-row align-items-center mt-2">
                        <label for="area" class="col-sm-3 col-form-label text-end">Area (Sq Feet):</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="area" name="txtArea" 
                            value="<?php echo isset($_SESSION['area']) ? $_SESSION['area'] : ''; ?>" placeholder="Enter Area in Sq Feet" step="0.01" min="0">
                        </div>
                    </div>

                    <!-- Registration ID -->
                    <div class="row form-row align-items-center mt-2">
                        <label for="registrationId" class="col-sm-3 col-form-label text-end">Registration ID:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="registrationId" name="txtRegId" 
                            value="<?php echo isset($_SESSION['regId']) ? $_SESSION['regId'] : ''; ?>" placeholder="Enter Registration ID">
                        </div>
                    </div>

                    <!-- Registration Date -->
                    <div class="row form-row align-items-center mt-2">
                        <label for="registrationDate" class="col-sm-3 col-form-label text-end">Registration Date:</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" id="registrationDate" name="txtRegDate"
                            value="<?php echo isset($_SESSION['regDate']) ? $_SESSION['regDate'] : ''; ?>">
                        </div>
                    </div>

                    <!-- Checked By -->
                    <div class="row form-row align-items-center mt-2">
                        <label for="checkedBy" class="col-sm-3 col-form-label text-end">Checked By:</label>
                        <div class="col-sm-6">
                            <select class="form-select" id="checkedBy" name="txtCheckedBy">
                                <option value="" disabled selected>Select Checker</option>
                                <option value="Manager" <?php echo (isset($_SESSION['checkedBy']) && $_SESSION['checkedBy'] == 'Manager') ? 'selected' : ''; ?>>Manager</option>
                                <option value="Supervisor" <?php echo (isset($_SESSION['checkedBy']) && $_SESSION['checkedBy'] == 'Supervisor') ? 'selected' : ''; ?>>Supervisor</option>
                            </select>
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
                    <?php
                        if (isset($_POST['btnShowData'])) {
                            echo '<h4 class="mt-4">Member Records</h4>';
                            showData($conn);
                        }
                    ?>
                </div>
            </div>
    </div>
</div>
        
<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('memberName').addEventListener('keypress', function (e) {
        const char = String.fromCharCode(e.which);
        if (!/^[a-zA-Z ]$/.test(char)) {
            e.preventDefault();
        }
    });
</script>



</body>
</html>

<?php
// Close the database connection at the end of the script
mysqli_close($conn);
?>