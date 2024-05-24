<?php
// Include the database connection file
include('includes/config.php');

// Fetch parent categories from the database
$query = "SELECT id, CategoryName FROM tblcategory where is_active!=0"; 
$result = mysqli_query($con, $query);

// Check if query executed successfully
if($result) {
    // Loop through the result set and generate HTML options
    while($row = mysqli_fetch_assoc($result)) {
        echo "<option value='".$row['id']."'>".$row['CategoryName']."</option>";
    }
} else {
    echo "<option value=''>No parent categories found</option>";
}

// Close the database connection
mysqli_close($con);

