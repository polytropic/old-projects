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
?>
 
<body>

<?php
	include("nav.php");	
?>
	
	<div id = "main">	

		<p>
		      <strong>About Last Leaf Tea</strong><br />
		</p>
		
		<p>
		      This is a student PHP project website.  It is modeled after an online tea store and features a login and registration system, a product review system, file uploading, and a forum.<br />
		</p>
		
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 

        <p>If you don't have a login, please <a href="register.php">register</a><br />
        If you are done, please <a href="includes/logout.php">log out</a>.<br />
        You are currently logged <?php echo $logged ?>.</p>
		<?php if (login_check($mysqli) == true) : ?>
        <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>

        <?php endif; ?>
		
	</div>
	
<?php
	include("footer.php");	
?>

</body>
</html>

