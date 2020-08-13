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

$maxRows_vwproject = 15;
$pageNum_vwproject = 0;
if (isset($_GET['pageNum_vwproject'])) {
  $pageNum_vwproject = $_GET['pageNum_vwproject'];
}
$startRow_vwproject = $pageNum_vwproject * $maxRows_vwproject;

mysql_select_db($database_koneksi, $koneksi);
$query_vwproject = "SELECT * FROM vwproject ORDER BY id_project DESC";
$query_limit_vwproject = sprintf("%s LIMIT %d, %d", $query_vwproject, $startRow_vwproject, $maxRows_vwproject);
$vwproject = mysql_query($query_limit_vwproject, $koneksi) or die(mysql_error());
$row_vwproject = mysql_fetch_assoc($vwproject);

if (isset($_GET['totalRows_vwproject'])) {
  $totalRows_vwproject = $_GET['totalRows_vwproject'];
} else {
  $all_vwproject = mysql_query($query_vwproject);
  $totalRows_vwproject = mysql_num_rows($all_vwproject);
}
$totalPages_vwproject = ceil($totalRows_vwproject/$maxRows_vwproject)-1;


$maxRows_vwkomentar = 10;
$pageNum_vwkomentar = 0;
if (isset($_GET['pageNum_vwkomentar'])) {
  $pageNum_vwkomentar = $_GET['pageNum_vwkomentar'];
}
$startRow_vwkomentar = $pageNum_vwkomentar * $maxRows_vwkomentar;

mysql_select_db($database_koneksi, $koneksi);
$query_vwkomentar = "SELECT * FROM vwkomentar ORDER BY id_komentar DESC";
$query_limit_vwkomentar = sprintf("%s LIMIT %d, %d", $query_vwkomentar, $startRow_vwkomentar, $maxRows_vwkomentar);
$vwkomentar = mysql_query($query_limit_vwkomentar, $koneksi) or die(mysql_error());
$row_vwkomentar = mysql_fetch_assoc($vwkomentar);

if (isset($_GET['totalRows_vwkomentar'])) {
  $totalRows_vwkomentar = $_GET['totalRows_vwkomentar'];
} else {
  $all_vwkomentar = mysql_query($query_vwkomentar);
  $totalRows_vwkomentar = mysql_num_rows($all_vwkomentar);
}
$totalPages_vwkomentar = ceil($totalRows_vwkomentar/$maxRows_vwkomentar)-1;



$maxRows_rsfile = 5;
$pageNum_rsfile = 0;
if (isset($_GET['pageNum_rsfile'])) {
  $pageNum_rsfile = $_GET['pageNum_rsfile'];
}
$startRow_rsfile = $pageNum_rsfile * $maxRows_rsfile;

mysql_select_db($database_koneksi, $koneksi);
$query_rsfile = "SELECT * FROM tblfile ORDER BY id_file DESC";
$query_limit_rsfile = sprintf("%s LIMIT %d, %d", $query_rsfile, $startRow_rsfile, $maxRows_rsfile);
$rsfile = mysql_query($query_limit_rsfile, $koneksi) or die(mysql_error());
$row_rsfile = mysql_fetch_assoc($rsfile);

