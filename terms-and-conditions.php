<!-- Navigation -->
<?php include('includes/header.php');?>
<!-- Page Content -->
<div class="container">
<?php 
$pagetype='termsandconditions';
$query=mysqli_query($con,"select PageTitle,Description from tblpages where PageName='$pagetype'");
while($row=mysqli_fetch_array($query))
{
?>
  <h1 class="mt-4 mb-3"><?php echo htmlentities($row['PageTitle'])?></h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active">Terms and Conditions</li>
  </ol>
  <div class="row">
    <div class="col-lg-12">
      <p><?php echo $row['Description'];?></p>
    </div>
  </div>
<?php } ?>
</div>
<!-- /.container -->
<!-- Footer -->
<?php include('includes/footer.php');?>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
