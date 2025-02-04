<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "housingsociety");

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    // Generate the next Election ID
    $sql = "SELECT MAX(MeetID) AS MaxID FROM MonthlyMeeting";
    $result = mysqli_query($conn, $sql);
    $newId = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newId = $row['MaxID'] + 1; // Increment the max ID
    }

    echo "<script>document.getElementById('MeetId').value = '$newId';</script>";
}

// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    $meetId = $_POST["txtMeetId"];
    $mDate = $_POST["txtMDate"];
    $nDate = $_POST["txtNDate"];
    $noticeBy = $_POST["txtNotice"];
    $agendaPhoto = "";

    // Handle file upload
    if (isset($_FILES['agendaPhoto']) && $_FILES['agendaPhoto']['error'] == 0) {
        $uploadDir = "uploads/"; // Directory to save uploaded files
        $fileName = basename($_FILES["agendaPhoto"]["name"]);
        $targetFilePath = $uploadDir . $fileName;

        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES["agendaPhoto"]["tmp_name"], $targetFilePath)) {
            $agendaPhoto = $targetFilePath; // Save file path
        } else {
            echo "Error uploading agenda photo.";
        }
    }

    // Check if all fields are filled
    if ($meetId != NULL && $mDate != NULL && $nDate != NULL && $noticeBy != NULL) {
        $sql = "INSERT INTO MonthlyMeeting (MeetID, MDate, NDate, NoticeIssuedBy, AgendaPhotoPath) 
                VALUES ('$meetId', '$mDate', '$nDate', '$noticeBy', '$agendaPhoto')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Meeting details added successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}

// Functionality when 'Update' button is clicked
if (isset($_POST["btnUpdate"])) {
    $meetId = $_POST["txtMeetId"];
    $mDate = $_POST["txtMDate"];
    $nDate = $_POST["txtNDate"];
    $noticeBy = $_POST["txtNotice"];
    $agendaPhoto = "";

    // Handle file upload if a new file is provided
    if (isset($_FILES['agendaPhoto']) && $_FILES['agendaPhoto']['error'] == 0) {
        $uploadDir = "uploads/";
        $fileName = basename($_FILES["agendaPhoto"]["name"]);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["agendaPhoto"]["tmp_name"], $targetFilePath)) {
            $agendaPhoto = $targetFilePath;
        } else {
            echo "<script>alert('Error uploading agenda photo.');</script>";
        }
    }

    // Check if Meeting ID is provided
    if ($meetId != NULL) {
        // Update query
        $sql = "UPDATE MonthlyMeeting 
                SET MDate='$mDate', NDate='$nDate', NoticeIssuedBy='$noticeBy'";
        
        // Update agenda photo only if a new file is uploaded
        if (!empty($agendaPhoto)) {
            $sql .= ", AgendaPhotoPath='$agendaPhoto'";
        }

        $sql .= " WHERE MeetID='$meetId'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Meeting details updated successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Meeting ID is required!');</script>";
    }
}

// Functionality when 'Delete' button is clicked
if (isset($_POST["btnDelete"])) {
    $meetId = $_POST["txtMeetId"];

    // Check if Meeting ID is provided
    if ($meetId != NULL) {
        $sql = "DELETE FROM MonthlyMeeting WHERE MeetID='$meetId'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Meeting details deleted successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Meeting ID is required!');</script>";
    }
}

// Function to display all data in the MonthlyMeeting table
function showData($conn)
{
    $sql = "SELECT * FROM MonthlyMeeting";
    $result = mysqli_query($conn, $sql);

    echo "<table border='1' class='table table-dark table-striped'><thead>
          <tr><th>Meeting ID</th><th>Date of Meeting</th><th>Date of Notice</th><th>Notice Issued By</th><th>Agenda Photo</th></tr></thead><tbody>";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                  <td>" . $row['MeetID'] . "</td>
                  <td>" . $row['MDate'] . "</td>
                  <td>" . $row['NDate'] . "</td>
                  <td>" . $row['NoticeIssuedBy'] . "</td>
                  <td>";
            if (!empty($row['AgendaPhotoPath'])) {
                echo "<img src='" . $row['AgendaPhotoPath'] . "' alt='Agenda Photo' style='width:100px; height:auto;'>";
            } else {
                echo "No photo uploaded";
            }
            echo "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No records found in MonthlyMeeting table</td></tr>";
    }
    echo "</tbody></table>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housing Society Management - Monthly Meeting</title>
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
        <h2 class="text-center mb-4">Monthly Meeting Form</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <!-- Meeting ID -->
            <div class="row form-row">
                <label for="meetingId" class="col-sm-3 col-form-label text-end">Meeting ID:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="meetingId" name="txtMeetId"
                    value="<?php echo isset($_POST['btnNew']) ? $newId : ''; ?>" placeholder="Enter Meeting ID">
                </div>
                <div class="col-sm-3">
                    <button type="submit" name="btnNew" class="btn btn-primary">New</button>
                </div>
            </div>

            <!-- Date of Meeting -->
            <div class="row form-row">
                <label for="meetingDate" class="col-sm-3 col-form-label text-end">Date of Meeting:</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="meetingDate" name="txtMDate">
                </div>
            </div>

            <!-- Date of Notice -->
            <div class="row form-row">
                <label for="noticeDate" class="col-sm-3 col-form-label text-end">Date of Notice:</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="noticeDate" name="txtNDate">
                </div>
            </div>

            <!-- Notice Issued By -->
            <div class="row form-row">
                <label for="noticeBy" class="col-sm-3 col-form-label text-end">Notice Issued By:</label>
                <div class="col-sm-6">
                    <select class="form-select" id="noticeBy" name="txtNotice">
                        <option value="" disabled selected>Select Issuer</option>
                        <option value="Secretary1">Secretary 1</option>
                        <option value="Secretary2">Secretary 2</option>
                        <option value="Secretary3">Secretary 3</option>
                    </select>
                </div>
            </div>

            <!-- Agenda Photo -->
            <div class="row form-row">
                <label for="agendaPhoto" class="col-sm-3 col-form-label text-end">Agenda Photo:</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" id="agendaPhoto" name="agendaPhoto" accept="image/*" onchange="previewImage(event)">
                </div>
            </div>

            <!-- Agenda Photo Preview -->
            <div class="row form-row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <img id="agendaPreview" src="#" alt="Agenda Preview" style="display: none;">
                </div>
            </div>

            <!-- Buttons -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="submit" name="btnAdd" class="btn btn-success mx-2">Add</button>
                    <button type="submit" name="btnUpdate" class="btn btn-warning mx-2">Update</button>
                    <button type="submit" name="btnDelete" class="btn btn-danger mx-2">Delete</button>
                    <button type="reset"  name="btnCancel" class="btn btn-secondary mx-2" onclick="resetPreview()">Cancel</button>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(event) {
            const fileInput = event.target;
            const preview = document.getElementById('agendaPreview');
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        function resetPreview() {
            const preview = document.getElementById('agendaPreview');
            preview.src = '#';
            preview.style.display = 'none';
        }
    </script>
</div>
     <?php
        include('footer.php');
    ?>
</body>
</html>
<?php
// Close the database connection at the end of the script
mysqli_close($conn);
?>
