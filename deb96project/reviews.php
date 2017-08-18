<?php

	include_once 'includes/db_connect.php';
 	include_once 'includes/reviews.inc.php';
    include_once 'includes/functions.php';

?>
		
        <form enctype="multipart/form-data" method="post" name="review_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
		    <fieldset><legend>Leave a review: </legend>	
                   <p>
				   <textarea name="review" rows="6" cols="80" maxlength="255" id="review"></textarea>
				   </p><br>
            <input name="MAX_FILE_SIZE" value="102400" type="hidden">
            <input name="image" accept="image/jpeg" id="image" type="file">
			<label for="image">*Attach photo (optional). Only image files less than 102.4kb will be uploaded</label><br><br>
	        <input type="hidden" name="product_id" value="<?php echo $_SESSION['product_id'];?>" id="product_id" />
			<input type="hidden" name="username" value="<?php echo $_SESSION['username'];?>" id="username" />
            <input type="button" value="Submit Review"  onclick="return revformhash(this.form, this.form.review, this.form.product_id, this.form.username, this.form.image);" />			
            </fieldset>								   
        </form>
		
	    <p><strong>Older Reviews: </strong></p>
<?php
include 'includes/getreviews.inc.php';

?>

