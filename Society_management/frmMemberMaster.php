<?php
// Establish a single database connection
$conn = mysqli_connect("localhost", "root", "", "housingsociety");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    // Generate the next Member ID
    $sql = "SELECT MAX(MID) AS MaxID FROM MemberMaster";
    $result = mysqli_query($conn, $sql);
    $newId = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newId = $row['MaxID'] + 1; // Increment the max ID
    }

    echo "<script>document.getElementById('memberId').value = '$newId';</script>";
}

// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    // Insert data into MemberMaster table
    $id = $_POST["txtMId"];
    $name = $_POST["txtMName"];
    $aadhar = $_POST["txtAadharNo"];
    $flat = $_POST["txtFlatNo"];
    $contact = $_POST["txtContactNo"];
    $area = $_POST["txtArea"];
    $regId = $_POST["txtRegId"];
    $regDate = $_POST["txtRegDate"];
    $checkedBy = $_POST["txtCheckedBy"];

    // Check if all fields are filled
    if ($id != NULL && $name != NULL && $aadhar != NULL && $flat != NULL && $contact != NULL && $area != NULL && $regId != NULL && $regDate != NULL && $checkedBy != NULL) {
        
        $sql = "INSERT INTO MemberMaster (MID, MName, AadharNo, FlatNo, ContactNo, AreaSqFeet, RegID, RegDate, CheckedBy) 
                VALUES ($id, '$name', '$aadhar', '$flat', '$contact', $area, '$regId', '$regDate', '$checkedBy')";
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
    $flat = $_POST["txtFlatNo"];
    $contact = $_POST["txtContactNo"];
    $area = $_POST["txtArea"];
    $regId = $_POST["txtRegId"];
    $regDate = $_POST["txtRegDate"];
    $checkedBy = $_POST["txtCheckedBy"];

    // Check if all fields are filled
    if ($id != NULL) {

        // Update query
        $sql = "UPDATE MemberMaster 
                SET MName='$name', AadharNo='$aadhar', FlatNo='$flat', ContactNo='$contact', 
                    AreaSqFeet=$area, RegID='$regId', RegDate='$regDate', CheckedBy='$checkedBy' 
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
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Function to display all data in the MemberMaster table
function showData($conn)
{
    $sql = "SELECT * FROM MemberMaster";
    $r = mysqli_query($conn, $sql);

    echo "<table border='1' class='table table-dark table-striped'><thead>
          <tr><th>Member ID</th><th>Member Name</th><th>Aadhar Number</th><th>Flat Number</th>
          <th>Contact Number</th><th>Area (Sq Feet)</th><th>Registration ID</th><th>Registration Date</th><th>Checked By</th></tr></thead><tbody>";

    if (mysqli_num_rows($r) > 0) {
        while ($x = mysqli_fetch_assoc($r)) {
            echo "<tr>
                  <td>" . $x['MID'] . "</td>
                  <td>" . $x['MName'] . "</td>
                  <td>" . $x['AadharNo'] . "</td>
                  <td>" . $x['FlatNo'] . "</td>
                  <td>" . $x['ContactNo'] . "</td>
                  <td>" . $x['AreaSqFeet'] . "</td>
                  <td>" . $x['RegID'] . "</td>
                  <td>" . $x['RegDate'] . "</td>
                  <td>" . $x['CheckedBy'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No records found in MemberMaster table</td></tr>";
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

   
   

    <?php
        include('header.php');
    ?>
    <link rel="stylesheet" href="css/styleMaster.css">

  

</head>
<body>

   
<div class="member-master-page">
    <div class="form-container">
        <h2 class="text-center mb-4">Member Master</h2>
        <form method="post">
            <!-- Member ID -->
            <div class="mb-3 row align-items-center">
                <label for="memberId" class="form-label col-form-label">Member ID: </label> 
                <div class="col">
                <input type="text" class="form-control" id="memberId" name="txtMId" 
                    value="<?php echo isset($_POST['btnNew']) ? $newId : ''; ?>" placeholder="Enter Member ID">
                </div>
                <div class="col-auto">
                    <button type="submit" name="btnNew" class="btn btn-primary">New</button>
                </div>
            </div>

            <!-- Member Name -->
            <div class="mb-3 row align-items-center">
                <label for="memberName" class="form-label col-form-label">Member Name:</label>
                <div class="col">
                    <input type="text" class="form-control" id="memberName" name="txtMName" placeholder="Enter Member Name">
                </div>
            </div>

            <!-- Aadhar Number -->
            <div class="mb-3 row align-items-center">
                <label for="aadharNo" class="form-label col-form-label">Aadhar Number:</label>
                <div class="col">
                    <input type="text" class="form-control" id="aadharNo" name="txtAadharNo" placeholder="Enter Aadhar Number">
                </div>
            </div>

            <!-- Flat Number -->
            <div class="mb-3 row align-items-center">
                <label for="flatNo" class="form-label col-form-label">Flat Number:</label>
                <div class="col">
                    <select class="form-select" id="flatNo" name="txtFlatNo">
                        <option value="" disabled selected style="color: #aaa;">Select Flat Number</option>
                        <option value="101">101</option>
                        <option value="102">102</option>
                        <option value="103">103</option>
                        <!-- Add more options as required -->
                    </select>
                </div>
            </div>

            <!-- Contact Number -->
            <div class="mb-3 row align-items-center">
                <label for="contactNo" class="form-label col-form-label">Contact Number:</label>
                <div class="col">
                    <input type="text" class="form-control" id="contactNo" name="txtContactNo" placeholder="Enter Contact Number">
                </div>
            </div>

            <!-- Area (Sq Feet) -->
            <div class="mb-3 row align-items-center">
                <label for="area" class="form-label col-form-label">Area (Sq Feet):</label>
                <div class="col">
                    <input type="text" class="form-control" id="area" name="txtArea" placeholder="Enter Area in Sq Feet">
                </div>
            </div>

            <!-- Registration ID -->
            <div class="mb-3 row align-items-center">
                <label for="registrationId" class="form-label col-form-label">Registration ID:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <div class="col">
                    <input type="text" class="form-control" id="registrationId" name="txtRegId" placeholder="Enter Registration ID">
                </div>
            </div>

            <!-- Registration Date -->
            <div class="mb-3 row align-items-center">
                <label for="registrationDate" class="form-label col-form-label">Registration Date:</label>
                <div class="col">
                    <input type="date" class="form-control" id="registrationDate" name="txtRegDate">
                </div>
            </div>

            <!-- Checked By -->
            <div class="mb-3 row align-items-center">
                <label for="checkedBy" class="form-label col-form-label">Checked By:</label>
                <div class="col">
                    <select class="form-select" id="checkedBy" name="txtCheckedBy">
                        <option value="" disabled selected>Select Checker</option>
                        <option value="Manager">Manager</option>
                        <option value="Supervisor">Supervisor</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>

             <!-- Buttons -->
             <div class="row mt-4">
                <div class="col-11 text-center">
                    <button type="submit" name="btnAdd" class="btn btn-success">Add</button>
                    <button type="submit" name="btnUpdate" class="btn btn-warning mx-2">Update</button>
                    <button type="submit" name="btnDelete" class="btn btn-danger mx-2">Delete</button>
                    <button type="reset"  name="btnCancel" class="btn btn-secondary mx-2">Cancel</button>
                </div>
            </div>
        </form>
        
        <!-- Table Wrapper -->
        <div class="table-wrapper">
            <!-- Show data -->
            <h3 class="mt-4">Member Records</h3>
            <?php showData($conn); ?>
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