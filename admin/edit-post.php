<?php 
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['login'])==0)
{ 
    header('location:index.php');
}
else {
    // Fetching the post to be edited
    $postid = intval($_GET['pid']); // Post ID to be edited
    if(isset($_POST['submit'])) {
        $posttitle = $_POST['posttitle'];
        $catid = $_POST['category'];
        $postdetails = addslashes($_POST['postdescription']);
        $postedby = $_SESSION['login'];
        $arr = explode(" ", $posttitle);
        $url = implode("-", $arr);
        $imgfile = $_FILES["postimage"]["name"];

        // Allowed extensions
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");

        if($imgfile) {
            // Get the image extension
            $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
            // Validation for allowed extensions
            if(!in_array($extension, $allowed_extensions)) {
                echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
            } else {
                // Rename the image file
                $imgnewfile = md5($imgfile) . $extension;
                // Code for moving the image into the directory
                move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);
                $query = mysqli_query($con, "update tblposts set PostTitle='$posttitle', CategoryId='$catid', PostDetails='$postdetails', PostUrl='$url', PostImage='$imgnewfile' where id='$postid'");
                if($query) {
                    $msg = "Post successfully updated ";
                } else {
                    $error = "Something went wrong. Please try again.";    
                }
            }
        } else {
            $query = mysqli_query($con, "update tblposts set PostTitle='$posttitle', CategoryId='$catid', PostDetails='$postdetails', PostUrl='$url' where id='$postid'");
            if($query) {
                $msg = "Post successfully updated ";
            } else {
                $error = "Something went wrong. Please try again.";    
            }
        }
    }

    // Fetching the current post details
    $query = mysqli_query($con, "select * from tblposts where id='$postid' and Is_Active=1");
    while($row = mysqli_fetch_array($query)) {
        $posttitle = $row['PostTitle'];
        $catid = $row['CategoryId'];
        $postdetails = $row['PostDetails'];
        $postimage = $row['PostImage'];
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
    <title>HelloGowda | Edit Post</title>
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
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php include('includes/topheader.php'); ?>
        <!-- Left Sidebar Start -->
        <?php include('includes/leftsidebar.php'); ?>
        <!-- Left Sidebar End -->

        <div class="content-page">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Edit Post </h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Post</a></li>
                                    <li><a href="#">Edit Post </a></li>
                                    <li class="active">Edit Post</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="p-6">
                                <?php if($msg){ ?>
                                    <div class="alert alert-success" role="alert">
                                        <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } ?>

                                <div class="">
                                    <form name="editpost" method="post" enctype="multipart/form-data">
                                        <div class="form-group m-b-20">
                                            <label for="posttitle">Post Title</label>
                                            <input type="text" class="form-control" id="posttitle" name="posttitle" value="<?php echo htmlentities($posttitle); ?>" required>
                                        </div>
                                        <div class="form-group m-b-20">
                                            <label for="category">Category</label>
                                            <select class="form-control" name="category" id="category" required>
                                                <option value="">Select Category </option>
                                                <?php
                                                $ret = mysqli_query($con, "select id, CategoryName from tblcategory where Is_Active=1");
                                                while($result = mysqli_fetch_array($ret)) {    
                                                ?>
                                                    <option value="<?php echo htmlentities($result['id']); ?>" <?php if($result['id'] == $catid) echo 'selected'; ?>><?php echo htmlentities($result['CategoryName']); ?></option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box">
                                                    <h4 class="m-b-30 m-t-0 header-title"><b>Post Details</b></h4>
                                                    <textarea class="summernote" name="postdescription" required><?php echo htmlentities($postdetails); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box">
                                                    <h4 class="m-b-30 m-t-0 header-title"><b>Feature Image</b></h4>
                                                    <img src="postimages/<?php echo htmlentities($postimage); ?>" width="300" />
                                                    <input type="file" class="form-control" id="postimage" name="postimage">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Save and Update</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light">Discard</button>
                                    </form>
                                </div>
                            </div> <!-- end p-20 -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- container -->
            </div> <!-- content -->
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
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
<script src="../plugins/switchery/switchery.min.js"></script>
<!-- Summernote js -->
<script src="../plugins/summernote/summernote.min.js"></script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- Jquery filer js -->
<script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>
<!-- page specific js -->
<script src="assets/pages/jquery.blog-add.init.js"></script>
<!-- App js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>
<script>
    jQuery(document).ready(function(){
        $('.summernote').summernote({
            height: 240, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
        // Select2
        $(".select2").select2();
        $(".select2-limiting").select2({
            maximumSelectionLength: 2
        });
    });
</script>
</body>
</html>
