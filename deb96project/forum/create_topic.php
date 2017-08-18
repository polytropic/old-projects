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
$subject = "";
?>
 
<body>

<?php
	include("../forumnav.php");	
?>
	
	<div id = "main">	

		<p>
		      <strong>Create new topic</strong><br />
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
        //pull database categories to show in dropdown
        $sql = "SELECT cat_id, cat_name, cat_description FROM categories";
         
        $result = mysqli_query($mysqli, $sql);
         
        if(!$result)
        {
            //query error
            echo 'Error while selecting from database. Please try again later.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                //prevents creating topic without a category
                if($_SESSION['user_level'] == 1)
                {
                    echo 'You have not created categories yet.';
                }
                else
                {
                    echo 'Before you can post a topic, you must wait for an admin to create some categories.';
                }
            }
            else
            {
		

		 $id = mysqli_real_escape_string($mysqli, $_SESSION['id']);

                echo '<form method="post" action="">
				    <table>
                    <tr><td>Subject: </td><td><input type="text" name="topic_subject" /></td></tr>
                    <tr><td>Category: </td><td>'; 
                 
                echo '<select name="topic_cat">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                    }
                echo '</select></td></tr>'; 
                     
                echo '<tr><td>Message: </td><td><textarea name="post_content" maxlength="255"></textarea></td></tr>
                    <tr><td><input type="submit" value="Create topic" /></td></tr>
                 </table>
				 </form>';
            }
        }
    }

    else
    {
        //start on the query
        $query  = "BEGIN WORK;";
        $result = mysqli_query($mysqli, $query);
         
        if(!$result)
        {
            //exit if query fails
            echo 'An error occured while creating your topic. Please try again later.';
        }
        else
        {


$id = mysqli_real_escape_string($mysqli, $_SESSION['id']);

            //write new topic into table, then write new post into table
            $sql = "INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by)VALUES('" . mysqli_real_escape_string($mysqli, $_POST['topic_subject']) . "', NOW(),'" . mysqli_real_escape_string($mysqli, $_POST['topic_cat']) . "', $id)";            

	if (empty($_POST['topic_subject'])) {
		echo 'Subject cannot be blank.<br />';
		echo 'Go <a href="create_topic.php">back</a>.';
		return;
	}       
		   $result = mysqli_query($mysqli, $sql);
            if(!$result)
            {
                //print error
                echo 'An error occured while inserting your data. Please try again later.' . mysqli_error();
                $sql = "ROLLBACK;";
                $result = mysqli_query($mysqli, $sql);
            }
            else
            {
                //get the new topic id
                $topicid = mysqli_insert_id($mysqli);
                 
                $sql = "INSERT INTO
                            posts(post_content,
                                  post_date,
                                  post_topic,
                                  post_by)
                        VALUES
                            ('" . mysqli_real_escape_string($mysqli, $_POST['post_content']) . "',
                                  NOW(),
                                  " . $topicid . ",
                                  " . $id . "
                            )";
                $result = mysqli_query($mysqli, $sql);
                 
                if(!$result)
                {
                    //print error
                    echo 'An error occured while inserting your post. Please try again later.' . mysqli_error();
                    $sql = "ROLLBACK;";
                    $result = mysqli_query($mysqli, $sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysqli_query($mysqli, $sql);
                     
                    //query successful
                    echo 'You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
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

