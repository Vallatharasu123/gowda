<?php
session_start();
include ('includes/config.php');
$msg=null;
require '../vendor/autoload.php'; // Include Composer's autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generateSeoUrlPost($title, $id)
{
    // Convert to lowercase
    $title = strtolower($title);
    // Replace spaces with hyphens
    $title = str_replace(' ', '-', $title);
    // Remove special characters
    $title = preg_replace('/[^a-z0-9-]/', '', $title);
    return "post-" . $title . '-' . $id;
}
function sendPostEmail($email, $posttitle, $postlink)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'mail.hellogowda.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'vallatharasu@hellogowda.com';
        $mail->Password = '9090Valla9090@';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('vallatharasu@hellogowda.com', 'HelloGowda');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'New Post: ' . $posttitle;

        $mail->Body = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                }
                .header {
                    text-align: center;
                    padding-bottom: 20px;
                }
                .header h1 {
                    margin: 0;
                }
                .content {
                    text-align: left;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                }
                .button {
                    display: inline-block;
                    padding: 10px 20px;
                    margin-top: 20px;
                    background-color: #28a745;
                    color: #fff;
                    text-decoration: none;
                    border-radius: 5px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Thank you for subscribing, ' . htmlspecialchars($email) . '!</h1>
                </div>
                <div class="content">
                    <h2>' . htmlspecialchars($posttitle) . '</h2>
                    <p><a href="' . htmlspecialchars($postlink) . '" class="button">Read More</a></p>
                </div>
                <div class="footer">
                    <p>&copy; ' . date('Y') . ' HelloGowda. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>';

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}


if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Function to update sitemap.xml
    function updateSitemap($newUrl)
    {
        $sitemapFile = '../sitemap.xml';
        if (file_exists($sitemapFile)) {
            $xml = simplexml_load_file($sitemapFile);
        } else {
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
        }

        $urlElement = $xml->addChild('url');
        $urlElement->addChild('loc', $newUrl);
        $urlElement->addChild('lastmod', date('c'));
        $urlElement->addChild('priority', '0.80');

        $xml->asXML($sitemapFile);
    }

    // For adding post
    if (isset($_POST['submit'])) {
        $posttitle = $_POST['posttitle'];
        $catid = $_POST['category'];
        $postdetails = addslashes($_POST['postdescription']);
        $postedby = $_SESSION['login'];
        $arr = explode(" ", $posttitle);
        $url = implode("-", $arr);
        $imgfile = $_FILES["postimage"]["name"];
        // get the image extension
        $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
        // allowed extensions
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
        // Validation for allowed extensions .in_array() function searches an array for a specific value.
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            // rename the image file
            $imgnewfile = md5($imgfile) . $extension;
            // Code for move image into directory
            move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);
            $status = 1;
            $query = mysqli_query($con, "insert into tblposts(PostTitle,CategoryId,PostDetails,PostUrl,Is_Active,PostImage,postedBy) values('$posttitle','$catid','$postdetails','$url','$status','$imgnewfile','$postedby')");
            if ($query) {
          
                $seoUrl=generateSeoUrlPost($posttitle, mysqli_insert_id($con));
                // Update sitemap
                $newPostUrl = "https://www.hellogowda.com/post-details.php?" . $seoUrl;
                updateSitemap($newPostUrl);
                $sql = "SELECT email FROM subscriptions WHERE is_active = 1";
                $result =mysqli_query($con,$sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $email = $row['email'];
                        sendPostEmail($email, $posttitle,  $newPostUrl);
                    }

                    $msg="Post successfully added.Emails have been sent successfully.";
                }



            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- App title -->
    <title>HelloGowda | Add Post</title>
    <!-- Summernote css -->
    <link href="../plugins/summernote/summernote.css" rel="stylesheet" />
    <!-- Select2 -->
    <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Jquery filer css -->
    <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
    <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
    <script src="assets/js/modernizr.min.js"></script>
</head>

<body class="fixed-left">
    <!-- Begin page -->
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php include ('includes/topheader.php'); ?>
        <!-- ========== Left Sidebar Start ========== -->
        <?php include ('includes/leftsidebar.php'); ?>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Add Post </h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Post</a></li>
                                    <li><a href="#">Add Post </a></li>
                                    <li class="active">Add Post</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="p-6">
                                <?php if ($msg) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } ?>
                                <div class="">
                                    <form name="addpost" method="post" enctype="multipart/form-data">
                                        <div class="form-group m-b-20">
                                            <label for="exampleInputEmail1">Post Title</label>
                                            <input type="text" class="form-control" id="posttitle" name="posttitle"
                                                placeholder="Enter title" required>
                                        </div>
                                        <div class="form-group m-b-20">
                                            <label for="exampleInputEmail1">Category</label>
                                            <select class="form-control" name="category" id="category" required>
                                                <option value="">Select Category </option>
                                                <?php
                                                // Fetching active categories
                                                $ret = mysqli_query($con, "select id,CategoryName from tblcategory where Is_Active=1");
                                                while ($result = mysqli_fetch_array($ret)) {
                                                    ?>
                                                    <option value="<?php echo htmlentities($result['id']); ?>">
                                                        <?php echo htmlentities($result['CategoryName']); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box">
                                                    <h4 class="m-b-30 m-t-0 header-title"><b>Post Details</b></h4>
                                                    <textarea class="summernote" name="postdescription"
                                                        required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box">
                                                    <h4 class="m-b-30 m-t-0 header-title"><b>Feature Image</b></h4>
                                                    <input type="file" class="form-control" id="postimage"
                                                        name="postimage" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit"
                                            class="btn btn-success waves-effect waves-light">Save and Post</button>
                                        <button type="button"
                                            class="btn btn-danger waves-effect waves-light">Discard</button>
                                    </form>
                                </div>
                            </div> <!-- end p-20 -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- container -->
            </div> <!-- content -->
            <?php include ('includes/footer.php'); ?>
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->
    <script>
        var resizefunc = [];
    </script>
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <!-- Jquery filer js -->
    <script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>
    <!-- App js -->
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>
    <!-- Summernote js -->
    <script src="../plugins/summernote/summernote.min.js"></script>
    <!-- Select 2 js -->
    <script src="../plugins/select2/js/select2.min.js"></script>
    <script src="../plugins/switchery/switchery.min.js"></script>
    <script src="../plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
    <script src="../plugins/jquery.quicksearch/jquery.quicksearch.js"></script>
    <script>
        jQuery(document).ready(function () {
            $('.summernote').summernote({
                height: 240,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });
            $(".select2").select2();
            $(".select2-limiting").select2({
                maximumSelectionLength: 2
            });
        });
    </script>
</body>

</html>