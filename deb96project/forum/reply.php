<?php
    include_once '../includes/functions.php';
    sec_session_start();
	include_once '../forumheader.php';	
	include_once '../includes/db_connect.php';


if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
 
<body>

<?php
	include("../forumnav.php");	
?>
	
	<div id = "main">	

		<p>
		      <strong>Reply</strong><br />
		</p>
		
		
	    <?php if (login_check($mysqli) == true) : ?>
		
    <div id="wrapper">
    <div id="menu">
        <a class="item" href="../forum/forum.php">Home</a> -
        <a class="item" href="../forum/create_topic.php">New topic</a> -
        <a class="item" href="../forum/create_cat.php">New category</a>
             </div>
        <div id="content">

		
		
<?php


if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//disallow direct file access
	echo 'This file cannot be called directly.';
}
else
{
    $replycontent = $_POST['reply-content'];
	if (empty($replycontent)) {
		echo 'Reply cannot be blank.<br />';
		echo 'Go <a href="topic.php?id=' . htmlentities($_GET['id']) . '">back</a>.';
		return;
	}
	else{

	//make sure user is logged in
	if(login_check($mysqli) == false)
	{
		echo 'You must be signed in to post a reply.';
	}
	else
	{
		
		//successful post
		$sql = "INSERT INTO 
					posts(post_content,
						  post_date,
						  post_topic,
						  post_by) 
				VALUES ('" . mysqli_real_escape_string($mysqli, $_POST['reply-content']) . "',
						NOW(),
						" . mysqli_real_escape_string($mysqli, $_GET['id']) . ",
						" . $_SESSION['id'] . ")";
						
		$result = mysqli_query($mysqli, $sql);
						
		if(!$result)
		{
			echo 'Your reply has not been saved, please try again later.';
		}
		else
		{
			echo 'Your reply has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
		}
	}
}
}

?>
		
    </div>

 
	    </div>
		       <?php else : ?>
            <p>
                <span class="error">You must be logged in to post in the forum.</span> Please <a href="../index.php">login</a>.
            </p>
        <?php endif; ?>		
		
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 

        <p>If you don't have a login, please <a href="../register.php">register</a><br />
        If you are done, please <a href="../includes/logout.php">log out</a>.<br />
        You are currently logged <?php echo $logged ?>.</p>
		<?php if (login_check($mysqli) == true) : ?>
        <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>

        <?php endif; ?>
	</div>
	
<?php
	include("../footer.php");	
?>

</body>
</html>

