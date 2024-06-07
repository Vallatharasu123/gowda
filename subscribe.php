<?php
include('includes/header.php');

require 'vendor/autoload.php'; // Include Composer's autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email already exists
      
        $check_stmt = $con->prepare("SELECT id FROM subscriptions WHERE email = ?");
        if ($check_stmt) {
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                $response = '<div class="alert alert-warning" role="alert">This email is already subscribed.</div>';
            } else {
                // Prepare an insert statement
                $stmt = $con->prepare("INSERT INTO subscriptions (email) VALUES (?)");

                if ($stmt) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("s", $email);

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        // Email successfully subscribed, now send the email
                        $mail = new PHPMailer(true);

                        try {
                            // Server settings
                            $mail->isSMTP();
                            $mail->Host       = 'mail.hellogowda.com'; // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;
                            $mail->Username   = 'vallatharasu@hellogowda.com'; // SMTP username
                            $mail->Password   = '9090Valla9090@'; // SMTP password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable SSL encryption
                            $mail->Port       = 465; // TCP port to connect to

                            // Recipients
                            $mail->setFrom('vallatharasu@hellogowda.com', 'HelloGowda');
                            $mail->addAddress($email);

                            // Content
                            $mail->isHTML(true);
                            $mail->Subject = 'Welcome to HelloGowda!';
                            $mail->Body    = '<h1>Thank you for subscribing!</h1><p>You have successfully subscribed to HelloGowda.</p>';

                            $mail->send();
                            $response = '<div class="alert alert-success" role="alert">Email successfully subscribed and a greeting email has been sent!</div>';
                        } catch (Exception $e) {
                            $response = '<div class="alert alert-danger" role="alert">Subscription successful, but the email could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</div>';
                        }
                    } else {
                        $response = '<div class="alert alert-danger" role="alert">Something went wrong. Please try again later.</div>';
                    }

                    // Close statement
                    $stmt->close();
                } else {
                    $response = '<div class="alert alert-danger" role="alert">Failed to prepare the SQL statement.</div>';
                }
            }

            // Close check statement
            $check_stmt->close();
        } else {
            $response = '<div class="alert alert-danger" role="alert">Failed to prepare the SQL statement.</div>';
        }
    } else {
        $response = '<div class="alert alert-warning" role="alert">Invalid email format.</div>';
    }
} else {
    $response = '<div class="alert alert-danger" role="alert">Invalid request method.</div>';
}
?>

<!-- Page Content -->
<div class="container">
    <h5 class="mt-4 mb-3 text-center">Subscribe</h5>
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <?php echo $response; ?>
            <a href="index.html" class="btn btn-primary btn-block">Go Back</a>
        </div>
    </div>
</div>
<!-- /.container -->

<!-- Footer -->
<?php include('includes/footer.php'); ?>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
