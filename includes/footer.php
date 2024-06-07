

    <!-- Footer Start -->
    <div class=" footer container-fluid bg-info pt-5 px-sm-3 px-md-5 mt-5">
        <div class="row py-4">
            <div class="col-md-4 mb-5">
                <h5 class=" text-white text-uppercase ">Get In Touch</h5>
                <?php 
$pagetype='contactus';
$query=mysqli_query($con,"select PageTitle,Description from tblpages where PageName='$pagetype'");
while($row=mysqli_fetch_array($query))
{

?>
   
    
      <!-- Intro Content -->
      <div class="row">

        <div class="col-lg-12">

          <p><?php echo $row['Description'];?></p>
        </div>
      </div>
      <!-- /.row -->
<?php } ?>
    
                <h6 class="mt-4 mb-2 text-white text-uppercase ">Follow Us</h6>
                <div class="d-flex justify-content-start">
                <?php
                      $query = mysqli_query($con, "SELECT name, htmlCode, socialLink FROM tblsocialmedia WHERE status=1");
                      while($row = mysqli_fetch_array($query)) {
                          echo '
                                  <a class="btn btn-lg btn-primary btn-lg-square mr-2" href="' . htmlentities($row['socialLink']) . '">' . $row['htmlCode'] . '</a>
                              ';
                      }
                      ?>
                  
                </div>
            </div>
        <div class="col-md-4">
        <h5 class="mb-2 text-white text-uppercase ">About</h5>
        <ul class="navbar-nav ml-2">
                       
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="about-us.php">About Us</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="contact-us.php">Contact  Us</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="terms-and-conditions.php">Terms And Condition </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white " href="privacy-policy.php">Privacy Policy </a>
                        </li>
                      
                    </ul>
        </div>
        <div class="col-md-4 ">
                <!-- for subscription -->
                <h5 class="mb-3 text-white text-uppercase  p-2 rounded">Subscribe to our NEWSLETTER</h5>
                <form action="subscribe.php" method="post" class="bg-light p-4 rounded shadow">
                    <div class="form-group">
                        <label for="email" class="text-dark">Enter your email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Subscribe</button>
                </form>
            </div>
            <div class=" col-md-12 ">
                <h5 class="mb-4 text-white text-uppercase ">Categories</h5>
                <div class="cat-foot  flex-wrap">
                <?php renderTree($categoryTree); ?>

                </div>
            </div>
        </div>
           
       
    </div>
    <div class="container-fluid py-4 px-sm-3 px-md-5 bg-primary text-white">
        <p class="m-0 text-center">&copy; <a href="index.php">hellogowda.com</a>. All Rights Reserved.

            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
            Designed by <a href="https://kenstacktechnologies.com">Kenstack Technologies</a><br>
         
        </p>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>


<?php
if(isset($_GET['catid'])){
?>
<script>
$("title").html("HelloGowda | " + $("h1:eq(2)").text());
</script>

<?php 
}
?>




</body>

</html>