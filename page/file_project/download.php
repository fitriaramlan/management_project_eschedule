<?php require_once('../../Connections/koneksi.php'); ?>
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

$colname_rsfileget = "-1";
if (isset($_GET['id_file'])) {
  $colname_rsfileget = $_GET['id_file'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsfileget = sprintf("SELECT * FROM tblfile WHERE id_file = %s", GetSQLValueString($colname_rsfileget, "int"));
$rsfileget = mysql_query($query_rsfileget, $koneksi) or die(mysql_error());
$row_rsfileget = mysql_fetch_assoc($rsfileget);
$totalRows_rsfileget = mysql_num_rows($rsfileget);

 
 mysql_free_result($rsfileget);

if (file_exists($row_rsfileget['file'])) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($row_rsfileget['file']));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($row_rsfileget['file']));
    ob_clean();
    flush();
    readfile($row_rsfileget['file']);
    exit;
}



?>
 