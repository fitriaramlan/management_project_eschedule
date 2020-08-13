<?php

include("db.php");
	  
if(isset($_REQUEST['post'])){


$tuturl = $_POST['tuturl'];
$qazi_id = $_POST['tutid2'];
$name = $_POST['name'];
$url = $_POST['website'];
$email = $_POST['email'];
$description = $_POST['message'];
$date = date("F j, Y; g:i a");


//Check form
if ($name == '' || $email == '' || $description == ''){
	
	echo'Please fill in all fields before submitting the comment.';
	exit();
}


//Check Email
function check_email_address($email) {
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
         if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            return false;
        }
    }    
    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
}

if (!check_email_address($email)) {
    echo $email . ' is not a valid email address.';
	exit();
} 


//Submit data
$query = "INSERT INTO comments VALUES('','$qazi_id','$name','$email','$description','$url','$date')";
mysql_query($query);
echo "<h1>Submission Successful</h1>";
echo "Your comment has been submitted.  You will now be redirected back to the last page you visited.  Thanks!";
echo "<meta http-equiv='refresh' content='2;URL=$tuturl'>";
} else {
echo "There was an error with the submission. ";
}


?>