<?php
session_start();



include 'db.php'; // Database connection

// Fetch total members
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM membermaster");
$memberCount = mysqli_fetch_assoc($result)['total'];

// Fetch total maintenance entries
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM maintenance");
$maintenanceCount = mysqli_fetch_assoc($result)['total'];

// Fetch Fine Members
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM fine");
$fineCount = mysqli_fetch_assoc($result)['total'];

// Fetch total complaints
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM complaints");
$complaintCount = mysqli_fetch_assoc($result)['total'];


// Fetch latest announcements
$announcementQuery = mysqli_query($conn, "SELECT * FROM announcement ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add CSS file for styling -->
</head>
<body>
    <header>
        <h2>Society Management - Admin Dashboard</h2>
   
    </header>

    <div class="overview-boxes">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total members</div>
                        <div class="number"><?php echo $memberCount ?></div>
                        </div>
                    <i class='bx bxs-user icon member'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Maintenance Records </div>
                        <div class="number"><?php echo $maintenanceCount ?></div>
                    </div>
                    <i class='bx bxs-user-circle  icon staff'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Society fund</div>
                 
                        <div class="number"><?php echo $maintenanceCount?></div>

                    </div>
                    <i class='bx bx-money icon money'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Fines</div>
                        <div class="number"><?php echo $fineCount?></div>
                    </div>
                    <i class='bx bxs-file icon file'></i>
                    </div>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Complaints Bills</div>
                        <div class="number"><?php echo $complaintCount?></div>
                    </div>
                    <i class='bx bxs-file icon file'></i>
                </div>
            </div>

    <main>
        <section class="dashboard-stats">
            <div class="stat-box">
                <h3>Total Members</h3>
                <p><?php echo $memberCount; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Complaints</h3>
                <p><?php echo $complaintCount; ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Maintenance Records</h3>
                <p><?php echo $maintenanceCount; ?></p>
            </div>
        </section>

        <section class="latest-announcements">
            <h3>Latest Announcements</h3>
            <ul>
                <?php while ($row = mysqli_fetch_assoc($announcementQuery)) { ?>
                    <li><strong><?php echo $row['announcement_subject']; ?>:</strong> <?php echo $row['announcement_text']; ?></li>
                <?php } ?>
            </ul>
        </section>
    </main>
</body>
</html>