if (isset($_GET['totalRows_rsfile'])) {
  $totalRows_rsfile = $_GET['totalRows_rsfile'];
} else {
  $all_rsfile = mysql_query($query_rsfile);
  $totalRows_rsfile = mysql_num_rows($all_rsfile);
}
$totalPages_rsfile = ceil($totalRows_rsfile/$maxRows_rsfile)-1;
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
                            class="icon-user"></i> Welcome , <?php echo $_SESSION['MM_Username']	; ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#">Profile</a></li>
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
      
      <?php if($_SESSION['MM_UserGroup']=='1') { ?>
      <ul class="mainnav">
        <li class="active"><a href="page.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="console.php?idhal=30&namahal=schedule.php"><i class="icon-list-alt"></i><span>Calendar</span> </a> </li>
        <li><a href="console.php?idhal=50&namahal=md_upload/data_project.php"><i class="icon-long-arrow-down"></i><span>File</span> </a></li>
        <li><a href="console.php?idhal=70&namahal=md_timeline/timeline.php"><i class="icon-bar-chart"></i><span>Timeline</span> </a> </li>
        
          <li><a href="console.php?idhal=60&namahal=md_user/data_user.php"><i class="icon-user"></i><span>User</span> </a> </li>
          
      </ul>
      <?php } else { ?>
      
      <ul class="mainnav">
        <li class="active"><a href="page.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="console.php?idhal=30&namahal=schedule.php"><i class="icon-list-alt"></i><span>Calendar</span> </a> </li>
        <li><a href="console.php?idhal=50&namahal=md_upload/data_project.php"><i class="icon-long-arrow-down"></i><span>File</span> </a></li>
        <li><a href="console.php?idhal=70&namahal=md_timeline/timeline.php"><i class="icon-bar-chart"></i><span>Timeline</span> </a> </li>
        
          <li><a href="console.php?idhal=60&namahal=md_user/data_user.php"><i class="icon-user"></i><span>User</span> </a> </li>
          
      </ul>
      
      <?php } ?>
      
      
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
<div class="main">
  <div class="main-inner">
    <div class="container">
       <?php if($_SESSION['MM_UserGroup']=='1') { ?>
      <div class="row">
        <div class="span6">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Calendar Project</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div id='calendar'>
              </div>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          <div class="widget">
            <div class="widget-header"> <i class="icon-file"></i>
              <h3> Timeline</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <ul class="messages_layout">
             
                <?php do { ?>
                  <li class="from_user left"> <a href="#" class="avatar"><img src="img/message_avatar2.png"/></a>
                    <div class="message_wrap"> <span class="arrow"></span>
                      <div class="info"> <a class="name"> <?php echo $row_vwkomentar['namalengkap']; ?></a> <span class="time"> <?php echo $row_vwkomentar['tglinput']; ?></span>
                        <div class="options_arrow">
                          <div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
                            <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                              <li><a href="#"><i class=" icon-share-alt icon-large"></i> Reply</a></li>
                              <li><a href="#"><i class=" icon-trash icon-large"></i> Delete</a></li>
                              <li><a href="#"><i class=" icon-share icon-large"></i> Share</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="text"> <?php echo $row_vwkomentar['komentar']; ?></div>
                    </div>
                  </li>
                  <?php } while ($row_vwkomentar = mysql_fetch_assoc($vwkomentar)); ?>
              </ul>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
        </div>
        <!-- /span6 -->
        <div class="span6">
          
          <div class="widget">
            <div class="widget-header"> <i class="icon-signal"></i>
              <h3> Chart Berdasarkan Banyak Pekerjaan</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <canvas id="area-chart" class="chart-holder" height="250" width="538"> </canvas>
              <!-- /area-chart --> 
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3>New Project | <a href="console.php?idhal=10&namahal=md_project/add.php">Add</a></h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th  width="40%"> Title File</th>
                    <th  width="40%"> Banyak Pekerjaan</th>
                    <th width="5%" class="td-actions">Progress</th>
                    <th  width="5%" class="td-actions">Pending</th>
                    <th  width="5%"  class="td-actions">Tidak Selesai</th>
                    <th  width="5%" class="td-actions">Selesai</th>
                  </tr>
                </thead>
                <tbody>
                  <?php do { ?>
                    <tr>
                      <td>
                        <a href="console.php?idhal=20&namahal=md_pekerjaan/add.php&id_project=<?php echo $row_vwproject['id_project']; ?>"> <?php echo $row_vwproject['namaproject']; ?> </a>
                     <div style="width:10px; height:10px; background:#<?php echo $row_vwproject['warna']; ?>"></div> </td>
                      <td>   <?php 
	  mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan = "SELECT * FROM tblpekerjaan WHERE id_project='".$row_vwproject['id_project']."'";
$rspekerjaan = mysql_query($query_rspekerjaan, $koneksi) or die(mysql_error());
$row_rspekerjaan = mysql_fetch_assoc($rspekerjaan);
$totalRows_rspekerjaan = mysql_num_rows($rspekerjaan);
echo $totalRows_rspekerjaan;
?> </td>
                      <td class="td-actions">      <?php 
	  mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan = "SELECT * FROM tblpekerjaan WHERE id_project='".$row_vwproject['id_project']."' and status = 'Progress'";
$rspekerjaan = mysql_query($query_rspekerjaan, $koneksi) or die(mysql_error());
$row_rspekerjaan = mysql_fetch_assoc($rspekerjaan);
$totalRows_rspekerjaan = mysql_num_rows($rspekerjaan);
echo $totalRows_rspekerjaan;
?>
                      </td>
                      <td class="td-actions">  <?php 
	  mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan = "SELECT * FROM tblpekerjaan WHERE id_project='".$row_vwproject['id_project']."' and status = 'Pending'";
$rspekerjaan = mysql_query($query_rspekerjaan, $koneksi) or die(mysql_error());
$row_rspekerjaan = mysql_fetch_assoc($rspekerjaan);
$totalRows_rspekerjaan = mysql_num_rows($rspekerjaan);
echo $totalRows_rspekerjaan;
?></td>
                      <td class="td-actions"> <?php 
	  mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan = "SELECT * FROM tblpekerjaan WHERE id_project='".$row_vwproject['id_project']."' and status = 'Tidak Selesai'";
$rspekerjaan = mysql_query($query_rspekerjaan, $koneksi) or die(mysql_error());
$row_rspekerjaan = mysql_fetch_assoc($rspekerjaan);
$totalRows_rspekerjaan = mysql_num_rows($rspekerjaan);
echo $totalRows_rspekerjaan;
?></td>
                      <td class="td-actions">  <?php 
	  mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan = "SELECT * FROM tblpekerjaan WHERE id_project='".$row_vwproject['id_project']."' and status = 'Selesai'";
$rspekerjaan = mysql_query($query_rspekerjaan, $koneksi) or die(mysql_error());
$row_rspekerjaan = mysql_fetch_assoc($rspekerjaan);
$totalRows_rspekerjaan = mysql_num_rows($rspekerjaan);



echo $totalRows_rspekerjaan;
?></td>
                    </tr>
                    <?php } while ($row_vwproject = mysql_fetch_assoc($vwproject)); ?>
                </tbody>
              </table>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Recent Upload</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <ul class="news-items">
                
                
                <?php 
					
			 function tanggal_format_indonesia($tgl){
            $tanggal = substr($tgl,8,2);
            $bulan   = getBulan(substr($tgl,5,2));
            $tahun   = substr($tgl,0,4);
            return $tanggal.' '.$bulan.' '.$tahun;
   }
 
   function getBulan($bln){
            switch ($bln){
              case 1: 
              return "Januari";
              break;
              case 2:
              return "Februari";
              break;
              case 3:
              return "Maret";
              break;
              case 4:
              return "April";
              break;
              case 5:
              return "Mei";
              break;
              case 6:
              return "Juni";
              break;
              case 7:
              return "Juli";
              break;
              case 8:
              return "Agustus";
              break;
              case 9:
              return "September";
              break;
              case 10:
              return "Oktober";
              break;
              case 11:
              return "November";
              break;
              case 12:
              return "Desember";
              break;
            }
}

?>
                <?php do { ?>
                  <li>                   
                  <div class="news-item-date"> <span class="news-item-day"><?php  
				  
				 

	  $tanggal  = tanggal_format_indonesia($row_rsfile['tglinput']);//memanggil fungsi
      
	 echo substr($tanggal,0,2);
 

; ?></span> <span class="news-item-month"><?php  echo substr($tanggal,3,3); ?></span> </div>
                    <div class="news-item-detail"> <a href="http://www.egrappler.com/thursday-roundup-40/" class="news-item-title" target="_blank"><?php echo $row_rsfile['namafile']; ?># </a><a class="icon-download" title="Download" href="file_project/download.php?id_file=<?php echo $row_rsfile['id_file']; ?>"></a>
                      <p class="news-item-preview"> <?php echo $row_rsfile['ket']; ?> </p>
                    </div>
                    
                  </li>
                  <?php } while ($row_rsfile = mysql_fetch_assoc($rsfile)); ?>
                
                
              </ul>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
        </div>
        <!-- /span6 --> 
      </div>
      <?php } ?>
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


 <script>
