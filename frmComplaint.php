<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Contact</title>

  <?php include('header.php'); ?>


</head>
<body>

<?php

include("db.php");


if (isset($_POST["btnSubmit"])) {

    $name = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    $phone = $_POST["txtPhone"];
    $complaint_type = $_POST["txtComplaintType"];
    $message = $_POST["txtMessage"];
    $submission_date = date('Y-m-d H:i:s'); 


    if ($name != NULL && $email != NULL && $phone != NULL && $complaint_type != NULL && $message != NULL) {
        
       
        $sql = "INSERT INTO complaints (name, email, phone, complaint_type, message, submission_date) 
                VALUES ('$name', '$email', '$phone', '$complaint_type', '$message', '$submission_date')";
        $r = mysqli_query($conn, $sql);

        if ($r) {
            echo "<script>alert('Complaint submitted successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}
?>


<section class="contact_section" style="background-color: #000; color: #fff; padding: 50px 0;">
  <div class="container">
    <!-- Heading -->
    <div class="heading_container" style="text-align: center; margin-bottom: 30px;">
      <h1 style="color: #f00; font-weight: bold;">Submit a Complaint</h1>
    </div>

    <!-- Complaint Form -->
    <div class="custom-form-container">
      <form action method="POST">
        <div>
          <input type="text" name="txtName" placeholder="Full Name" class="form-input" aria-label="Full Name" required />
        </div>
        <div>
          <input type="email" name="txtEmail" placeholder="Email" class="form-input" aria-label="Email" required />
        </div>
        <div>
          <input type="text" name="txtPhone" placeholder="Phone Number" class="form-input" aria-label="Phone Number" required />
        </div>
        <div>
          <select name="txtComplaintType" class="form-input" required>
            <option value="" disabled selected>Select Complaint Type</option>
            <option value="billing">Billing Issue</option>
            <option value="service">Service Issue</option>
            <option value="technical">Technical Problem</option>
            <option value="other">Other</option>
          </select>
        </div>
        <div>
          <textarea name="txtMessage" placeholder="Describe your complaint" class="form-input" aria-label="Complaint Description" required></textarea>
        </div>
        <input type="hidden" name="submission_date" value="<?php echo date('Y-m-d H:i:s'); ?>" />
        <div>
          <button type="submit" name="btnSubmit" class="btn">Submit Complaint</button>
        </div>
      </form>
    </div>
  </div>
</section>


<!-- footer section -->
<section class="container-fluid footer_section">
  <div class="container">
    <p> <span style="color: #f00;">2025 All Rights Reserved By <a>Gaurav Umesh Malankar</a></p></span> 
  </div>
</section>
<!-- end footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="js/custom.js"></script>
    

</body>
</html>

