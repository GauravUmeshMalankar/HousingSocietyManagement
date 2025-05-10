<?php
session_start();
require('db.php'); // Include your database connection file



if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php");
    exit();
}

$stmt = $conn->prepare("SELECT user_type FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user || $user['user_type'] !== 'admin') {
    session_destroy();
    echo "<script>alert('Access Denied! Only Admins can access this page.'); window.location.href='Login1/login.php';</script>";
    exit();
}


// Fetch total members
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM membermaster");
$memberCount = mysqli_fetch_assoc($result)['total'];

// Fetch total maintenance entries
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM maintenance");
$maintenanceCount = mysqli_fetch_assoc($result)['total'];


// Fetch Maintenance Collected
$result = mysqli_query($conn, "SELECT SUM(amount) AS sum FROM maintenance");
$totalMaintenanceCollected  = mysqli_fetch_assoc($result)['sum'] ?? 0;

// Fetch Society Fund
$result = mysqli_query($conn, "SELECT SUM(amount) AS total FROM maintenance");
$societyFund = mysqli_fetch_assoc($result)['total'] ?? 0;

// Fetch Fine Members
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM fine");
$fineCount = mysqli_fetch_assoc($result)['total'];

// Fetch Fine Collected
$result = mysqli_query($conn, "SELECT SUM(FAmount) AS sum FROM fine");
$finescollected = mysqli_fetch_assoc($result)['sum'] ?? 0;


// Query to find dues
$sql = "SELECT COUNT(MID) AS DueMembers
        FROM maintenance 
        WHERE BDate IS NULL"; // Adjust based on your logic

$sql = "SELECT m.MID, m.MName
FROM membermaster m
LEFT JOIN maintenance ma 
    ON m.MID = ma.MID 
    AND ma.SDate BETWEEN '2024-10-01' AND '2024-10-31'
WHERE ma.MID IS NULL";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$Dues = $row['DueMembers'] ?? 0; 

// Fetch Data for Overview Boxes

$committeeMembers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM committeemaster"))['count'];
$totalElections = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM electiondetails"))['count'];
$upcomingAnnouncement = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM announcement WHERE created_at "))['count'];
$upcomingEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM events WHERE event_date >= CURDATE()"))['count'];
$upcomingMeetings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM monthlymeeting WHERE MDate "))['count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php include('Sidebar.php')?>;
    <link rel="stylesheet" href="css/styleMaster.css">
    <style>
        /* Navbar Styling */
        .navbar {
            margin-left: 240px;
            background-color: black;
            padding: 9px;
            text-align: center;
    
            color: white;
            font-size: 24px;
            font-weight: bold;
            position: fixed;
            top: 0;
            width: calc(100% - 240px);
            z-index: 1030;
        }
      
        .navbar .navbar-brand {
            color: #fff !important; 
        }

        /* Overview Boxes */
        .overview-boxes {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            margin-left: 240px; /* Adjust for sidebar */
            margin-top: 80px;
        }

        .box {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .box:hover {
            transform: translateY(-5px);
        }

        .box-topic {
            font-size: 18px;
            font-weight: bold;
        }

        .number {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .icon {
            font-size: 40px;
            color:black;
        }

        .box-link {
        text-decoration: none; /* Remove underline */
        color: inherit; /* Inherit text color */
    }

    .box-link .box {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .box-link .box:hover {
        transform: scale(1.05); /* Slight zoom effect */
        box-shadow: 0 0 15px rgba(255, 0, 0, 0.5); /* Red glow effect */
    }
        </style>
</head>

<body class="bg-light">



<div class="navbar navbar-expand-lg px-3">
 <span class="navbar-brand">Admin Dashboard</span>

    <div class="ms-auto">
        <?php
            include 'AdminDropDown.php';
        ?>
    </div>
</div>

 <!-- Overview Boxes -->
 <div class="overview-boxes">
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Total Members</div>
                <div class="number"><?php echo $memberCount; ?></div>
            </div>
            <i class="fas fa-users icon"></i>
        </div>

        
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Total Committee Members</div>
                <div class="number"><?php echo $committeeMembers; ?></div>
            </div>
            <i class="fas fa-users-cog icon"></i>
        </div>

        <div class="box">
            <div class="right-side">
                <div class="box-topic">Total Elections Conducted</div>
                <div class="number"><?php echo $totalElections; ?></div>
            </div>
            <i class="fas fa-vote-yea icon"></i>
        </div>

        <a href="frmEvent.php" class="box-link">
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Upcoming Society Events</div>
                    <div class="number"><?php echo $upcomingEvents; ?></div>
                </div>
                <i class="fas fa-calendar-alt icon"></i>
            </div>
        </a>
        
        <a href="frmHistory.php" class="box-link">
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Total Maintenance Records</div>
                    <div class="number"><?php echo $maintenanceCount; ?></div>
                </div>
                <i class="fas fa-tools icon"></i>
            </div>
        </a>


        <div class="box">
            <div class="right-side">
                <div class="box-topic">Total Maintenance Collected</div>
                <div class="number">₹<?php echo number_format($totalMaintenanceCollected, 2); ?></div>
            </div>
            <i class="fas fa-hand-holding-usd icon"></i>
        </div>

        <a href="frmMaintenanceDue.php" class="box-link">
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Maintenance dues form  Members</div>
                    <div class="number" style="visibility: hidden;"><?php echo $Dues; ?></div> 
                </div>
                <i class="fas fa-hand-holding-usd icon"></i>
            </div>
        </a>
        
       
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Society Fund</div>
                <div class="number">₹<?php echo number_format($societyFund, 2); ?></div>
            </div>
            <i class="fas fa-wallet icon"></i>
        </div>

    
        
        
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Society Announcement</div>
                <div class="number"><?php echo $upcomingAnnouncement; ?></div>
            </div>
            <i class="fas fa-calendar-alt icon"></i>
        </div>



        <div class="box">
            <div class="right-side">
                <div class="box-topic">Total Meetings </div>
                <div class="number"><?php echo $upcomingMeetings; ?></div>
            </div>
            <i class="fas fa-chart-line  icon"></i>
        </div>

        <div class="box">
            <div class="right-side">
                <div class="box-topic">Fines</div>
                <div class="number"><?php echo $fineCount; ?></div>
            </div>
            <i class="fas fa-file-invoice icon"></i>
        </div>

        <div class="box">
            <div class="right-side">
                <div class="box-topic">Total Fines Collected</div>
                <div class="number">₹<?php echo number_format($finescollected , 2); ?></div>
            </div>
            <i class="fas fa-file-invoice-dollar icon"></i>
        </div>


        <a href="frmGenerateReports.php" class="box-link">
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Generate Reports</div>
                    <div class="number" style="visibility: hidden;"><?php echo $Dues; ?></div> 
                </div>
                <i class="fas fa-file-alt icon"></i>
            </div>
        </a>



   
    
</div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>

</body>
</html>