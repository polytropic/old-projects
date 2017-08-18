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
		      <strong>Forum</strong><br />
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

$sql = "SELECT cat_id, cat_name, cat_description FROM categories";


 $get_stmt = $mysqli->prepare($sql);


if($get_stmt === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
}
 
$result = mysqli_query($mysqli, $sql);

if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        //prepare the table
        echo '<table>
              <tr>
                <th class="leftpart"><h3>Category</h3></th>
                <th><h3>Last topic</h3></th>
              </tr>
			  </table>'; 
                     echo '<table>';
        while($row = mysqli_fetch_assoc($result))
        {   
            echo '<tr>';
                echo '<td class="leftpart">';
					echo '<h3><a href="category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';
				
				//pulls the most recent topic for each category
					$topicsql = "SELECT
									topic_id,
									topic_subject,
									topic_date,
									topic_cat
								FROM
									topics
								WHERE
									topic_cat = " . $row['cat_id'] . "
								ORDER BY
									topic_date
								DESC
								LIMIT
									1";
								
					$topicsresult = mysqli_query($mysqli, $topicsql);
				
					if(!$topicsresult)
					{
						echo 'Last topic could not be displayed.';
					}
					else
					{
						if(mysqli_num_rows($topicsresult) == 0)
						{
							echo 'no topics';
						}
						else
						{
							while($topicrow = mysqli_fetch_assoc($topicsresult))
							echo '<a href="topic.php?id=' . $topicrow['topic_id'] . '">' . $topicrow['topic_subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['topic_date']));
						}
					}

				
                echo '</td>';
            echo '</tr>';
        }
		echo '</table>';
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

