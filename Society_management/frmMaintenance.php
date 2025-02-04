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
    $sql = "SELECT MAX(BNo) AS MaxID FROM Maintenance";
    $result = mysqli_query($conn, $sql);
    $newId = 1;

    if ($row = mysqli_fetch_assoc($result)) {
        $newId = $row['MaxID'] + 1; // Increment the max ID
    }

    echo "<script>document.getElementById('BillNo').value = '$newId';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housing Society Management - Maintenance</title>
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
        <h2 class="text-center mb-4">Maintenance Form</h2>
        <form method="post" action="">
            <!-- Bill No -->
            <div class="row form-row">
                <label for="billNo" class="col-sm-3 col-form-label text-end">Bill No:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="billNo" name="txtBNo"
                     value="<?php echo isset($_POST['btnNew']) ? $newId : ''; ?>" placeholder="Enter Bill No">
                </div>
                <div class="col-sm-3">
                    <button type="submit" name="btnNew" class="btn btn-primary">New</button>
                </div>
            </div>

            <!-- Date -->
            <div class="row form-row">
                <label for="date" class="col-sm-3 col-form-label text-end">Date:</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="date" name="txtDate">
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

            <!-- Name -->
            <div class="row form-row">
                <label for="name" class="col-sm-3 col-form-label text-end">Name:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="name" name="txtMName" placeholder="Name">
                </div>
            </div>

            <!-- Start Date -->
            <div class="row form-row">
                <label for="startDate" class="col-sm-3 col-form-label text-end">Start Date:</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="startDate" name="txtSDate">
                </div>
            </div>

            <!-- End Date -->
            <div class="row form-row">
                <label for="endDate" class="col-sm-3 col-form-label text-end">End Date:</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="endDate" name="txtEDate">
                </div>
            </div>

            <!-- Amount -->
            <div class="row form-row">
                <label for="amount" class="col-sm-3 col-form-label text-end">Amount:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="amount" name="txtAmount" placeholder="Amount">
                </div>
            </div>

            <!-- Bill Display -->
            <div class="row form-row">
                <label for="billDisplay" class="col-sm-3 col-form-label text-end">Bill:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="billDisplay" name="txtBillDisplay" rows="4" placeholder="Bill Details"></textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="row mt-4">
                <div class="col-11 text-center">
                    <button type="submit" name="btnPay" class="btn btn-success mx-2">Pay</button>
                    <button type="reset" name="btnCancel" class="btn btn-secondary mx-2">Cancel</button>
                </div>
            </div>
        </form>
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