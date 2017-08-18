<?php 
    ob_start();
	include_once 'header.php';	
    include_once 'includes/functions.php';
    sec_session_start();
	include_once 'includes/db_connect.php';

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
$_SESSION["product_id"] = "1";

?>
 
<body>

<?php
	include("nav.php");	
?>
	
	<div id = "main">	

		<p>
		      <strong>Black Tea</strong><br />
		</p>

		<p>
		<img src="blacktea.jpg" alt="blacktea"><br />
		</p>
		
		<p>
		      <strong>Description:</strong> This spicy black tea blends orange peel, cinnamon, and spices with Ceylon tea and Chinese black tea from the Hunan Province. Strong, with sweet notes, but a warm finish.<br />
		</p>
		
		<p>
		<strong>Reviews: </strong>
		</p>
        <?php if (login_check($mysqli) == true) : ?>
		
		
<?php
 
include('reviews.php')
?>

		
        <p>You are logged in as <?php echo htmlentities($_SESSION['username']); ?>!</p>

        <?php else : ?>
            <p>
                <span class="error">You must be logged in to leave reviews.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
		
		
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 

		
	</div>
	
<?php
	include("footer.php");	
?>

</body>
</html>

