<?php
/* User login process, checks if user exists and password is correct */
//ini_set('display_errors',True);
session_start();
require 'db.php';
function password_verify1($a,$b)
{return $a==$b;}
// Escape email to protect against SQL injections
 //if(!isset($_POST["submit"])){
   //     exit("wrong");
$email = mysql_real_escape_string($_POST['email']);

$query = mysql_query("SELECT * FROM Users WHERE email='".$email."'");
//echo mysql_num_rows($query);
if ( mysql_num_rows($query) == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist!";
    header("location: error.php");
}
else { // User exists
    $user = mysql_fetch_assoc($query);
	//var_dump($user);
    if ( password_verify1($_POST['Password'], $user['Password']) ) {
        
        $_SESSION['email'] = $user['email'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
		$_SESSION['username'] = $user['username'];
        //$_SESSION['active'] = $user['active'];
        
        // This is how we'll know the user is logged in
       // $_SESSION['logged_in'] = true;
        header("location: profile.php");
    }
    else {
        $_SESSION['message'] = "You have entered wrong password, try again!";
        header("location: error.php");
    }
}