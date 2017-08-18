<?php 
        ob_start();
		include_once 'header.php';	
	    include_once 'includes/functions.php';
        sec_session_start();

		
?>
 
<body>

<?php
	include("nav.php");	
?>
	
	<div id = "main">	

        <p>Registration successful!<br />
        Please return to the <a href="index.php">login page</a> to log in.</p>
		
	</div>
	
<?php
	include("footer.php");	
?>

</body>
</html>

