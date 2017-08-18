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
	$_SESSION["product_id"] = "2";
?>
 
<body>

<?php
	include("nav.php");	
?>
	
	<div id = "main">	

		<p>
		      <strong>Green Tea</strong><br />
		</p>

		<p>
		<img src="greentea.jpg" alt="greentea"><br />
		</p>
		
		<p>
		      <strong>Description:</strong> Our green tea is a Chinese blend of gunpowder-style pellets.  Smoky and vegetal, this tea is excellent hot or iced.<br />
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

