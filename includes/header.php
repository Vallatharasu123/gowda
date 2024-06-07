<?php
session_start();
include ('includes/config.php');
// SQL query
$sql = "WITH RECURSIVE CategoryHierarchy AS (
            SELECT 
                id, 
                CategoryName, 
                Parent_Category, 
                CategoryName AS path
            FROM 
                tblcategory
            WHERE 
                Parent_Category IS NULL &&
                Is_Active = 1

            UNION ALL

            SELECT 
                c.id, 
                c.CategoryName, 
                c.Parent_Category, 
                CONCAT(ch.path, ' > ', c.CategoryName) AS path
            FROM 
                tblcategory c
            INNER JOIN 
                CategoryHierarchy ch ON c.Parent_Category = ch.id
            WHERE
            Is_Active = 1
        )
        SELECT 
            id, 
            CategoryName, 
            Parent_Category, 
            path
        FROM 
            CategoryHierarchy
        
        ";

// Execute the query
$result = mysqli_query($con, $sql);

// Array to hold categories
$categories = [];

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    // Loop through each row
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
} else {
    echo "No categories found";
}

// Function to build the category tree
function buildTree(array $elements, $parentId = null)
{
    $branch = [];
    foreach ($elements as $element) {
        if ($element['Parent_Category'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}
// Function to generate SEO-friendly URLs
function generateSeoUrl($categoryName, $categoryId) {
    // Convert to lowercase
    $categoryName = strtolower($categoryName);
    // Replace spaces with hyphens
    $categoryName = str_replace(' ', '-', $categoryName);
    // Remove special characters
    $categoryName = preg_replace('/[^a-z0-9-]/', '', $categoryName);
    return "category-".$categoryName . '-' . $categoryId;
}
// Function to render the category tree
function renderTree($tree)
{
    echo '<ul>';
    foreach ($tree as $branch) {
        echo '<li>';
        $seoUrl = generateSeoUrl($branch['CategoryName'], $branch['id']);
        echo '<a href="' . $seoUrl . '">' . $branch['CategoryName'] . '</a>';
        if (isset($branch['children'])) {
            renderTree($branch['children']);
        }
        echo '</li>';
    }
    echo '</ul>';
}

// Build the category tree
$categoryTree = buildTree($categories);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Discover tips for achieving financial independence, healthy living, and radiant skin. Learn proven ways to make money online and boost your mood and metabolism with exercise.">
<meta name="author" content="Gowda">
<meta name="keywords" content="personal finance, make money online, financial independence, health tips, fitness, skincare, healthy living, radiant skin, exercise, boost mood, metabolism">
<title>HelloGowda </title>
<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Abyssinica+SIL&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css?v=2" rel="stylesheet">

</head>

<body>
    <!-- Topbar Start -->
    
    <div class="container-fluid d-none d-lg-block">
        <div class="row align-items-center bg-primary  px-lg-5">
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-sm  p-0">
                    <ul class="navbar-nav ml-n2">
                        <li class="nav-item ">
                            <a class="nav-link text-white small" id="currentDate" href="#"></a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white small" href="about-us.php">About</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white small" href="contact-us.php">Contact </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white small" href="terms-and-conditions.php">Terms And Condition </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white small" href="privacy-policy.php">Privacy Policy </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white small" href="admin/">Login</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 text-right d-none d-md-block">
                <nav class="navbar navbar-expand-sm  p-0">
                    <ul class="navbar-nav ml-auto mr-n2">
                      <?php
                      $query = mysqli_query($con, "SELECT name, htmlCode, socialLink FROM tblsocialmedia WHERE status=1");
                      while($row = mysqli_fetch_array($query)) {
                          echo '<li class="nav-item">
                                  <a class="nav-link text-white " href="' . htmlentities($row['socialLink']) . '">' . $row['htmlCode'] . '</a>
                                </li>';
                      }
                      ?>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row align-items-center bg-white py-3 px-lg-5">
            <div class="col-lg-4">
                <a href="index.php" class="navbar-brand p-0 d-none d-lg-flex align-items-center">
                    <img src="img/logo.png" alt="hellogowda logo " class="d-inline-bllock " width="100">
                    <h1 class="m-0 display-4 text-uppercase text-primary">Hello<span
                            class="text-secondary font-weight-normal">Gowda</span></h1>
                </a>
            </div>
            <div class="col-lg-8 text-center text-lg-right " style="overflow: auto;">

                <div id="ad-list"></div>

            </div>
        </div>
    </div>
    <!-- Topbar End -->

   
    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">
            <a href="index.html" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-4 text-uppercase text-primary">Hello<span
                        class="text-white font-weight-normal">Gowda</span></h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                        data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNavDropdown">

                        <ul class="main-navigation border-right border-white mr-2">
                            <li class="mx-1"><a href="index.php">Home</a></li>

                        </ul>
                        <?php renderTree($categoryTree); ?>
                    </div>
                </nav>
             

                <form name="search" action="search.php" method="post">
              <div class="input-group">
           
        <input type="text" name="searchtitle" class="form-control rounded-0" placeholder="Search for..." required>
                <span class="input-group-btn">
                  <button class="btn btn-primary rounded-0 " type="submit">Go!</button>
                </span>
              </form>
            </div>

        </nav>
    </div>
    <!-- Navbar End -->

<?php

function generateSeoUrlPost($title, $id) {
    // Convert to lowercase
    $title = strtolower($title);
    // Replace spaces with hyphens
    $title = str_replace(' ', '-', $title);
    // Remove special characters
    $title = preg_replace('/[^a-z0-9-]/', '', $title);
    return "post-".$title . '-' . $id;
}
?>