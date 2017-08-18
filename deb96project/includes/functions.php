<?php 
    ob_start();
    include_once 'psl-config.php';

function sec_session_start() {
    $session_name = 'sec_session_id';   
    $secure = SECURE;
    $httponly = true;

    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    session_name($session_name);

    session_start();           
    session_regenerate_id();   
}

function login($email, $password, $mysqli) {
    // prepared statement
    if ($stmt = $mysqli->prepare("SELECT id, username, password, user_level, id
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  
        $stmt->execute();    // run the query
        $stmt->store_result();
 
        // get variables from result
        $stmt->bind_result($user_id, $username, $db_password, $user_level, $id);
        $stmt->fetch();
 
        if ($stmt->num_rows == 1) {
            // make sure account does not have too many failed login attempts

            if (checkbrute($user_id, $mysqli) == true) {
                // do not allow login

                return false;
            } else {
				
				$password = md5($password);
                // compare password with password in database
                if (hash_equals($password, $db_password)) {

                    // get the string
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
					$_SESSION['user_level'] = $user_level;
					$_SESSION['id'] = $id;
					$_SESSION['login_string'] = $db_password . $user_browser;
                    // login success

                    return true;
                } else {
                    // wrong password; count the bad attempt
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // not a user
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    // current timestamp
    $now = time();

    // check two hours of login attempts
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time 
                                  FROM login_attempts 
                                  WHERE user_id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // run query
        $stmt->execute();
        $stmt->store_result();

        // max of 5 attempts allowed
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    } else {
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}

function login_check($mysqli) {
    // check session vars
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // get user string
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password 
				      FROM members 
				      WHERE id = ? LIMIT 1")) {

            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // run query
            $stmt->store_result();

            if ($stmt->num_rows == 1) {

                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = $password . $user_browser;

                if ($login_check == $login_string) {
                    // is logged in
					$_SESSION['username'] = $username;
                    return true;
                } else {
                    // is not logged in
                    return false;
                }
            } else {
                // is not logged in
                return false;
            }
        } else {
            // other error
            header("Location: ../error.php?err=Database error: cannot prepare statement");
            exit();
        }
    } else {
        // is not logged in 
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
    
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
    
    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);
    
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}

