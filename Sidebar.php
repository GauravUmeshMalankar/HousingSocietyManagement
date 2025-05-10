
    <title>Sidebar</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/stylehp.css">





<div class="sidebar">
    <div class="sidebar-container" id="sidebar">
        <div class="logo-details">
            <img src="images/1.png" alt="logo">
            <span class="logo_name">HMS</span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php"><i class="fas fa fa-home"></i><span class="links_name">Home</span></a></li>
            <li><a href="frmAdminDashboard.php"><i class="fas fa-chart-line"></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="frmAnnouncement.php"><i class="fas fa-bell"></i><span class="links_name">Announcement</span></a></li>
            <li><a href="frmMemberMaster.php"><i class="fas fa-users"></i><span class="links_name">Member Master</span></a></li>
            <li><a href="frmCommitteeMaster.php"><i class="fas fa-users-cog"></i><span class="links_name">Committee Master</span></a></li>
            <li><a href="frmElectionDetails.php"><i class="fas fa-vote-yea"></i><span class="links_name">Election Details</span></a></li>
            <li><a href="frmMaintenance.php"><i class="fas fa-cogs"></i><span class="links_name">Maintenance</span></a></li>
          
            <li><a href="frmMonthlyMeeting.php"><i class="fas fa-calendar-check"></i><span class="links_name">Monthly Meeting</span></a></li>
            <li><a href="frmFine.php"><i class="fas fa-hand-holding-usd"></i><span class="links_name">Fine</span></a></li>
          
            <li><a href="frmNeighbourHood.php"><i class="fas fa-map-marked-alt"></i><span class="links_name">Neighbourhood</span></a></li>
         
            <li><a href="frmEvent.php"><i class="fas fa-calendar-alt"></i><span class="links_name">Events</span></a></li>
            <li class="log_out"><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span class="links_name">Logout</span></a></li>
        </ul>
    </div>

 
</div>
    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('sidebar').addEventListener('click', function() {
        document.querySelector('.sidebar-container').classList.toggle('active');
        document.querySelector('.home-section').classList.toggle('active');
    });
    </script>

