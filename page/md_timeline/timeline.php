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

mysql_select_db($database_koneksi, $koneksi);
$query_vwproject = "SELECT * FROM vwproject ORDER BY id_project DESC";
$vwproject = mysql_query($query_vwproject, $koneksi) or die(mysql_error());
$row_vwproject = mysql_fetch_assoc($vwproject);
$totalRows_vwproject = mysql_num_rows($vwproject);


?>
<?php $nourut=1; ?>
<?php do { ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td><?php echo $nourut++; ?>. <strong><?php echo $row_vwproject['namaproject']; ?> , Penanggung jawab <?php echo $row_vwproject['namalengkap']; ?></strong></td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Progress :
        <?php
	  
	  
	       mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan = "SELECT * FROM tblpekerjaan WHERE id_project = '".$row_vwproject['id_project']."' ";
$rspekerjaan = mysql_query($query_rspekerjaan, $koneksi) or die(mysql_error());
$row_rspekerjaan = mysql_fetch_assoc($rspekerjaan);
$totalRows_rspekerjaan = mysql_num_rows($rspekerjaan);


      mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan_proses = "SELECT * FROM tblpekerjaan WHERE id_project = '".$row_vwproject['id_project']."' and status = 'Progress'";
$rspekerjaan_proses = mysql_query($query_rspekerjaan_proses, $koneksi) or die(mysql_error());
$row_rspekerjaan_proses = mysql_fetch_assoc($rspekerjaan_proses);
$totalRows_rspekerjaan_proses = mysql_num_rows($rspekerjaan_proses);
 


mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan_selesai = "SELECT * FROM tblpekerjaan WHERE id_project = '".$row_vwproject['id_project']."' and status = 'Selesai'";
$rspekerjaan_selesai = mysql_query($query_rspekerjaan_selesai, $koneksi) or die(mysql_error());
$row_rspekerjaan_pending = mysql_fetch_assoc($rspekerjaan_selesai);
$totalRows_rspekerjaan_selesai = mysql_num_rows($rspekerjaan_selesai);
 




 mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan_pending = "SELECT * FROM tblpekerjaan WHERE id_project = '".$row_vwproject['id_project']."' and status = 'Pending'";
$rspekerjaan_pending = mysql_query($query_rspekerjaan_pending, $koneksi) or die(mysql_error());
$row_rspekerjaan_pending = mysql_fetch_assoc($rspekerjaan_pending);
$totalRows_rspekerjaan_pending = mysql_num_rows($rspekerjaan_pending);
 

       ?>
        <div class="progress progress-striped active">
          <div class="bar" style="width: <?php echo( $totalRows_rspekerjaan_selesai / $totalRows_rspekerjaan)*100; ?>%;"></div>
        </div>
        <br />
        Mulai tanggal : <?php echo $row_vwproject['tglmulai']; ?> - sampai tanggal<?php echo $row_vwproject['tglakhir']; ?> <br />
        <strong> Banyak Pekerjaan Sedang Proses: <?php echo  $totalRows_rspekerjaan_proses  ; ?> </strong> <br />
        <strong> Banyak Pekerjaan Pending: <?php echo  $$totalRows_rspekerjaan_pending; ?> </strong> <br />
        <br />
        <strong> Banyak Pekerjaan Selesai: <?php echo  $totalRows_rspekerjaan_selesai  ; ?> </strong> <br />
        <strong> Total Pekerjaan: <?php echo  $totalRows_rspekerjaan; ?> </strong> <br />
        <strong> Lama Pengerjaan : <?php echo $row_vwproject['hari']; ?> hari</strong></td>
    </tr>
  </table>
 
  
  
 
  <hr />
  <?php } while ($row_vwproject = mysql_fetch_assoc($vwproject)); ?>
<?php
mysql_free_result($vwproject);

mysql_free_result($rspekerjaan);
?>
