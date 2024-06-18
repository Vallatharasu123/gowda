<?php
session_start();
include('includes/config.php');
$msg = $delmsg = null;

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    // Code for soft delete
    if(isset($_GET['action']) && $_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "UPDATE tblcontact SET Is_Active='0' WHERE id='$id'");
        $msg = "Contact deleted";
    }

    // Code for restore
    if(isset($_GET['resid']) && $_GET['resid']) {
        $id = intval($_GET['resid']);
        $query = mysqli_query($con, "UPDATE tblcontact SET Is_Active='1' WHERE id='$id'");
        $msg = "Contact restored successfully";
    }

    // Code for permanent delete
    if(isset($_GET['action']) && $_GET['action'] == 'parmdel' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "DELETE FROM tblcontact WHERE id='$id'");
        $delmsg = "Contact deleted forever";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>HelloGowda | Manage Contacts</title>
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
        <?php include('includes/topheader.php');?>

        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/leftsidebar.php');?>
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
                                <h4 class="page-title">Manage Contacts Forum</h4>
                                <ol class="breadcrumb p-0 m-0">
                                    <li>
                                        <a href="#">Admin</a>
                                    </li>
                                    <li>
                                        <a href="#">Contacts </a>
                                    </li>
                                    <li class="active">
                                       Manage Contacts
                                    </li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-sm-6">  
                            <?php if($msg){ ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Well done!</strong> <?php echo htmlentities($msg);?>
                            </div>
                            <?php } ?>

                            <?php if($delmsg){ ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Oh snap!</strong> <?php echo htmlentities($delmsg);?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="demo-box m-t-20">
                                <div class="table-responsive">
                                    <table class="table m-0 table-colored-bordered table-bordered-primary">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Full Name</th>
                                                <th>Phone Number</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Submitted At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $query = mysqli_query($con, "SELECT id, FullName, PhoneNumber, Email, Message, SubmissionDate FROM tblcontact WHERE Is_Active=1");
                                            $cnt = 1;
                                            while($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt);?></th>
                                                <td><?php echo htmlentities($row['FullName']);?></td>
                                                <td><?php echo htmlentities($row['PhoneNumber']);?></td>
                                                <td><?php echo htmlentities($row['Email']);?></td>
                                                <td><?php echo htmlentities($row['Message']);?></td>
                                                <td><?php echo htmlentities($row['SubmissionDate']);?></td>
                                                <td>
                                                    <a href="manage-contacts.php?rid=<?php echo htmlentities($row['id']);?>&&action=del">
                                                        <i class="fa fa-trash-o" style="color: #f05050"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- end row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="demo-box m-t-20">
                                <div class="m-b-30">
                                    <h4><i class="fa fa-trash-o"></i> Deleted Contacts Forum</h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table m-0 table-colored-bordered table-bordered-danger">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Full Name</th>
                                                <th>Phone Number</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Submitted At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $query = mysqli_query($con, "SELECT id, FullName, PhoneNumber, Email, Message, SubmissionDate FROM tblcontact WHERE Is_Active=0");
                                            $cnt = 1;
                                            while($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt);?></th>
                                                <td><?php echo htmlentities($row['FullName']);?></td>
                                                <td><?php echo htmlentities($row['PhoneNumber']);?></td>
                                                <td><?php echo htmlentities($row['Email']);?></td>
                                                <td><?php echo htmlentities($row['Message']);?></td>
                                                <td><?php echo htmlentities($row['SubmissionDate']);?></td>
                                                <td>
                                                    <a href="manage-contacts.php?resid=<?php echo htmlentities($row['id']);?>">
                                                        <i class="ion-arrow-return-right" title="Restore this contact"></i>
                                                    </a> 
                                                    &nbsp;
                                                    <a href="manage-contacts.php?rid=<?php echo htmlentities($row['id']);?>&&action=parmdel" title="Delete forever"> 
                                                        <i class="fa fa-trash-o" style="color: #f05050"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--- end row -->
                </div> <!-- container -->
            </div> <!-- content -->
            <?php include('includes/footer.php');?>
        </div>
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
    <script src="../plugins/switchery/switchery.min.js"></script>

    <!-- App js -->
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>

</body>
</html>
<?php } ?>
