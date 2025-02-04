<?php
// Establish a single database connection
$conn = mysqli_connect("localhost", "root", "", "housingsociety");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    // Generate the next Fine ID
    $sql = "SELECT MAX(FID) AS MaxID FROM Fine";
    $result = mysqli_query($conn, $sql);
    $newId = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newId = $row['MaxID'] + 1; // Increment the max ID
    }

    echo "<script>document.getElementById('FineId').value = '$newId';</script>";
}

// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    $fid = $_POST["txtFId"];
    $mid = $_POST["txtMId"];
    $famount = $_POST["txtFAmount"];
    $details = $_POST["txtDetails"];

    // Check if all fields are filled
    if ($fid != NULL && $mid != NULL && $famount != NULL && $details != NULL) {
        $sql = "INSERT INTO Fine (FID, MID, FAmount, Details) 
                VALUES ('$fid', '$mid', '$famount', '$details')";
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
    $mid = $_POST["txtMId"];
    $famount = $_POST["txtFAmount"];
    $details = $_POST["txtDetails"];

    // Check if Fine ID is provided
    if ($fid != NULL) {
        // Update query
        $sql = "UPDATE Fine 
                SET MID='$mid', FAmount='$famount', Details='$details' 
                WHERE FID='$fid'";
        
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Fine details updated successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fine ID is required!');</script>";
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
          <tr><th>Fine ID</th><th>Member ID</th><th>Fine Amount</th><th>Details</th></tr></thead><tbody>";

    if (mysqli_num_rows($r) > 0) {
        while ($x = mysqli_fetch_assoc($r)) {
            echo "<tr>
                  <td>" . $x['FID'] . "</td>
                  <td>" . $x['MID'] . "</td>
                  <td>" . $x['FAmount'] . "</td>
                  <td>" . $x['Details'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No records found in Fine table</td></tr>";
    }
    echo "</tbody></table>";
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
    <?php
        include('header.php');
    ?>
    <link rel="stylesheet" href="css/styleMaster.css">

</head>
<body>
<div class="member-master-page">
    <div class="form-container">
            <h2 class="text-center mb-4">Fine Form</h2>
            <form method="post" action="">
                <!-- Fine ID -->
                <div class="row form-row">
                    <label for="fineId" class="col-sm-3 col-form-label text-end">Fine ID:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="fineId" name="txtFId" 
                        value="<?php echo isset($_POST['btnNew']) ? $newId : ''; ?>" placeholder="Enter Fine ID">
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
                        <button type="button" class="btn btn-primary">Search</button>
                    </div>
                </div>

                <!-- Fine Amount -->
                <div class="row form-row">
                    <label for="fineAmount" class="col-sm-3 col-form-label text-end">Fine Amount:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="fineAmount" name="txtFAmount" placeholder="Enter Fine Amount">
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