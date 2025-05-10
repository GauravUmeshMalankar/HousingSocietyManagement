<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Dues</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include('Sidebar.php'); ?>
    <link rel="stylesheet" href="css/styleMaster.css">
</head>
<body>
<div class="home-section">
    <nav class="custom-navbar d-flex justify-content-between align-items-center">
        <h1>Maintenance Due</h1>
        <?php include 'AdminDropDown.php'; ?>
    </nav>
    
    <div class="member-master-page">
        <div class="form-container">
            <h3 class="text-center mb-4">Maintenance Dues Form Member</h3>
            <form method="post" action="">


                <div class="row form-row align-items-center mb-3">
                    <label for="memberName" class="col-sm-4 col-form-label text-end"> Member Name:</label>
                    <div class="col-sm-8 d-flex">
                        <input type="text" class="form-control me-2" id="memberName" name="memberName" placeholder="Enter Member Name" >
          
                        <button type="submit" name="btnCheckDueByName" class="btn btn-primary">Check Dues</button>
                    </div>
                </div>


           
                <?php
                    if (isset($_POST['btnCheckDueByName'])) {
                        include 'db.php';
                        $memberNameInput = trim($_POST['memberName']);
                        $defaultAmount = 1640;

                        // Step 1: Search for member by name
                        $stmt = $conn->prepare("SELECT MID, MName FROM membermaster WHERE MName LIKE ?");
                        $likeName = "%" . $memberNameInput . "%";
                        $stmt->bind_param("s", $likeName);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows === 0) {
                            echo '<p class="mt-4 text-danger text-center">No member found with that name.</p>';
                        } else {
                            while ($member = $result->fetch_assoc()) {
                                $mid = $member['MID'];
                                $mname = $member['MName'];

                                echo "<h4 class='mt-4'>Unpaid Dues for <strong>{$mname}</strong>:</h4>";

                                // Step 2: Get all months in the last 12 months
                                $allMonths = [];
                                for ($i = 0; $i < 6; $i++) {
                                    $month = date("Y-m", strtotime("-$i month")); // e.g., 2024-03
                                    $allMonths[] = $month;
                                }

                                // Step 3: Get months this member has paid for
                                $stmtPaid = $conn->prepare("SELECT DATE_FORMAT(SDate, '%Y-%m') AS PaidMonth FROM maintenance WHERE MID = ?");
                                $stmtPaid->bind_param("i", $mid);
                                $stmtPaid->execute();
                                $paidResult = $stmtPaid->get_result();

                                $paidMonths = [];
                                while ($row = $paidResult->fetch_assoc()) {
                                    $paidMonths[] = $row['PaidMonth'];
                                }

                                // Step 4: Find unpaid months
                                $unpaidMonths = array_diff($allMonths, $paidMonths);

                                if (count($unpaidMonths) > 0) {
                                    echo '<table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                    foreach ($unpaidMonths as $unpaidMonth) {
                                        $startDate = $unpaidMonth . "-01";
                                        $endDate = date("Y-m-t", strtotime($startDate));
                                        $monthName = date("F Y", strtotime($startDate));

                                        echo "<tr>
                                                <td>$monthName</td>
                                                <td>$startDate</td>
                                                <td>$endDate</td>
                                                <td>$defaultAmount</td>
                                            </tr>";
                                    }
                                    echo '</tbody></table>';
                                } else {
                                    echo '<p class="text-success">No dues! All maintenance is paid in the last 12 months.</p>';
                                }

                                $stmtPaid->close();
                            }
                        }

                        $stmt->close();
                        $conn->close();
                    }
                ?>
                <div class="row form-row align-items-center mb-3">
                    <label for="dueMonth" class="col-sm-3 col-form-label text-end">Select Month:</label>
                    <div class="col-sm-6 d-flex">
                        <input type="month" class="form-control me-2" id="dueMonth" name="dueMonth">

                        <button type="submit" name="btnCheckDue" class="btn btn-primary">Check Dues</button>
                    </div>
                </div>

                <div class="row form-row align-items-center justify-content-center mb-3">
                    <div class="col-sm-6 d-flex justify-content-center">
                        <button type="submit" name="btnCancel" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>

         
            </form>

            <?php
                if (isset($_POST['btnCheckDue'])) {
                    include 'db.php';
                    $selectedMonth = $_POST['dueMonth']; // YYYY-MM
                    $startDate = $selectedMonth . "-01"; // Convert to YYYY-MM-01
                    $endDate = date("Y-m-t", strtotime($startDate)); // Get last day of the month
                    $monthName = date("F", strtotime($startDate)); // Get month name
                    $defaultAmount = 1640; // Default amount for unpaid members

                    // Query: Find members who have NOT paid maintenance for the selected month
                    $queryNoMaintenance = "SELECT m.MID, m.MName  
                                           FROM MemberMaster m
                                           LEFT JOIN maintenance ma ON m.MID = ma.MID AND ma.SDate = ?
                                           WHERE ma.MID IS NULL";

                    $stmtNoMaintenance = $conn->prepare($queryNoMaintenance);
                    $stmtNoMaintenance->bind_param("s", $startDate);
                    $stmtNoMaintenance->execute();
                    $resultNoMaintenance = $stmtNoMaintenance->get_result();

                    if ($resultNoMaintenance->num_rows > 0) {
                        echo '<h3 class="mt-4">Maintenance Due</h3>';
                        echo '<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Member ID</th>
                                        <th>Member Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Month</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        while ($row = $resultNoMaintenance->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['MID']}</td>
                                    <td>{$row['MName']}</td>
                                    <td>{$startDate}</td>
                                    <td>{$endDate}</td>
                                    <td>{$monthName}</td>
                                    <td>{$defaultAmount}</td>
                                </tr>";
                        }
                        echo '</tbody></table>';
                    } else {
                        echo '<p class="mt-4 text-center text-success">All members have paid maintenance for the selected month.</p>';
                    }
                    $stmtNoMaintenance->close();
                    mysqli_close($conn);
                }
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
