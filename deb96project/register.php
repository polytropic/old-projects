<?php 
        ob_start();
		include_once 'header.php';	
        include_once 'includes/functions.php';
        sec_session_start();
    	include_once 'includes/register.inc.php';

?>
 
<body>


<?php
	include("nav.php");	
?>
	
	<div id = "main">	

	    <p>Register a new account</p>

        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>

        <ul>
            <li>Usernames may only contain letters, numbers, and underscores.</li>
            <li>Emails must be valid.</li>
            <li>Passwords must be at least six characters, and must contain at least one uppercase letter, lowercase letter, and at least one number.</li>
        </ul>

        <form method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
            username: <input type='text' name='username' id='username' value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" /> <br>
            email address: <input type="text" name="email" id="email" value="<?php if (isset($_POST[''])) echo $_POST['email']; ?>" /><br>
            password: <input type="password"
                             name="password" 
                             id="password"/><br>
            confirm password: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" /><br>
            <input type="button" 
                   value="Register" 
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /> 
        </form>

        <p>Return to the <a href="index.php">login page</a>.</p>


 	</div>
	
<?php
	include("footer.php");	
?>

</body>
</html>
 

