<?php require_once('../Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
if (isset($_POST['e-mail'])) {
  $loginUsername=$_POST['e-mail'];
  $password=$_POST['Password'];
  $MM_fldUserAuthorization = "idakseslavel";
  $MM_redirectLoginSuccess = "../page/index.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_koneksi, $koneksi);
  	
  $LoginRS__query=sprintf("SELECT email, password, idakseslavel, id_karyawan FROM tblkaryawan WHERE email=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $koneksi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $loginFoundKaryawan = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'idakseslavel');
	$loginStrKaryawan  = mysql_result($LoginRS,0,'id_karyawan');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
	$_SESSION['MM_idkaryawan'] = $loginStrKaryawan;      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Time Schedule | helps you to manage your precious time</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="../module_admin/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../module_admin/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="../module_admin/css/font-awesome.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="../module_admin/css/style.css" rel="stylesheet" type="text/css">
<link href="../module_admin/css/pages/signin.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="index.php"> TimeSchedule </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class=""> <a href="signup.php" class=""> Don't have an account? </a> </li>
          <li class=""> <a href="index.php" class=""> <i class="icon-chevron-left"></i> Back to Homepage </a> </li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
      
    </div>
    <!-- /container --> 
    
  </div>
  <!-- /navbar-inner --> 
  
</div>
<!-- /navbar -->

<div class="account-container">
  <div class="content clearfix">
    <form action="<?php echo $loginFormAction; ?>" method="POST" id="frmlog">
      <h1>Member Login</h1>
      <div class="login-fields">
        <p>Please provide your details</p>
        <div class="field">
          <label for="e-mail">Email</label>
          <input type="text" id="e-mail" name="e-mail" value="" placeholder="Email" class="login username-field" />
        </div>
        <!-- /field -->
        
        <div class="field">
          <label for="Password">Password:</label>
          <input type="password" id="Password" name="Password" value="" placeholder="Password" class="login password-field"/>
        </div>
        <!-- /password --> 
        
      </div>
      <!-- /login-fields -->
      
      <div class="login-actions"> <br>
        
        <input type="submit" value="Login" />
      </div>
      <!-- .actions -->
      
    </form>
  </div>
  <!-- /content --> 
  
</div>
<!-- /account-container -->

<div class="login-extra"> <a href="#">Reset Password</a> </div>
<!-- /login-extra --> 

<script src="../module_admin/js/jquery-1.7.2.min.js"></script> 
<script src="../module_admin/js/bootstrap.js"></script> 
<script src="../module_admin/js/signin.js"></script>
</body>
</html>
