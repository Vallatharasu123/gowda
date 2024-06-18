<!-- Navigation -->
<?php include('includes/header.php');?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $query = "INSERT INTO tblcontact (FullName, PhoneNumber, Email, Message) VALUES ('$name', '$phone', '$email', '$message')";

    if (mysqli_query($con, $query)) {
        $msg = "Message sent successfully!";
        $msgClass = "alert-success";
    } else {
        $msg = "ERROR: Could not execute $query. " . mysqli_error($con);
        $msgClass = "alert-danger";
    }
}
?>
<!-- Page Content -->
<div class="container">
    <h1 class="mt-4 mb-3">Contact Us</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">Contact</li>
    </ol>

    <!-- Contact Form -->
    <div class="row">
        <div class="col-lg-8 mx-auto mb-4 p-4 shadow-sm rounded-sm" style="background-color:lightgrey;">
            <?php if(isset($msg)): ?>
                <div class="alert <?php echo $msgClass; ?> alert-dismissible fade show" role="alert">
                    <?php echo $msg; ?>
                   
                </div>
            <?php endif; ?>
            <form name="sentMessage" id="contactForm" method="post" action="">
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Full Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required data-validation-required-message="Please enter your name." placeholder="Enter Your Fullname...">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Phone Number:</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required data-validation-required-message="Please enter your phone number." placeholder="Enter Your Phone Number...">
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Email Address:</label>
                        <input type="email" class="form-control" id="email" name="email" required data-validation-required-message="Please enter your email address." placeholder="Enter Your Email Address...">
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Message:</label>
                        <textarea rows="10" cols="100" class="form-control" id="message" name="message" required data-validation-required-message="Please enter your message" maxlength="999" style="resize:none"></textarea>
                    </div>
                </div>
                <div id="success"></div>
                <!-- For success/fail messages -->
                <button type="submit" class="btn btn-primary" id="sendMessageButton">Send Message</button>
            </form>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->

<!-- Footer -->
<?php include('includes/footer.php');?>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
