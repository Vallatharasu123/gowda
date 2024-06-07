  <!-- Navigation -->
  <?php include('includes/header.php');?>
<?php 

//Genrating CSRF Token
if (empty($_SESSION['token'])) {
 $_SESSION['token'] = bin2hex(random_bytes(32));
}

if(isset($_POST['submit']))
{
  //Verifying CSRF Token
if (!empty($_POST['csrftoken'])) {
    if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
$name=$_POST['name'];
$email=$_POST['email'];
$comment=$_POST['comment'];
$postid=intval($_GET['pid']);
$st1='0';
$query=mysqli_query($con,"insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
if($query):
  echo "<script>alert('comment successfully submit. Comment will be display after admin review ');</script>";
  unset($_SESSION['token']);
else :
 echo "<script>alert('Something went wrong. Please try again.');</script>";  

endif;

}
}
}
$postid=intval($_GET['pid']);

// Check if the post has been viewed in this session
if (!isset($_SESSION['viewed_posts'])) {
  $_SESSION['viewed_posts'] = [];
}

if (!in_array($postid, $_SESSION['viewed_posts'])) {
  // If not viewed, increase view counter and mark as viewed
  $sql = "SELECT viewCounter FROM tblposts WHERE id = '$postid'";
  $result = $con->query($sql);

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $visits = $row["viewCounter"];
          $sql = "UPDATE tblposts SET viewCounter = $visits+1 WHERE id ='$postid'";
          $con->query($sql);
      }
      // Mark this post as viewed in this session
      $_SESSION['viewed_posts'][] = $postid;
  } else {
      echo "0";
  }
}else{
  $sql = "SELECT viewCounter FROM tblposts WHERE id = '$postid'";
  $result = $con->query($sql);
  
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $visits = $row["viewCounter"];
       
    }
    // Mark this post as viewed in this session
    $_SESSION['viewed_posts'][] = $postid;
} else {
    echo "0";
}
}
    


?>



  

    <!-- Page Content -->
    <div class="container">


     
      <div class="row" style="margin-top: 4%">
      <div class="col-md-2">
        AD
      </div>

    
        <div class="col-md-8">
  
          <!-- Blog Post -->
<?php
$pid=intval($_GET['pid']);
$currenturl="http://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];;
 $query=mysqli_query($con,"select tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url,tblposts.postedBy,tblposts.lastUpdatedBy,tblposts.UpdationDate from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId  where tblposts.id='$pid'");
while ($row=mysqli_fetch_array($query)) {
?>

          <div class="card mb-4">
      
            <div class="card-body">
              <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>
<!--category-->
 <a class="badge bg-secondary text-decoration-none link-light" href="category.php?catid=<?php echo htmlentities($row['cid'])?>" style="color:#fff"><?php echo htmlentities($row['category']);?></a>
<!--Subcategory--->


<p>
             
          <b>Posted by </b> <?php echo htmlentities($row['postedBy']);?> on </b><?php echo htmlentities($row['postingdate']);?> |
          <?php if($row['lastUpdatedBy']!=''):?>
          <b>Last Updated by </b> <?php echo htmlentities($row['lastUpdatedBy']);?> on </b><?php echo htmlentities($row['UpdationDate']);?></p>
        <?php endif;?>
                <p><strong>Share:</strong> <a href="https://www.facebook.com/share.php?u=<?php echo $currenturl;?>" target="_blank">Facebook</a> | 
<a href="https://twitter.com/share?url=<?php echo $currenturl;?>" target="_blank">Twitter</a> |
<a href="https://web.whatsapp.com/send?text=<?php echo $currenturl;?>" target="_blank">Whatsapp</a> | 
<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $currenturl;?>" target="_blank">Linkedin</a>  <b>Visits:</b> <?php print $visits; ?>
                </p>
                <hr />

 <img class="img-fluid rounded" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
  
              <p class="card-text"><?php 
$pt=$row['postdetails'];
              echo  (substr($pt,0));?></p>
             
            </div>
            <div class="card-footer text-muted">
             
           
            </div>
          </div>
<?php } ?>
       

      

<div class="card my-4">
            <div class="card-header">
              <h5 class="card-title">
              Leave a Comment:
              </h5>
              
            </div>
            <div class="card-body">
              <form name="Comment" method="post">
              <?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token if not already set
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
?>
      <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
 <div class="form-group m-2">
<input type="text" name="name" class="form-control" placeholder="Enter your fullname" required>
</div>

 <div class="form-group m-2">
 <input type="email" name="email" class="form-control" placeholder="Enter your Valid email" required>
 </div>


                <div class="form-group m-2">
                  <textarea class="form-control" name="comment" rows="3" placeholder="Comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary m-2" name="submit">Submit</button>
              </form>
            </div>
          </div>

  <!---Comment Display Section --->

 <?php 
 $sts=1;
 $query=mysqli_query($con,"select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
while ($row=mysqli_fetch_array($query)) {
?>
<div class="container mt-4">
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <?php echo htmlentities($row['name'][0]); ?>
                    </div>
                    <div class="ms-3">
                        <h5 class="card-title mb-0"><?php echo htmlentities($row['name']); ?></h5>
                        <small class="text-muted">at <?php echo htmlentities($row['postingDate']); ?></small>
                    </div>
                </div>
                <p class="card-text"><?php echo htmlentities($row['comment']); ?></p>
            </div>
        </div>
    </div>
<?php } ?>


        </div>
        <div class="col-md-2">

        AD
        </div>
      </div>
      <!-- /.row -->
<!---Comment Section --->

    </div>

  
      <?php include('includes/footer.php');?>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
