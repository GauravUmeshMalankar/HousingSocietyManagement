<?php
session_start();
include('db.php');

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php");
    exit();
}

//include('fpdf/pdfFine.php');
if (isset($_POST["btnReport"])) {
    $fid = $_POST["txtFId"];
    if (!empty($fid)) {
        // Redirect to the same page with GET param
        header("Location: fpdf/pdfFine.php?FID=" . urlencode($fid));
        exit();
    } else {
        echo "<script>alert('Please enter a Fine ID');</script>";
    }
}

// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    // Generate the next Fine ID
    $sql = "SELECT MAX(FID) AS MaxID FROM Fine";
    $result = mysqli_query($conn, $sql);
    $newfineId = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newfineId = $row['MaxID'] + 1; // Increment the max ID
    }
    // Store the new ID in the session
    $_SESSION['newfineId'] = $newfineId;

  
}

// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    $fid = $_POST["txtFId"];
    $mid = $_POST["txtMId"] ?? "";
    $name = $_POST["txtMName"] ?? "";
    $famount = $_POST["txtFAmount"];
    $details = $_POST["txtDetails"];

    // Check if all fields are filled
    if ($fid != NULL && $mid != NULL && $name != NULL && $famount != NULL && $details != NULL) {
        $sql = "INSERT INTO Fine (FID, MID, MName, FAmount, Details) 
                VALUES ('$fid', '$mid', '$name', '$famount', '$details')";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Fine details added successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Functionality when 'Update' button is clicked
if (isset($_POST["btnUpdate"])) {
    $fid = $_POST["txtFId"];
    $mid = $_POST["txtMId"] ?? "";
    $name = $_POST["txtMName"] ?? "";
    $famount = $_POST["txtFAmount"];
    $details = $_POST["txtDetails"];

    // Check if Fine ID is provided
    if ($fid != NULL && $mid != NULL && $name != NULL && $famount != NULL && $details != NULL) {
        // Update query
        $sql = "UPDATE Fine 
                SET MID='$mid', MName='$name', FAmount='$famount', Details='$details' 
                WHERE FID='$fid'";
        
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Fine details updated successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Functionality when 'Delete' button is clicked
if (isset($_POST["btnDelete"])) {
    $fid = $_POST["txtFId"];

    // Check if Fine ID is provided
    if ($fid != NULL) {
        $sql = "DELETE FROM Fine WHERE FID='$fid'";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Fine details deleted successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fine ID is required!');</script>";
    }
}



// Function to display all data in the Fine table
function showData($conn)
{
    $sql = "SELECT * FROM Fine";
    $r = mysqli_query($conn, $sql);

    echo "<table border='1' class='table table-dark table-striped'><thead>
          <tr><th>Fine ID</th><th>Member ID</th><th>Member Name</th><th>Fine Amount</th><th>Details</th></tr></thead><tbody>";

    if (mysqli_num_rows($r) > 0) {
        while ($x = mysqli_fetch_assoc($r)) {
            echo "<tr>
                  <td>" . $x['FID'] . "</td>
                  <td>" . $x['MID'] . "</td>
                  <td>" . $x['MName'] . "</td>
                  <td>" . $x['FAmount'] . "</td>
                  <td>" . $x['Details'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No records found in Fine table</td></tr>";
    }
    echo "</tbody></table>";
}


if (isset($_POST["btnCancel"])) {
    $_SESSION['mid'] = "";
    $_SESSION['name'] = "";
    unset($_SESSION['newfineId']);
  
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
    <title>Housing Society Management - Fine Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('Sidebar.php'); ?>
    <link rel="stylesheet" href="css/styleMaster.css">

</head>
<body>
<div class = "home-section">
 
    <!-- Navbar -->

     <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Fine</h1>
        <?php
            include 'AdminDropDown.php';
        ?>
     </nav>


    <div class="member-master-page">
        <div class="form-container">
                <h2 class="text-center mb-4">Fine Form</h2>
                <form method="post">
                    <!-- Fine ID -->
                    <div class="row form-row align-items-center">
                        <label for="fineId" class="col-sm-3 col-form-label text-end">Fine ID:</label>
                        <div class="col-sm-6 d-flex">
                            <input type="number" class="form-control me-2" id="fineId" name="txtFId" 
                            value="<?php if(isset($_SESSION['newfineId'])) echo $_SESSION['newfineId']; ?>" placeholder="Enter Fine ID">
                            <button type="submit" name="btnNew" class="btn btn-primary">New</button>
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
                

                    <!-- Fine Amount -->
                    <div class="row form-row">
                        <label for="fineAmount" class="col-sm-3 col-form-label text-end">Fine Amount:</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="fineAmount" name="txtFAmount" placeholder="Enter Fine Amount" step="0.01">
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="row form-row">
                        <label for="details" class="col-sm-3 col-form-label text-end">Details:</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="details" name="txtDetails" rows="4" placeholder="Enter fine details"></textarea>
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
                        echo '<h3 class="mt-4">Fine Records</h3>';
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