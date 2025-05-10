<?php
session_start();
include('db.php');

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: Login1/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neighbourhood Info</title>
    <?php include('Sidebar.php'); ?>
 
    <link rel="stylesheet" href="css/styleMaster.css">

 
</head>
<body>


    <section class="home-section">
        <nav class="custom-navbar d-flex justify-content-between align-items-center">
            <h1>Neighbour Hood</h1>
            <?php
                include 'AdminDropDown.php';
            ?>
      </nav>
       
        <div class="home-content">
            
            <div class="loca-box">
                <div class="loca-cat">
                    <div class="tittle">Police Station</div>
                    <div class="content">
                        <div class="inner-content">
                            <div class="map-box">
                                <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d478.7656971480108!2d73.70555426557232!3d16.265333201388206!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc0162bea2161fd%3A0x25e4044c8b4be43b!2sKankavli%20Police%20Station!5e0!3m2!1sen!2sin!4v1739636346620!5m2!1sen!2sin" allowfullscreen loading="lazy"></iframe>
                            </div>
                            <div class="info-box">
                                <h3>Kankavli Police Station</h3>
                                <p>Kalmath Bazar, Nadakarni Nagar, Maharashtra 416602</p>
                                <p>Contact: 02367232033</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="loca-cat">
                    <div class="tittle">Hospitals</div>
                    <div class="content">
                        <div class="inner-content">
                            <div class="map-box">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d957.5257547859771!2d73.70503052620147!3d16.266489751795856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc03d8400000001%3A0x3e3dac60faafdd8c!2sSiddhi%20Vinayak%20Hospital%20%26%20ICU%20Center!5e0!3m2!1sen!2sin!4v1739636510133!5m2!1sen!2sin" allowfullscreen loading="lazy"></iframe>
                            </div>
                            <div class="info-box">
                                <h3>SiddhiVinayak Hospital</h3>
                                <p>Bidyewadi Rd, Kaleshwar Nagar, Maharashtra 416602
                                </p>
                                <p>Contact: +9102367237809</p>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="inner-content">
                            <div class="map-box">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1138.698248432449!2d73.70533707295888!3d16.266177960934172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc0162bb9ed8f4f%3A0x3152cff7aaecbf89!2sDr.%20Birmole&#39;s%20Gurukrupa%20Hospital!5e0!3m2!1sen!2sin!4v1739636596446!5m2!1sen!2sin" style="border:0;" allowfullscreen loading="lazy"></iframe>
                            </div>
                            <div class="info-box">
                                <h3>Gurukrupa Hospital</h3>
                                <p>Bidyewadi Rd, Kalmath Bazar, Kalmath, Maharashtra 416602
                                </p>
                                <p>Contact: +9102367232909</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


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