//<![CDATA[
	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			//editable: true,
		
		
		 
			
			events: [
				
				 
       <?php 
	   $qw = mysql_query("SELECT * FROM vwproject");  
	    while($data  = mysql_fetch_assoc($qw)){?> 
 
				{
					title: '<?php echo "# ".$data['namaproject']."# ". $data['title']; ?>',
					start: new Date('<?php echo $data['tglmulai']; ?>'),
					end: new Date('<?php echo $data['tglakhir']; ?>'),
					url: '<?php echo $data['url']; ?>',
					 color: '#<?php echo $data['warna']; ?>',
				 
					
			     },
           <?php } ?>
  
				 ]
		});
		
	});
	
	
	 

	 var lineChartData = {labels: [<?php $qwchart = mysql_query("SELECT * FROM vwproject   LIMIT 3");while($datachart  = mysql_fetch_assoc($qwchart)){?>"<?php echo $datachart['namaproject']; ?>",<?php } ?>],
			   datasets: [
			 
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    pointColor: "rgba(151,187,205,1)",
				    pointStrokeColor: "#fff",
					 data: [<?php $qwdatachart = mysql_query("SELECT * FROM vwproject");
					 while($inidatachart  = mysql_fetch_assoc($qwdatachart))
					 { 
					 $qwdatachart2 = mysql_query("SELECT * FROM tblpekerjaan WHERE id_project = '".$inidatachart['id_project']."'");
					 while($inidatachart2  = mysql_fetch_assoc($qwdatachart2))
					 $totalRows_qwdatachart2 = mysql_num_rows($qwdatachart2);
					 { 
					 ?>
					 
					 
					 
					 <?php echo $totalRows_qwdatachart2; ?>,
					 
					 <?php }} ?>]
				
				}
			]

        }

        var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);

 



//]]>
</script>



<script>    /* 

        var lineChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    pointColor: "rgba(220,220,220,1)",
				    pointStrokeColor: "#fff",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    pointColor: "rgba(151,187,205,1)",
				    pointStrokeColor: "#fff",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }

        var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);


        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }    

        $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
              calendar.fullCalendar('renderEvent',
                {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            }
            calendar.fullCalendar('unselect');
          },
          editable: true,
          events: [
            {
              title: 'All Day Event',
              start: new Date(y, m, 1)
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d+5),
              end: new Date(y, m, d+7)
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d-3, 16, 0),
              allDay: false
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d+4, 16, 0),
              allDay: false
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d+1, 19, 0),
              end: new Date(y, m, d+1, 22, 30),
              allDay: false
            },
            {
              title: 'EGrappler.com',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://EGrappler.com/'
            }
          ]
        });
      });*/
    </script><!-- /Calendar -->
</body>
</html>
<?php
mysql_free_result($vwproject);

mysql_free_result($vwkomentar);

mysql_free_result($rsfile);
?>
