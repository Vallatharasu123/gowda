

    <!-- Footer Start -->
    <div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5">
        <div class="row py-4">
            <div class="col-md-4 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Get In Touch</h5>
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
    
                <h6 class="mt-4 mb-3 text-white text-uppercase font-weight-bold">Follow Us</h6>
                <div class="d-flex justify-content-start">
                <?php
                      $query = mysqli_query($con, "SELECT name, htmlCode, socialLink FROM tblsocialmedia WHERE status=1");
                      while($row = mysqli_fetch_array($query)) {
                          echo '
                                  <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="' . htmlentities($row['socialLink']) . '">' . $row['htmlCode'] . '</a>
                              ';
                      }
                      ?>
                  
                </div>
            </div>
           
            <div class=" col-md-8 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Categories</h5>
                <div class="m-n1 d-flex flex-wrap">
                <?php
                                // Function to fetch categories and subcategories recursively<?php
function fetchCategoriesa($parentCategory = NULL, $level = 0) {
    global $con;
    
    $categories = array();

    // Query to fetch categories based on the parent category
    $query = "SELECT * FROM tblcategory WHERE Parent_Category " . ($parentCategory ? "= $parentCategory" : "IS NULL") . " AND Is_Active=1 ORDER BY id DESC";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        // Add the category to the array
        $categories[] = array(
            'id' => $row['id'],
            'name' => $row['CategoryName'],
            'level' => $level
        );

        // Fetch subcategories recursively
        $categories = array_merge($categories, fetchCategoriesa($row['id'], $level + 1));
    }

    return $categories;
}

// Fetch categories and subcategories recursively
$categories = fetchCategoriesa();

// Display categories and subcategories as buttons
foreach ($categories as $category) {
    $indentation = str_repeat("", $category['level']);
    echo '<a href="category.php?catid='.$category['id'].'" class="btn btn-sm btn-secondary m-1">' . $indentation . $category['name'] . '</a><br>';
}
?>

                </div>
            </div>
          
        </div>
    </div>
    <div class="container-fluid py-4 px-sm-3 px-md-5" style="background: #111111;">
        <p class="m-0 text-center">&copy; <a href="#">Thimme Gowda</a>. All Rights Reserved.

            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
            Design by <a href="https://kenstacktechnologies.com">Kenstack Technologies</a><br>
         
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







</body>

</html>