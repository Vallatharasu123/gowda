
        <!-- Navigation -->
   <?php include('includes/header.php');?>
    <!-- Main News Slider Start -->
    <div class="container-fluid">
        <div class="row">
            <?php
            $query = mysqli_query($con, "SELECT tblposts.id AS pid, tblposts.PostTitle AS posttitle, tblposts.PostImage, tblcategory.CategoryName AS category, tblcategory.id AS cid, tblposts.PostDetails AS postdetails, tblposts.PostingDate AS postingdate, tblposts.PostUrl AS url FROM tblposts LEFT JOIN tblcategory ON tblcategory.id=tblposts.CategoryId WHERE tblposts.Is_Active = 1 AND tblcategory.Is_Active = 1 ORDER BY tblposts.id DESC limit 5");
            ?>
            <div class="col-lg-7 px-0">
                <div class="owl-carousel main-carousel position-relative">
                    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                        <div class="position-relative overflow-hidden" style="height: 500px;">
                            <img class="img-fluid h-100"
                                src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>"
                                style="object-fit: cover;">
                            <div class="overlay">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                        href="category.php?cid=<?php echo htmlentities($row['cid']); ?>">
                                        <?php echo htmlentities($row['category']); ?>
                                    </a>
                                    <a class="text-white"
                                        href="post-details.php?pid=<?php echo htmlentities($row['pid']); ?>">
                                        <?php echo date('M d, Y', strtotime($row['postingdate'])); ?>
                                    </a>
                                </div>
                                <a class="h2 m-0 text-white text-uppercase font-weight-bold"
                                    href="post-details.php?pid=<?php echo htmlentities($row['pid']); ?>">
                                    <?php echo htmlentities($row['posttitle']); ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php $query1 = mysqli_query($con, "SELECT tblposts.id AS pid, tblposts.PostTitle AS posttitle, tblposts.PostImage, tblcategory.CategoryName AS category, tblcategory.id AS cid, tblposts.PostingDate AS postingdate, tblposts.PostUrl AS url FROM tblposts LEFT JOIN tblcategory ON tblcategory.id=tblposts.CategoryId WHERE tblposts.Is_Active = 1 AND tblcategory.Is_Active = 1 ORDER BY viewCounter DESC LIMIT 4");
            ?>

            <div class="col-lg-5 px-0">
                <div class="row mx-0">
                    <?php while ($row1 = mysqli_fetch_assoc($query1)) { ?>
                        <div class="col-md-6 px-0">
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid w-100 h-100"
                                    src="admin/postimages/<?php echo htmlentities($row1['PostImage']); ?>"
                                    style="object-fit: cover;">
                                <div class="overlay">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                            href="category.php?cid=<?php echo htmlentities($row1['cid']); ?>">
                                            <?php echo htmlentities($row1['category']); ?>
                                        </a>
                                        <a class="text-white"
                                            href="post-details.php?pid=<?php echo htmlentities($row1['pid']); ?>">
                                            <small><?php echo date('M d, Y', strtotime($row1['postingdate'])); ?></small>
                                        </a>
                                    </div>
                                    <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold"
                                        href="post-details.php?pid=<?php echo htmlentities($row1['pid']); ?>">
                                        <?php echo htmlentities($row1['posttitle']); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News Slider End -->



    <?php
    $query1 = mysqli_query($con, "SELECT tblposts.id AS pid, tblposts.PostTitle AS posttitle, tblposts.PostImage, tblcategory.CategoryName AS category, tblcategory.id AS cid, tblposts.PostingDate AS postingdate, tblposts.PostUrl AS url FROM tblposts LEFT JOIN tblcategory ON tblcategory.id=tblposts.CategoryId WHERE tblposts.Is_Active = 1 AND tblcategory.Is_Active = 1 ORDER BY viewCounter DESC ");
    ?>

    <!-- Featured News Slider Start -->
    <div class="container-fluid pt-5 mb-3">
        <div class="container">
            <div class="section-title">
                <h4 class="m-0 text-uppercase font-weight-bold">Popular Posts</h4>
            </div>
            <div class="owl-carousel news-carousel carousel-item-4 position-relative">
                <?php while ($row1 = mysqli_fetch_assoc($query1)) { ?>
                    <div class="position-relative overflow-hidden" style="height: 300px;">
                        <img class="img-fluid h-100" src="admin/postimages/<?php echo htmlentities($row1['PostImage']); ?>"
                            style="object-fit: cover;">
                        <div class="overlay">
                            <div class="mb-2">
                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                    href="category.php?cid=<?php echo htmlentities($row1['cid']); ?>">
                                    <?php echo htmlentities($row1['category']); ?>
                                </a>
                                <a class="text-white" href="post-details.php?pid=<?php echo htmlentities($row1['pid']); ?>">
                                    <small><?php echo date('M d, Y', strtotime($row1['postingdate'])); ?></small>
                                </a>
                            </div>
                            <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold"
                                href="post-details.php?pid=<?php echo htmlentities($row1['pid']); ?>">
                                <?php echo htmlentities($row1['posttitle']); ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- News With Sidebar Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php
                // Query to fetch recent posts
$query = mysqli_query($con, "SELECT tblposts.id AS pid, tblposts.PostTitle AS posttitle, tblposts.PostImage, tblcategory.CategoryName AS category, tblcategory.id AS cid, tblposts.PostingDate AS postingdate, tblposts.PostUrl AS url FROM tblposts LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId WHERE tblposts.Is_Active = 1 AND tblcategory.Is_Active = 1 ORDER BY tblposts.id DESC");

?>

<div class="row">
    <div class="col-12">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">Recent Posts</h4>
            <!-- <a class="text-secondary font-weight-medium text-decoration-none" href="">View All</a> -->
        </div>
    </div>

    <?php 
    $postCounter = 0; // Counter to track the number of posts
    while ($row = mysqli_fetch_assoc($query)) { 
        // Open a new column for every two posts
        if ($postCounter % 2 == 0) { 
            echo '<div class="col-lg-6">';
        }
    ?>

    <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
        <img class="img-fluid " width="100px"  src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="">
        <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
            <div class="mb-2">
                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="category.php?cid=<?php echo htmlentities($row['cid']); ?>">
                    <?php echo htmlentities($row['category']); ?>
                </a>
                <a class="text-body" href="post-details.php?pid=<?php echo htmlentities($row['pid']); ?>">
                    <small><?php echo date('M d, Y', strtotime($row['postingdate'])); ?></small>
                </a>
            </div>
            <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="post-details.php?pid=<?php echo htmlentities($row['pid']); ?>">
                <?php echo htmlentities($row['posttitle']); ?>
            </a>
        </div>
    </div>

    <?php 
        $postCounter++;
        // Close the column after every two posts
        if ($postCounter % 2 == 0) {
            echo '</div>';
        }
    }

    // If the number of posts is odd, close the last column
    if ($postCounter % 2 != 0) {
        echo '</div>';
    }
    ?>

</div>
                </div>

                <div class="col-lg-4">
                    <!-- Social Follow Start -->
                    <!-- <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Follow Us</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                                style="background: #39569E;">
                                <i class="fab fa-facebook-f text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Fans</span>
                            </a>
                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                                style="background: #52AAF4;">
                                <i class="fab fa-twitter text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Followers</span>
                            </a>
                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                                style="background: #0185AE;">
                                <i class="fab fa-linkedin-in text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Connects</span>
                            </a>
                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                                style="background: #C8359D;">
                                <i class="fab fa-instagram text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Followers</span>
                            </a>
                            <a href="" class="d-block w-100 text-white text-decoration-none mb-3"
                                style="background: #DC472E;">
                                <i class="fab fa-youtube text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Subscribers</span>
                            </a>
                            <a href="" class="d-block w-100 text-white text-decoration-none"
                                style="background: #055570;">
                                <i class="fab fa-vimeo-v text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Followers</span>
                            </a>
                        </div>
                    </div> -->
                    <!-- Social Follow End -->

                    <!-- Ads Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Advertisement</h4>
                        </div>
                        <div class="bg-white text-center border border-top-0 p-3">
                            <a href=""><img class="img-fluid" src="img/news-800x500-2.jpg" alt=""></a>
                        </div>
                    </div>
                    <!-- Ads End -->

                    <!-- Popular News Start -->
                    <!-- <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Tranding News</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <img class="img-fluid" src="img/news-110x110-1.jpg" alt="">
                                <div
                                    class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                                            href="">Business</a>
                                        <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                                    </div>
                                    <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="">Lorem ipsum
                                        dolor sit amet elit...</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <img class="img-fluid" src="img/news-110x110-2.jpg" alt="">
                                <div
                                    class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                                            href="">Business</a>
                                        <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                                    </div>
                                    <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="">Lorem ipsum
                                        dolor sit amet elit...</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <img class="img-fluid" src="img/news-110x110-3.jpg" alt="">
                                <div
                                    class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                                            href="">Business</a>
                                        <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                                    </div>
                                    <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="">Lorem ipsum
                                        dolor sit amet elit...</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <img class="img-fluid" src="img/news-110x110-4.jpg" alt="">
                                <div
                                    class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                                            href="">Business</a>
                                        <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                                    </div>
                                    <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="">Lorem ipsum
                                        dolor sit amet elit...</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <img class="img-fluid" src="img/news-110x110-5.jpg" alt="">
                                <div
                                    class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                                            href="">Business</a>
                                        <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                                    </div>
                                    <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="">Lorem ipsum
                                        dolor sit amet elit...</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Popular News End -->

                  

                    <!-- Tags Start -->
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex flex-wrap m-n1">
                                <?php
                                // Function to fetch categories and subcategories recursively<?php
function fetchCategories($parentCategory = NULL, $level = 0) {
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
        $categories = array_merge($categories, fetchCategories($row['id'], $level + 1));
    }

    return $categories;
}

// Fetch categories and subcategories recursively
$categories = fetchCategories();

// Display categories and subcategories as buttons
foreach ($categories as $category) {
    $indentation = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $category['level']);
    echo '<a href="category.php?catid='.$category['id'].'" class="btn btn-sm btn-outline-secondary m-1">' . $indentation . $category['name'] . '</a><br>';
}
?>


                               
                            </div>
                        </div>
                    </div>
                    <!-- Tags End -->
                </div>
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->
    <?php include('includes/footer.php');?>
