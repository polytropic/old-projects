<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include_once 'db_connect.php';
include_once 'psl-config.php';

$filePath = NULL;
$sizeerr = " ";
$typeerr = " ";

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
    $product_id = $_SESSION['product_id'];

if (!empty($_POST['review']) && isset($_POST['review'])) {
        
echo "<p>Authenticated!</p>";

		$review = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_STRING);

		if(!empty($_FILES['image'])) {
			
		// temporary filename goes on the server

			$tmpName = $_FILES['image']['tmp_name'];
			$fileName = $_FILES['image']['name'];
			$fileSize = $_FILES['image']['size'];
			$fileType = $_FILES['image']['type'];
			$maxsize    = 102400;
			$acceptable = array('image/jpeg','image/jpg','image/gif','image/png','image/bmp');
			$uploadDir = 'images/';
			$filePath = $uploadDir . $fileName;

			if(	($_FILES['image']['size'] >= $maxsize) && (!empty($_FILES["image"]["size"]))	) {

				$filePath = NULL;
				return;
			}

			if(	(!in_array($_FILES['image']['type'], $acceptable)) && (!empty($_FILES["image"]["type"]))) {

				$filePath = NULL;
				return;
			}
				$result = move_uploaded_file($tmpName, $filePath);
		}  
			
	if (!$result)
		{
	$filePath=NULL;
		}

			if (empty($error_msg)) {

				$review = mysqli_real_escape_string($mysqli,$_POST['review']);
				$review = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_STRING);
				if ($insert_stmt = $mysqli->prepare("INSERT INTO reviews (product_id, username, review, image) VALUES (?, ?, ?, ?)")) {
					$insert_stmt->bind_param('ssss', $product_id, $username, $review, $filePath);
					// run the query
					$insert_stmt->execute();
				}
						header('Location: '.$_SERVER['PHP_SELF']);
				exit();
		        }
}


