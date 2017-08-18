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
		      <strong>Welcome!</strong><br />
		</p>

        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
        <form action="includes/process_login.php" method="post" name="login_form"> 			
            Email: <input type="text" name="email" /><br />
            Password: <input type="password" 
                             name="password" 
                             id="password"/><br />
            <input type="button" 
                   value="Login" 
                   onclick="formhash(this.form, this.form.password);" /> 
        </form>
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

