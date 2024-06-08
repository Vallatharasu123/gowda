<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
{ 
    header('location:index.php');
}
else{
    if(isset($_POST['update']))
    {
        $pagetype='privacypolicy';
        $pagetitle=$_POST['pagetitle'];
        $pagedetails=addslashes($_POST['pagedescription']);
        $query=mysqli_query($con,"update tblpages set PageTitle='$pagetitle',Description='$pagedetails' where PageName='$pagetype'");
        if($query)
        {
            $msg="Privacy Policy page successfully updated";
        }
        else{
            $error="Something went wrong. Please try again.";    
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
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <title>HelloGowda | Privacy Policy Page</title>
    <link href="../plugins/summernote/summernote.css" rel="stylesheet" />
    <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
    <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />
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
        <?php include('includes/topheader.php');?>
        <?php include('includes/leftsidebar.php');?>
        <div class="content-page">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Privacy Policy Page</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li><a href="#">Pages</a></li>
                                    <li class="active">Privacy Policy</li>
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
                    <?php 
                    $pagetype='privacypolicy';
                    $query=mysqli_query($con,"select PageTitle,Description from tblpages where PageName='$pagetype'");
                    while($row=mysqli_fetch_array($query))
                    {
                    ?>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="p-6">
                                <div class="">
                                    <form name="privacypolicy" method="post">
                                        <div class="form-group m-b-20">
                                            <label for="exampleInputEmail1">Page Title</label>
                                            <input type="text" class="form-control" id="pagetitle" name="pagetitle" value="<?php echo htmlentities($row['PageTitle'])?>" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box">
                                                    <h4 class="m-b-30 m-t-0 header-title"><b>Page Details</b></h4>
                                                    <textarea class="summernote" name="pagedescription" required><?php echo htmlentities($row['Description'])?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <button type="submit" name="update" class="btn btn-success waves-effect waves-light">Update and Post</button>
                                    </form>
                                </div>
                            </div> <!-- end p-20 -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- container -->
            </div> <!-- content -->
            <?php include('includes/footer.php');?>
        </div>
    </div>
    <script>
        var resizefunc = [];
    </script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="../plugins/switchery/switchery.min.js"></script>
    <script src="../plugins/summernote/summernote.min.js"></script>
    <script src="../plugins/select2/js/select2.min.js"></script>
    <script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>
    <script src="assets/pages/jquery.blog-add.init.js"></script>
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>
    <script>
        jQuery(document).ready(function(){
            $('.summernote').summernote({
                height: 240, minHeight: null, maxHeight: null, focus: false
            });
            $(".select2").select2();
            $(".select2-limiting").select2({
                maximumSelectionLength: 2
            });
        });
    </script>
</body>
</html>
<?php } ?>
