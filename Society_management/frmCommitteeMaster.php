<?php
// Establish a single database 
$conn = mysqli_connect("localhost", "root", "", "housingsociety");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    // Generate the next Committee ID
    $sql = "SELECT MAX(CID) AS MaxID FROM CommitteeMaster";
    $result = mysqli_query($conn, $sql);
    $newId = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newId = $row['MaxID'] + 1; // Increment the max ID
    }

    echo "<script>document.getElementById('committeeId').value = '$newId';</script>";
}

// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    // Insert data into CommitteeMaster table
    $cid = $_POST["txtCId"];
    $mid = $_POST["txtMId"];
    $name = $_POST["txtMName"];
    $contact = $_POST["txtContact"];
    $aadhar = $_POST["txtAadharNo"];
    $designation = $_POST["txtDesignation"];
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
    $mid = $_POST["txtMId"];
    $name = $_POST["txtMName"];
    $contact = $_POST["txtContact"];
    $aadhar = $_POST["txtAadharNo"];
    $designation = $_POST["txtDesignation"];
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



// Function to display all data in the CommitteeMaster table
function showData($conn)
{
    $sql = "SELECT * FROM CommitteeMaster";
    $r = mysqli_query($conn, $sql);

    echo "<table border='1' class='table table-dark table-striped'><thead>
          <tr><th>Committee ID</th><th>Member ID</th><th>Member Name</th><th>Contact Number</th>
          <th>Aadhar Number</th><th>Designation</th><th>Appointment Date</th><th>Due Date</th></tr></thead><tbody>";

    if (mysqli_num_rows($r) > 0) {
        while ($x = mysqli_fetch_assoc($r)) {
             // Format the dates in dd-mm-yy format
             $appointmentDate = date("d-m-y", strtotime($x['ADate']));
             $dueDate = date("d-m-y", strtotime($x['DDate']));
 
             echo "<tr>
                   <td>" . $x['CID'] . "</td>
                   <td>" . $x['MID'] . "</td>
                   <td>" . $x['MName'] . "</td>
                   <td>" . $x['ContactNo'] . "</td>
                   <td>" . $x['AadharNo'] . "</td>
                   <td>" . $x['Designation'] . "</td>
                   <td>" . $appointmentDate . "</td>
                   <td>" . $dueDate . "</td>
                   </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No records found in CommitteeMaster table</td></tr>";
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
    <title>Housing Society Management - Committee Master</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styleMaster.css">
    <?php
        include('header.php');
    ?>

</head>
<body>
<div class="member-master-page">
    <div class="form-container">
        <h2 class="text-center mb-4">Committee Master</h2>
        <form method="post" action="">
            <!-- Committee ID -->
            <div class="row form-row">
                <label for="committeeId" class="col-sm-3 col-form-label text-end">Committee ID:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="committeeId" name="txtCId"
                    value="<?php echo isset($_POST['btnNew']) ? $newId : ''; ?>" placeholder="Enter Committee ID">
                </div>
                <div class="col-sm-3">
                    <button type="submit" name="btnNew" class="btn btn-primary">New</button>
                </div>
            </div>

            <!-- Member ID -->
            <div class="row form-row">
                <label for="memberId" class="col-sm-3 col-form-label text-end">Member ID:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="memberId" name="txtMId" placeholder="Enter Member ID">
                </div>
                <div class="col-sm-3">
                    <button type="submit" name="btnSearch" class="btn btn-primary">Search</button>
                </div>
            </div>

            <!-- Member Name -->
            <div class="row form-row">
                <label for="memberName" class="col-sm-3 col-form-label text-end">Name:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="memberName" name="txtMName" placeholder="Enter Name">
                </div>
            </div>

            <!-- Contact -->
            <div class="row form-row">
                <label for="contact" class="col-sm-3 col-form-label text-end">Contact:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="contact" name="txtContact" placeholder="Enter Contact Number">
                </div>
            </div>

            <!-- Aadhaar Number -->
            <div class="row form-row">
                <label for="aadharNo" class="col-sm-3 col-form-label text-end">Aadhaar No:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="aadharNo" name="txtAadharNo" placeholder="Enter Aadhaar Number">
                </div>
            </div>

            <!-- Designation -->
            <div class="row form-row">
                <label for="designation" class="col-sm-3 col-form-label text-end">Designation:</label>
                <div class="col-sm-6">
                    <select class="form-select" id="designation" name="txtDesignation">
                        <option value="" disabled selected>Select Designation</option>
                        <option value="Manager">Manager</option>
                        <option value="Supervisor">Supervisor</option>
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
                <div class="col-12 text-center">
                    <button type="submit"  name="btnAdd"   class="btn btn-success mx-2">Add</button>
                    <button type="submit"  name="btnUpdate" class="btn btn-warning mx-2">Update</button>
                    <button type="submit"  name="btnDelete" class="btn btn-danger mx-2">Delete</button>
                    <button type="reset"   name="btnCancel" class="btn btn-secondary mx-2">Cancel</button>
                </div>
            </div>
        </form>
        <!-- Table Wrapper -->
        <div class="table-wrapper">
            <!-- Show data -->
            <h3 class="mt-4">Committee Records</h3>
            <?php showData($conn);?>
        </div>
    </div>
</div>
    <?php
        include('footer.php');
    ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Close the database connection at the end of the script
mysqli_close($conn);
?>
