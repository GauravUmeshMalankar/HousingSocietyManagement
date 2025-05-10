<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('Sidebar.php'); ?>
    <link rel="stylesheet" href="css/styleMaster.css">

</head>
<body>
<div class="home-section">
    <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Maintenance Records</h1>
        <?php include 'AdminDropDown.php'; ?>
    </nav>
    
    <div class="member-master-page">
        <div class="form-container">
            <h2 class="text-center mb-4">Maintenance History</h2>
            <form method="post">
                <div class="row form-row align-items-center">
                    <label for="memberId" class="col-sm-3 col-form-label text-end">Member ID:</label>
                    <div class="col-sm-8 d-flex">
                        <select class="form-select me-3" id="memberId" name="txtMId">
                            <option value="" disabled selected>Enter Member Id</option>
                            <?php
                                include 'db_connection.php';
                                $sql = "SELECT MID, MName FROM MemberMaster";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['MID']}'>{$row['MID']} - {$row['MName']}</option>";
                                }
                            ?>
                        </select>
                        <button type="submit" name="btnCheckDue" class="btn btn-primary">Check</button>
                    </div>
                </div>
            </form>
            
            <?php
                if (isset($_POST['btnCheckDue'])) {
                    $mid = $_POST['txtMId'];
                    $query = "SELECT * FROM maintenance WHERE MID = '$mid' AND Amount > 0";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        echo '<h3 class="mt-4">Maintenance Records</h3>';
                        echo '<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Bill No</th>
                                        <th>Member Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Month</th>
                                        <th>Amount</th>
                                        <th>Pay</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['BNo']}</td>
                                    <td>{$row['MName']}</td>
                                    <td>{$row['SDate']}</td>
                                    <td>{$row['EDate']}</td>
                                    <td>{$row['BDetails']}</td>
                                    <td>{$row['Amount']}</td>
                                    <td class='text-success fw-bold'>Paid</td>
                                   
                                </tr>";
                        }
                        echo '</tbody></table>';
                    } else {
                        echo '<p class="mt-4 text-center text-success">No outstanding maintenance dues.</p>';
                    }
                }
                mysqli_close($conn);
            ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
