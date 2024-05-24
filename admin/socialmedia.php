<?php
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    if(isset($_POST['update'])) {
        $query = mysqli_query($con, "SELECT id, name FROM tblsocialmedia");
        while($row = mysqli_fetch_array($query)) {
            $id = $row['id'];
            $socialLink = $_POST["socialLink$id"];
            $status = !empty($socialLink) ? 1 : 0;
            $updateQuery = mysqli_query($con, "UPDATE tblsocialmedia SET socialLink='$socialLink', status='$status' WHERE id='$id'");
        }
        if($updateQuery) {
            $msg = "Social media links updated successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin | Social Media Links</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <script src="assets/js/modernizr.min.js"></script>
</head>
<body class="fixed-left">
    <div id="wrapper">
        <?php include('includes/topheader.php'); ?>
        <?php include('includes/leftsidebar.php'); ?>
        <div class="content-page">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Social Media Links</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Admin</a></li>
                                    <li class="active">Social Media Links</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <?php if($msg){ ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Well done!</strong> <?php echo htmlentities($msg);?>
                            </div>
                            <?php } ?>
                            <?php if($error){ ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Oh snap!</strong> <?php echo htmlentities($error);?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <h4 class="header-title m-t-0 m-b-30">Manage Social Media Links</h4>
                                <form method="post">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Icon</th>
                                                <th>Social Link</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $query = mysqli_query($con, "SELECT * FROM tblsocialmedia");
                                            $cnt = 1;
                                            while($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($row['name']);?></td>
                                                <td><?php echo $row['htmlCode'];?></td>
                                                <td>
                                                    <input type="url" name="socialLink<?php echo $row['id'];?>" class="form-control" value="<?php echo htmlentities($row['socialLink']);?>">
                                                </td>
                                            </tr>
                                            <?php $cnt++; } ?>
                                        </tbody>
                                    </table>
                                    <button type="submit" name="update" class="btn btn-success">Update Links</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>
</body>
</html>
<?php } ?>
