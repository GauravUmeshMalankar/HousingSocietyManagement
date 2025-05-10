<?php 
session_start();
include('db.php');

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php");
    exit();
}

//include('fpdf/pdfElection.php');

if (isset($_POST["btnReport"])) {
    $eid = $_POST["txtEId"];
    if (!empty($eid)) {
        header("Location: fpdf/pdfElection.php?EID=" . $eid);
        exit();
    } else {
        echo "<script>alert('Please enter an Election ID');</script>";
    }
}

// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    // Generate the next Election ID
    $sql = "SELECT MAX(EID) AS MaxID FROM ElectionDetails";
    $result = mysqli_query($conn, $sql);
    $newId = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newId = $row['MaxID'] + 1; // Increment the max ID
    }

    echo "<script>document.getElementById('electionId').value = '$newId';</script>";
}

// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    $id = $_POST["txtEId"];
    $date = $_POST["txtEDate"];
    $secretary = $_POST["txtSecretary"] ?? "";
    $chairman = $_POST["txtChairman"] ?? "";
    $pStartDate = $_POST["txtPStartDate"];
    $pEndDate = $_POST["txtPEndDate"];
    $position = $_POST["txtPosition"] ?? "";
    $cMembers = $_POST["txtCMembers"];

    if ($id != NULL && $date != NULL && $secretary != NULL && $chairman != NULL && $pStartDate != NULL && $pEndDate != NULL && $position != NULL && $cMembers != NULL) {
        $sql = "INSERT INTO ElectionDetails (EID, EDate, NSecreatary, Chairman, PStartDate, PEndDate, EPosition, CMembers) 
                VALUES ($id, '$date', '$secretary', '$chairman', '$pStartDate', '$pEndDate', '$position', '$cMembers')";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Election record added successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}


// Functionality when 'Update' button is clicked
if (isset($_POST["btnUpdate"])) {
    $id = $_POST["txtEId"];
    $date = $_POST["txtEDate"];
    $secretary = $_POST["txtSecretary"] ?? "";
    $chairman = $_POST["txtChairman"] ?? "";
    $pStartDate = $_POST["txtPStartDate"];
    $pEndDate = $_POST["txtPEndDate"];
    $position = $_POST["txtPosition"] ?? "";
    $cMembers = $_POST["txtCMembers"];

    if ($id != NULL && $date != NULL && $secretary != NULL && $chairman != NULL && $pStartDate != NULL && $pEndDate != NULL && $position != NULL && $cMembers != NULL) {
        $sql = "UPDATE ElectionDetails 
                SET EDate='$date', NSecreatary='$secretary', Chairman='$chairman', 
                    PStartDate='$pStartDate', PEndDate='$pEndDate', EPosition='$position', CMembers='$cMembers'
                WHERE EID=$id";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Election record updated successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}


// Functionality when 'Delete' button is clicked
if (isset($_POST["btnDelete"])) {
    $id = $_POST["txtEId"];

    // Check if Election ID is provided
    if ($id != NULL) {
        $sql = "DELETE FROM ElectionDetails WHERE EID=$id";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Election record deleted successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Election ID is required!');</script>";
    }
}




// Function to display all data in the ElectionDetails table
function showData($conn)
{
    $sql = "SELECT * FROM ElectionDetails";
    $r = mysqli_query($conn, $sql);

    echo "<table border='1' class='table table-dark table-striped'><thead>
          <tr><th>Election ID</th><th>Date</th><th>Notice By Secretary</th><th>Chairman</th>
          <th>Period Start Date</th><th>Period End Date</th><th>Election Position</th><th>Committee Members</th></tr></thead><tbody>";

    if (mysqli_num_rows($r) > 0) {
        while ($x = mysqli_fetch_assoc($r)) {
            echo "<tr>
                  <td>" . $x['EID'] . "</td>
                  <td>" . $x['EDate'] . "</td>
                  <td>" . $x['NSecreatary'] . "</td>
                  <td>" . $x['Chairman'] . "</td>
                  <td>" . $x['PStartDate'] . "</td>
                  <td>" . $x['PEndDate'] . "</td>
                  <td>" . $x['EPosition'] . "</td>
                  <td>" . $x['CMembers'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No records found in ElectionDetails table</td></tr>";
    }
    echo "</tbody></table>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housing Society Management - Election Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php
        include('Sidebar.php');
    ?>
    <link rel="stylesheet" href="css/styleMaster.css">
   
</head>
<body>
<div class = "home-section">
      <!-- Navbar -->
      <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Election Details</h1>
        <?php
            include 'AdminDropDown.php';
        ?>
      </nav>
    <div class="member-master-page">
        <div class="form-container">

            <h2 class="text-center mb-4">Election Form</h2>
            <form method="post" action="">
                <!-- Election ID -->
                <div class="row form-row align-items-center">
                    <label for="electionId" class="col-sm-3 col-form-label text-end">Election ID:</label>
                    <div class="col-sm-6 d-flex">
                        <input type="number" class="form-control me-2" id="electionId" name="txtEId"
                        value="<?php echo isset($_POST['btnNew']) ? $newId : ''; ?>" placeholder="Enter Election ID">
                        <button type="submit" name="btnNew" class="btn btn-primary">New</button>
                    </div>
                </div>

                <!-- Date -->
                <div class="row form-row">
                    <label for="electionDate" class="col-sm-3 col-form-label text-end">Date:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="electionDate" name="txtEDate">
                    </div>
                </div>
                
                
                <!-- Notice By Secretary  -->
                <div class="row form-row align-items-center mt-2">
                <label for="noticeBySecretary" class="col-sm-8 col-form-label text-end">Notice By Secretary:</label>
                    <div class="col-sm-6 d-flex">
                        <select class="form-select me-2" id="noticeBySecretary" name="txtSecretary">
                            <option value="" disabled selected class="placholder option">Select Secretary</option>
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

                
                <!-- Chairman -->
                <div class="row form-row align-items-center mt-2">
                <label for="noticeBySecretary" class="col-sm-8 col-form-label text-end">Chairman:</label>
                    <div class="col-sm-6 d-flex">
                        <select class="form-select me-2" id="chairman" name="txtChairman">
                            <option value="" disabled selected class="placholder option">Select Chairman</option>
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
                

                <!-- Period Start Date -->
                <div class="row form-row">
                    <label for="periodStartDate" class="col-sm-3 col-form-label text-end">Period Start Date:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="periodStartDate" name="txtPStartDate">
                    </div>
                </div>

                <!-- Period End Date -->
                <div class="row form-row">
                    <label for="periodEndDate" class="col-sm-3 col-form-label text-end">Period End Date:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="periodEndDate" name="txtPEndDate">
                    </div>
                </div>
                
                <!-- Position -->
                <div class="row form-row align-items-center" >
                    <label for="position" class="col-sm-3 col-form-label text-end"> Election Position:</label>
                    <div class="col-sm-6">
                        <select class="form-select" id="Position" name="txtPosition">
                            <option value="" disabled selected>Select for which Position</option>
                            <option value="Chairman">Chairman</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Tresaury">Tresasury</option>
                            <option value="Manager">Manager</option>
                            <option value="Supervisor">Supervisor</option>
                        </select>
                    </div>
                </div>


                <!-- Committee Members -->
                <div class="row form-row">
                    <label for="committeeMembers" class="col-sm-3 col-form-label text-end">Commitee Members:</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="committeeMembers" name="txtCMembers" rows="3" placeholder="Enter Committee Members"></textarea>
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
                        echo '<h4 class="mt-4">Election Records</h4>';
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