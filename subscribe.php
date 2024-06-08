<?php
include('includes/header.php');
require 'vendor/autoload.php'; // Include Composer's autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (!emailExists($con, $email)) {
            if (subscribeEmail($con, $email)) {
                if (sendWelcomeEmail($email)) {
                    $response = '<div class="alert alert-success" role="alert">Email successfully subscribed and a greeting email has been sent!</div>';
                } else {
                    $response = '<div class="alert alert-danger" role="alert">Subscription successful, but the email could not be sent.</div>';
                }
            } else {
                $response = '<div class="alert alert-danger" role="alert">Something went wrong. Please try again later.</div>';
            }
        } else {
            $response = '<div class="alert alert-warning" role="alert">This email is already subscribed.</div>';
        }
    } else {
        $response = '<div class="alert alert-warning" role="alert">Invalid email format.</div>';
    }
} else {
    $response = '<div class="alert alert-danger" role="alert">Invalid request method.</div>';
}

function emailExists($con, $email) {
    $query = "SELECT id FROM subscriptions WHERE email = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }
    return false;
}

function subscribeEmail($con, $email) {
    $query = "INSERT INTO subscriptions (email) VALUES (?)";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $email);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
    return false;
}

function sendWelcomeEmail($email) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.hellogowda.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vallatharasu@hellogowda.com';
        $mail->Password   = '9090Valla9090@';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('vallatharasu@hellogowda.com', 'HelloGowda');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Welcome to HelloGowda!';
        $mail->Body    = '<h1>Thank you for subscribing!</h1><p>You have successfully subscribed to HelloGowda.</p>';

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}

?>

<!-- Page Content -->
<div class="container">
    <h5 class="mt-4 mb-3 text-center">Subscribe</h5>
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <?php echo $response; ?>
            <a href="index.php" class="btn btn-primary btn-block">Go Back</a>
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
