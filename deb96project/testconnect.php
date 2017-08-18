<html>
 <head>
 </head>
 <body>
 <h1>PHP connect to MySQL</h1>


<?php

/*
* This page isn't used in the project.  It is only used for quickly doing connection tests when migrating the project.
*/
$mysqli = new mysqli("lastleaf.deb96project.com", "denisebigelowcom", "claxon38", "secure_login");


if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

if (!$mysqli->query("SET a=1")) {
    printf("Errormessage: %s\n", $mysqli->error);
}

/* close connection */
$mysqli->close();
?>


</body>
</html>