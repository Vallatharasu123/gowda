<?php
session_start();
include('includes/config.php');

// Set error reporting to display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
$msg = $error = null;

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    // Get the category ID from the query string
    $categoryId = intval($_GET['cid']);

    // Fetch existing category details
    if ($categoryId > 0) {
        $query = mysqli_query($con, "SELECT * FROM tblcategory WHERE id='$categoryId'");
        $categoryData = mysqli_fetch_array($query);
        if (!$categoryData) {
            $error = "Category not found.";
        }
    }

    if (isset($_POST['submit'])) {
        $category = $_POST['category'];
        $description = $_POST['description'];
        $status = 1;
        $isSubcategory = isset($_POST['is_subcategory']) ? 1 : 0;
        $parentCategory = null;

        if ($isSubcategory && isset($_POST['parent_category'])) {
            $parentCategory = $_POST['parent_category'];
            $query = mysqli_query($con, "UPDATE tblcategory SET CategoryName='$category', Description='$description', Is_Active='$status', Is_Subcategory='$isSubcategory', Parent_Category='$parentCategory' WHERE id='$categoryId'");
        } else {
            $query = mysqli_query($con, "UPDATE tblcategory SET CategoryName='$category', Description='$description', Is_Active='$status', Is_Subcategory='$isSubcategory', Parent_Category=NULL WHERE id='$categoryId'");
        }

        if ($query) {
            $msg = "Category updated";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HelloGowda | Edit Category</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

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
<body class="fixed-left ">
    <div id="wrapper">
        <!-- Top Bar Start -->
        <?php include('includes/topheader.php'); ?>
        <!-- Top Bar End -->
        <!-- ========== Left Sidebar Start ========== -->
        <?php include('includes/leftsidebar.php'); ?>
        <!-- Left Sidebar End -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Edit Category</h4>
                                <!-- Add breadcrumb -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <h4 class="m-t-0 header-title"><b>Edit Category</b></h4>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success" role="alert">
                                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if ($error) { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <form class="form-horizontal" name="category" method="post">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Category</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" value="<?php echo htmlentities($categoryData['CategoryName']); ?>" name="category" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Category Description</label>
                                                <div class="col-md-10">
                                                    <textarea class="form-control" rows="5" name="description" required><?php echo htmlentities($categoryData['Description']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Subcategory</label>
                                                <div class="col-md-10">
                                                    <input type="checkbox" name="is_subcategory" id="is_subcategory" <?php echo $categoryData['Is_Subcategory'] ? 'checked' : ''; ?>>
                                                </div>
                                            </div>
                                            <div id="parent_category_div" class="form-group" style="display: <?php echo $categoryData['Is_Subcategory'] ? 'block' : 'none'; ?>;">
                                                <label class="col-md-2 control-label">Parent Category</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" name="parent_category" id="parent_category">
                                                        <option value="">Select Parent Category</option>
                                                        <?php
                                                        $parentCategories = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory WHERE Is_Subcategory=0");
                                                        while ($row = mysqli_fetch_array($parentCategories)) {
                                                            $selected = ($categoryData['Parent_Category'] == $row['id']) ? 'selected' : '';
                                                            echo "<option value='" . htmlentities($row['id']) . "' $selected>" . htmlentities($row['CategoryName']) . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- App js -->
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>
    <script>
        $(document).ready(function() {
            $('#is_subcategory').change(function() {
                if ($(this).is(":checked")) {
                    $('#parent_category_div').show();
                    // AJAX call to fetch parent categories and populate the select box
                    $.ajax({
                        type: 'GET',
                        url: 'get_parent_categories.php', // Change this URL to your actual PHP file that fetches parent categories
                        success: function(response) {
                            console.log(response);
                            $('#parent_category').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    $('#parent_category_div').hide();
                }
            });

            // Trigger change event on page load to populate the parent category select box if it's a subcategory
            $('#is_subcategory').trigger('change');
        });
    </script>
</body>
</html>
