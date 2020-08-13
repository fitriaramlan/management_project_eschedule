<?php require_once('../Connections/koneksi.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$colname_rsuser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsuser = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsuser = sprintf("SELECT * FROM tblkaryawan WHERE email = %s", GetSQLValueString($colname_rsuser, "text"));
$rsuser = mysql_query($query_rsuser, $koneksi) or die(mysql_error());
$row_rsuser = mysql_fetch_assoc($rsuser);
$totalRows_rsuser = mysql_num_rows($rsuser);


$colname_rshal = "-1";
if (isset($_GET['idhal'])) {
  $colname_rshal = $_GET['idhal'];
}
$colname1_rshal = "-1";
if (isset($_GET['namahal'])) {
  $colname1_rshal = $_GET['namahal'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rshal = sprintf("SELECT * FROM tblhalaman WHERE idhal = %s and namahal = %s", GetSQLValueString($colname_rshal, "int"),GetSQLValueString($colname1_rshal, "text"));
$rshal = mysql_query($query_rshal, $koneksi) or die(mysql_error());
$row_rshal = mysql_fetch_assoc($rshal);
$totalRows_rshal = mysql_num_rows($rshal);$colname_rshal = "-1";




?>
 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Time Schedule | helps you to manage your precious time</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="../module_admin/css/bootstrap.min.css" rel="stylesheet">
<link href="../module_admin/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="../module_admin/css/font-awesome.css" rel="stylesheet">
<link href="../module_admin/css/style.css" rel="stylesheet">
<link href="../module_admin/css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="../index.php">TimeSchedule </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
        <li><a href="invite.php">Invite a Friend</a></li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> Welcome , <?php echo $_SESSION['MM_Username']; ?>	 <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a  href="console.php?idhal=40&namahal=md_profile/my_profile.php">Profile</a></li>
              <li><a href="<?php echo $logoutAction ?>">Logout</a></li>
            </ul>
          </li>
        </ul>
        <form class="navbar-search pull-right">
          <input type="text" class="search-query" placeholder="Search">
        </form>
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li class="active"><a href="index.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="console.php?idhal=30&namahal=schedule.php"><i class="icon-list-alt"></i><span>Calendar</span> </a> </li>
        <li><a href="console.php?idhal=50&namahal=md_upload/data_project.php"><i class="icon-long-arrow-down"></i><span>File</span> </a></li>
        <li><a href="console.php?idhal=70&namahal=md_timeline/timeline.php"><i class="icon-bar-chart"></i><span>Timeline</span> </a> </li>
          <li><a href="console.php?idhal=60&namahal=md_user/data_user.php"><i class="icon-user"></i><span>User</span> </a> </li>
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
        
          <!-- /widget -->
          <div class="widget">
            <div class="widget-header"> <i class="icon-file"></i>
              <h3><?php echo $row_rshal['ket']; ?> </h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <?php include($row_rshal['namahal']); ?>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
        </div>
       
      </div> 
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12">2014 &copy; TimeSchedule | Fitria Wulandari. </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="../module_admin/js/jquery-1.7.2.min.js"></script> 
<script src="../module_admin/js/excanvas.min.js"></script> 
<script src="../module_admin/js/chart.min.js" type="text/javascript"></script> 
<script src="../module_admin/js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="../module_admin/js/full-calendar/fullcalendar.min.js"></script>
 
<script src="js/base.js"></script> 
 
</body>
</html>
<?php
mysql_free_result($rsuser);

mysql_free_result($rshal);
?>
