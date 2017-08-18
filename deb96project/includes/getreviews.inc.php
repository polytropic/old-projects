<?php

include_once 'db_connect.php';
include_once 'psl-config.php';

$error_msg = "";

   $product_id = $_SESSION['product_id'];

if( ! is_numeric($product_id) )
  die('invalid product id');

// There are only 3 "products," so each of the three types of tea is just hard-coded a number, and reviews are pulled from the database for that number.
if($product_id == "1") {

  $getreviews="SELECT review_id, review_date, username, review, image FROM reviews WHERE product_id = 1 ORDER BY review_date DESC";
}

if($product_id == "2") {

  $getreviews="SELECT review_id, review_date, username, review, image FROM reviews WHERE product_id = 2 ORDER BY review_date DESC";
}

if($product_id == "3") {

  $getreviews="SELECT review_id, review_date, username, review, image FROM reviews WHERE product_id = 3 ORDER BY review_date DESC";
}

 $get_stmt = $mysqli->prepare($getreviews);


if($get_stmt === false) {
  trigger_error('Wrong SQL: ' . $getreviews . ' Error: ' . $mysqli->error, E_USER_ERROR);
}


$stmt = mysqli_query($mysqli, $getreviews);

while($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC))
{
  
  $review_id = $row['review_id'];
  $review_date = $row['review_date'];
  $username = $row['username'];
  $review = $row['review'];
  $image = $row['image'];


  echo "

      <p>
	  <strong>Review ID: </strong> $review_id<br />
      <strong>Date:</strong> $review_date<br />
      <strong>User:</strong> $username<br />
      <strong>Review:</strong> $review<br />
      <strong>Image:</strong>

       ";
	  
if ($image == null)
{
       echo ' none/invalid <br />';  
} 
else
{
//  Image thumbnails are displayed, but also function as links to open the fullsize image in a new window.

    echo '<a target="_blank" href="';
	echo $image;
	echo '">';
	echo '<img src="';
    echo $image;
	echo '" height="50" width="50">';
	echo '</a>';

    echo "</p>";
//    echo '<img src="images/no_images.jpg">';  This could be used for expanded image error checking
}

//save in project/images
  
}


mysqli_close($mysqli);




