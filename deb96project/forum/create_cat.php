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
		      <strong>Create new category</strong><br />
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

if($_SESSION['user_level'] == 0)

                {
                    echo 'You do not have permission to create categories.';
					return;
                }


if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	
    //display the form
    echo '<form method="post">
	<table>
	<tr><td>Category name: </td><td><input type="text" name="cat_name" maxlength="55"/></td></tr>
	<tr><td>Category description: </td><td><textarea name="cat_description" maxlength="255">
	</textarea></td></tr>
	<tr><td><input type="submit" value="Add category" /></td></tr>
	</table>
	</form>';
	 
}
else
{
    //save the posted form
    $sql = "INSERT INTO categories(cat_name, cat_description)VALUES('" . mysqli_real_escape_string($mysqli, $_POST['cat_name']) . "','" . mysqli_real_escape_string($mysqli, $_POST['cat_description']) . "')";
    $catname = $_POST['cat_name'];
	$prep_stmt = "SELECT cat_id FROM categories WHERE cat_name = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
		if ($stmt){

        $stmt->bind_param('s', $catname);

        $stmt->execute();
        
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            //prevents duplicate categories
 		echo 'Category already exists.<br />';
		echo 'Go <a href="create_cat.php">back</a>.';
		return;       
        }
    
	}

	
	if (empty($catname)) {
		echo 'Name cannot be blank.<br />';
		echo 'Go <a href="create_cat.php">back</a>.';
		return;
	}

	else{
    $result = mysqli_query($mysqli, $sql);
    if(!$result)
    {
        //print error
        echo 'Error' . mysqli_error();
    }
    else
    {
        echo 'New category successfully added.';
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

