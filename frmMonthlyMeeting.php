<?php
session_start();
include('db.php');

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php");
    exit();
}

//include('fpdf/pdfMonthlyMeeting.php');

if (isset($_POST["btnReport"])) {
    $meetId = $_POST["txtMeetId"];
    if (!empty($meetId)) {
        header("Location: fpdf/pdfMonthlyMeeting.php?MeetID=" . $meetId);
        exit();
    } else {
        echo "<script>alert('Please enter a Meeting ID');</script>";
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure PHPMailer is installed via Composer

if (isset($_POST['btnEmail'])) {
      try {
        // Get the Meeting ID from the form
        $meetingId = $_POST['txtMeetId'];

        if (empty($meetingId)) {
            throw new Exception("Please enter a Meeting ID.");
        }

        // Fetch the selected meeting details
        $stmt = $conn->prepare("SELECT * FROM monthlymeeting WHERE MeetID = ?");
        $stmt->bind_param("i", $meetingId);
        $stmt->execute();
        $meeting = $stmt->get_result()->fetch_assoc();

        if (!$meeting) {
            throw new Exception("No meeting found with ID: " . $meetingId);
        }


        // Fetch all society members' emails
        $stmt = $conn->prepare("SELECT Email, MName FROM MemberMaster"); 
        $stmt->execute();
        $members = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        if (!$members) {
            throw new Exception("No members found.");
        }

        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username =  // Your SMTP username
        $mail->Password = // Your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('no-reply@yourdomain.com', 'Society Management');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Monthly Society Meeting Notice";
        $mail->Body = "
            <p>Dear Member,</p>
            <p>You are invited to the monthly society meeting.</p>
            <p><strong>Meeting Date:</strong> {$meeting['MDate']}</p>
            <p><strong>Notice Issued By:</strong> {$meeting['NoticeIssuedBy']}</p>
            <p><strong>Agenda/Meeting Reason:</strong>({$meeting['Designation']}) </p>
     
            <p>Best Regards,<br>HMS</p>
        ";

        // Send email to each member
        foreach ($members as $member) {
            $mail->addAddress($member['Email'], $member['MName']);
            $mail->send();
            $mail->clearAddresses(); 
        }

        echo "<script>alert('Monthly meeting email sent successfully!');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Functionality when 'New' button is clicked
if (isset($_POST["btnNew"])) {
    
    $sql = "SELECT MAX(MeetID) AS MaxID FROM MonthlyMeeting";
    $result = mysqli_query($conn, $sql);
    $newId = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newId = $row['MaxID'] + 1;
    }

    echo "<script>document.getElementById('MeetId').value = '$newId';</script>";
}

// Functionality when 'Add' button is clicked
if (isset($_POST["btnAdd"])) {
    $meetId = $_POST["txtMeetId"];
    $mDate = $_POST["txtMDate"];
    $nDate = $_POST["txtNDate"];
    $noticeBy = $_POST["txtNotice"] ?? "";
    $designation = $_POST["txtDesignation"]; // Reason for meeting
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

    if ($meetId && $mDate && $nDate && $noticeBy && $designation) {
        $sql = "INSERT INTO MonthlyMeeting (MeetID, MDate, NDate, NoticeIssuedBy, Designation, AgendaPhotoPath) 
                VALUES ('$meetId', '$mDate', '$nDate', '$noticeBy', '$designation', '$agendaPhoto')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Meeting details added successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!');</script>";
    }
}

// Functionality when 'Update' button is clicked
if (isset($_POST["btnUpdate"])) {
    $meetId = $_POST["txtMeetId"];
    $mDate = $_POST["txtMDate"];
    $nDate = $_POST["txtNDate"];
    $noticeBy = $_POST["txtNotice"] ?? "";
    $designation = $_POST["txtDesignation"]; // Meeting Reason
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

    if ($meetId && $mDate && $nDate && $noticeBy && $designation) {
        $sql = "UPDATE MonthlyMeeting 
                SET MDate='$mDate', NDate='$nDate', NoticeIssuedBy='$noticeBy', Designation='$designation'";

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
        echo "<script>alert('Fill all fields!');</script>";
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




// Update showData function to display Designation
function showData($conn)
{
    $sql = "SELECT * FROM MonthlyMeeting";
    $result = mysqli_query($conn, $sql);

    echo "<table border='1' class='table table-dark table-striped'><thead>
          <tr><th>Meeting ID</th><th>Date of Meeting</th><th>Notice Date</th><th>Issued By</th><th>Reason</th><th>Agenda Photo</th></tr></thead><tbody>";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                  <td>" . $row['MeetID'] . "</td>
                  <td>" . $row['MDate'] . "</td>
                  <td>" . $row['NDate'] . "</td>
                  <td>" . $row['NoticeIssuedBy'] . "</td>
                  <td>" . $row['Designation'] . "</td>
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
        echo "<tr><td colspan='6'>No records found in MonthlyMeeting table</td></tr>";
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
    <?php include('Sidebar.php'); ?>
    <link rel="stylesheet" href="css/styleMaster.css">
   
   
</head>
<body>
<div class="home-section">
      <!-- Navbar -->
      <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Monthly Meeting</h1>
        <?php
            include 'AdminDropDown.php';
        ?>
      </nav>
    <div class="member-master-page">
        <div class="form-container">
            <h2 class="text-center mb-4">Monthly Meeting Form</h2>
            <form method="post" action="" enctype="multipart/form-data">
                <!-- Meeting ID -->
                <div class="row form-row align-items-center">
                    <label for="meetingId" class="col-sm-3 col-form-label text-end">Meeting ID:</label>
                    <div class="col-sm-6 d-flex">
                        <input type="number" class="form-control me-2" id="meetingId" name="txtMeetId"
                        value="<?php echo isset($_POST['btnNew']) ? $newId : ''; ?>" placeholder="Enter Meeting ID">
                        <button type="submit" name="btnNew" class="btn btn-primary  me-2">New</button>
                        <button type="submit" name="btnEmail" class="btn btn-secondary" style="min-width: 120px; white-space: nowrap;">Send Email</button>
                        
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


                <!-- Member Name -->
                <div class="row form-row align-items-center mt-2">
                <label for="noticeBy" class="col-sm-8 col-form-label text-end">Notice Issued By:</label>
                    <div class="col-sm-6 d-flex">
                        <select class="form-select me-2" id="noticeBy" name="txtNotice">
                            <option value="" disabled selected class="placholder option">Select Issuer</option>
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

                <!-- Reason -->
                <div class="row form-row">
                    <label for="designation" class="col-sm-3 col-form-label text-end">Reason:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="designation" name="txtDesignation" placeholder="Enter Reason">

                    
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
                    <div class="col-12 d-flex justify-content-center flex-wrap gap-4">
                        <button type="submit" name="btnAdd" class="btn btn-success">Add</button>
                        <button type="submit" name="btnUpdate" class="btn btn-warning">Update</button>
                        <button type="submit" name="btnDelete" class="btn btn-danger">Delete</button>
                        <button type="submit" name="btnCancel" class="btn btn-secondary" onclick="resetPreview()">Cancel</button>
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
                        echo '<h3 class="mt-4">Meeting Records</h3>';
                        showData($conn);
                    }
                ?>
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
    </div>
</div>
  
</body>
</html>
<?php
// Close the database connection at the end of the script
mysqli_close($conn);
?>
