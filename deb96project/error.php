<?php 
    ob_start();
	include_once 'header.php';	
    $error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

if (! $error) {
    $error = 'Oops! An unknown error happened.';
}
?>
<?php
    sec_session_start();
	include_once 'includes/register.inc.php';
    include_once 'includes/functions.php';
?>
 
<body>


<?php
	include("nav.php");	
?>
	
	<div id = "main">	

	    <p>There was a problem</p>

        <p class="error"><?php echo $error; ?></p>  
		
 	</div>
	
<?php
	include("footer.php");	
?>

</body>
</html>