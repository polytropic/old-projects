<?php
    include_once '../includes/functions.php';
    sec_session_start();
	include_once '../forumheader.php';	
	include_once '../includes/db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


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
		      <strong>Topic</strong><br />
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


$sql = "SELECT
			topic_id,
			topic_subject
		FROM
			topics
		WHERE
			topics.topic_id = " . mysqli_real_escape_string($mysqli, $_GET['id']);
			
$result = mysqli_query($mysqli, $sql);

if(!$result)
{
	echo 'The topic could not be displayed, please try again later.';
}
else
{
	if(mysqli_num_rows($result) == 0)
	{
		echo 'This topic doesn&prime;t exist.';
	}
	else
	{
		while($row = mysqli_fetch_assoc($result))
		{
			//show post
			echo '<table class="topic" border="1">
					<tr>
						<th colspan="2">' . $row['topic_subject'] . '</th>
					</tr>';
		
			//pull from db
			$posts_sql = "SELECT
						posts.post_topic,
						posts.post_content,
						posts.post_date,
						posts.post_by,
						members.id,
						members.username
					FROM
						posts
					LEFT JOIN
						members
					ON
						posts.post_by = members.id
					WHERE
						posts.post_topic = " . mysqli_real_escape_string($mysqli, $_GET['id']);
						
			$posts_result = mysqli_query($mysqli, $posts_sql);
			
			if(!$posts_result)
			{
				echo '<tr><td>The posts could not be displayed, please try again later.</tr></td></table>';
			}
			else
			{
			
				while($posts_row = mysqli_fetch_assoc($posts_result))
				{
					echo '<tr class="topic-post">
							<td class="user-post">' . $posts_row['username'] . '<br/>' . date('d-m-Y H:i', strtotime($posts_row['post_date'])) . '</td>
							<td class="post-content">' . htmlentities(stripslashes($posts_row['post_content'])) . '</td>
						  </tr>';
				}
			}
			
			if(login_check($mysqli) == false)
			{
				echo '<tr><td colspan=2>You must be logged in to post in the forum. Please <a href="../index.php">login</a>.';
			}
			else
			{
				//display the reply box
				echo '<tr><td colspan="2"><h2>Reply:</h2><br />
					<form method="post" action="reply.php?id=' . $row['topic_id'] . '">
						<textarea name="reply-content" maxlength="500"></textarea><br /><br />
						<input type="submit" value="Submit reply" />
					</form></td></tr>';
			}
			
			//close table
			echo '</table>';
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

