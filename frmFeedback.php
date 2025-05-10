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

if (isset($_POST["btnSubmitFeedback"])) {
    $feedbackType = $_POST["txtFeedbackType"];
    $feedbackMessage = $_POST["txtFeedbackMessage"];
    $firstName = $_POST["txtFirstName"];
    $lastName = $_POST["txtLastName"];
    $email = $_POST["txtEmail"];
    $submissionDate = date('Y-m-d H:i:s'); 

   
    if ($feedbackType != NULL && $feedbackMessage != NULL && $firstName != NULL && $lastName != NULL && $email != NULL) {
        
        
        $sql = "INSERT INTO feedback (feedback_type, feedback_message, first_name, last_name, email, submission_date) 
                VALUES ('$feedbackType', '$feedbackMessage', '$firstName', '$lastName', '$email', '$submissionDate')";
        
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Feedback submitted successfully.');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Fill all fields!!!');</script>";
    }
}
?>



<section class="feedback_section" style="background-color: #000; color: #fff; padding: 50px 0;">
  <div class="container">
    <!-- Heading -->
    <div class="heading_container" style="text-align: center; margin-bottom: 30px;">
      <h2 style="font-weight: bold;">We Value Your Feedback</h2>
      <p >We would love to hear your thoughts, suggestions, or concerns so we can improve!</p>
    </div>

    <!-- Feedback Form -->
    <div class="custom-form-container">
            <form action method="POST">
            <!-- Feedback Type -->
            <div class="feedback-type">
                <label>Feedback Type:</label><br>
                <input type="radio" id="comment" name="txtFeedbackType" value="Comment" required>
                <label for="comment">Comment</label>

                <input type="radio" id="suggestion" name="txtFeedbackType" value="Suggestion">
                <label for="suggestion">Suggestion</label>

                <input type="radio" id="question" name="txtFeedbackType" value="Question">
                <label for="question">Question</label>
            </div>

            <!-- Feedback Text -->
            <div>
                <textarea name="txtFeedbackMessage" placeholder="Describe your feedback" class="form-input" aria-label="Feedback Description" required></textarea>
            </div>

            <!-- Name Fields -->
            <div>
                <input type="text" name="txtFirstName" placeholder="First Name" class="form-input" aria-label="First Name" required />
            </div>
            <div>
                <input type="text" name="txtLastName" placeholder="Last Name" class="form-input" aria-label="Last Name" required />
            </div>

            <!-- Email Field -->
            <div>
                <input type="email" name="txtEmail" placeholder="Email" class="form-input" aria-label="Email" required />
            </div>

            <!-- Hidden Field for Submission Date -->
            <input type="hidden" name="txtSubmissionDate" value="<?php echo date('Y-m-d H:i:s'); ?>" />

            <!-- Submit Button -->
            <div>
                <button type="submit" name="btnSubmitFeedback" class="btn">Submit Feedback</button>
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

