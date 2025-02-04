<?php
// Establish a single database connection
$conn = mysqli_connect("localhost", "root", "", "housingsociety");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
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
    $secretary = $_POST["txtSecretary"];
    $chairman = $_POST["txtChairman"];
    $pStartDate = $_POST["txtPStartDate"];
    $pEndDate = $_POST["txtPEndDate"];
    $cMembers = $_POST["txtCMembers"];

    // Check if all fields are filled
    if ($id != NULL && $date != NULL && $secretary != NULL && $chairman != NULL && $pStartDate != NULL && $pEndDate != NULL && $cMembers != NULL) {
        $sql = "INSERT INTO ElectionDetails (EID, EDate, NSecreatary, Chairman, PStartDate, PEndDate, CMembers) 
                VALUES ($id, '$date', '$secretary', '$chairman', '$pStartDate', '$pEndDate', '$cMembers')";
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
    $secretary = $_POST["txtSecretary"];
    $chairman = $_POST["txtChairman"];
    $pStartDate = $_POST["txtPStartDate"];
    $pEndDate = $_POST["txtPEndDate"];
    $cMembers = $_POST["txtCMembers"];

    // Check if Election ID is provided
    if ($id != NULL) {
        $sql = "UPDATE ElectionDetails 
                SET EDate='$date', NSecreatary='$secretary', Chairman='$chairman', 
                    PStartDate='$pStartDate', PEndDate='$pEndDate', CMembers='$cMembers' 
                WHERE EID=$id";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Election record updated successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Election ID is required!');</script>";
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
          <th>Period Start Date</th><th>Period End Date</th><th>Committee Members</th></tr></thead><tbody>";

    if (mysqli_num_rows($r) > 0) {
        while ($x = mysqli_fetch_assoc($r)) {
            echo "<tr>
                  <td>" . $x['EID'] . "</td>
                  <td>" . $x['EDate'] . "</td>
                  <td>" . $x['NSecreatary'] . "</td>
                  <td>" . $x['Chairman'] . "</td>
                  <td>" . $x['PStartDate'] . "</td>
                  <td>" . $x['PEndDate'] . "</td>
                  <td>" . $x['CMembers'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No records found in ElectionDetails table</td></tr>";
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
        include('header.php');
    ?>
    <link rel="stylesheet" href="css/styleMaster.css">
   
</head>
<body>
<div class="member-master-page">
    <div class="form-container">

        <h2 class="text-center mb-4">Election Details</h2>
        <form method="post" action="">
            <!-- Election ID -->
            <div class="row form-row">
                <label for="electionId" class="col-sm-3 col-form-label text-end">Election ID:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="electionId" name="txtEId"
                     value="<?php echo isset($_POST['btnNew']) ? $newId : ''; ?>" placeholder="Enter Election ID">
                </div>
                <div class="col-sm-3">
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

            <!-- Notice By Secretary -->
            <div class="row form-row">
                <label for="noticeBySecretary" class="col-sm-3 col-form-label text-end">Notice By Secretary:</label>
                <div class="col-sm-6">
                    <select class="form-select" id="noticeBySecretary" name="txtSecretary">
                        <option value="" disabled selected>Select Secretary</option>
                        <option value="Secretary1">Secretary 1</option>
                        <option value="Secretary2">Secretary 2</option>
                        <option value="Secretary3">Secretary 3</option>
                    </select>
                </div>
            </div>

            <!-- Chairman -->
            <div class="row form-row">
                <label for="chairman" class="col-sm-3 col-form-label text-end">Chairman:</label>
                <div class="col-sm-6">
                    <select class="form-select" id="chairman" name="txtChairman">
                        <option value="" disabled selected>Select Chairman</option>
                        <option value="Chairman1">Chairman 1</option>
                        <option value="Chairman2">Chairman 2</option>
                        <option value="Chairman3">Chairman 3</option>
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

            <!-- Committee Members -->
            <div class="row form-row">
                <label for="committeeMembers" class="col-sm-3 col-form-label text-end">Commitee Members:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="committeeMembers" name="txtCMembers" rows="3" placeholder="Enter Committee Members"></textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="submit" name="btnAdd" class="btn btn-success mx-2">Add</button>
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