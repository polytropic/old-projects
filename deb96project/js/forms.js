    //Javascript to handle form validation for login and registration functionality.

function formhash(form, password) {
    // Create input element for password
    var p = document.createElement("input");
    // Add the new element to form
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = password.value;
    // Avoids sending plain text pw
    password.value = "";
    // Submit form 
    form.submit();
}

function regformhash(form, uid, email, password, conf) {
    // Make sure none are blank
    if (uid.value == '' || email.value == '' || password.value == '' || conf.value == '') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }
    // Check the username
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.username.focus();
        return false; 
    }
    
    // Check that the password is long enough (min 6 chars)
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }
    // At least one number, one lowercase and one uppercase letter, and at least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }
    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
    // Create new element 
    var p = document.createElement("input");
    // Add the new element to form
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = password.value;
    // Avoid sending plain text pw
    password.value = "";
    conf.value = "";
    // Submit
    form.submit();
    return true;
}

function revformhash(form, review, product_id, username, image) {

    // Check each field has a value
    if (review.value == '') {
       alert('You must provide all the requested details. Please try again');
        return false;
   }

    // Submit
    form.submit();
    return true;
}

