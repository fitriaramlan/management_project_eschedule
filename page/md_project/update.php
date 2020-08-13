 
<?php 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmupdate")) {
  $updateSQL = sprintf("UPDATE tblproject SET namaproject=%s, tglmulai=%s, tglakhir=%s, id_karyawan=%s, warna=%s WHERE id_project=%s",
                       GetSQLValueString($_POST['namaproject'], "text"),
                       GetSQLValueString($_POST['tanggalmulai'], "date"),
                       GetSQLValueString($_POST['tanggalakhir'], "date"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['warna'], "text"),
                       GetSQLValueString($_POST['id_project'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
}
 

$colname_vwproject = "-1";
if (isset($_GET['id_project'])) {
  $colname_vwproject = $_GET['id_project'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_vwproject = sprintf("SELECT * FROM vwproject WHERE id_project = %s", GetSQLValueString($colname_vwproject, "int"));
$vwproject = mysql_query($query_vwproject, $koneksi) or die(mysql_error());
$row_vwproject = mysql_fetch_assoc($vwproject);
$totalRows_vwproject = mysql_num_rows($vwproject);

mysql_select_db($database_koneksi, $koneksi);
$query_rspj = "SELECT * FROM tblkaryawan ORDER BY namalengkap ASC";
$rspj = mysql_query($query_rspj, $koneksi) or die(mysql_error());
$row_rspj = mysql_fetch_assoc($rspj);
$totalRows_rspj = mysql_num_rows($rspj);
?>
   <link rel="stylesheet" href="../picker/css/colorpicker.css" type="text/css" />
	<script type="text/javascript" src="../picker/js/jquery.js"></script>
	<script type="text/javascript" src="../picker/js/colorpicker.js"></script>
    <script type="text/javascript" src="../picker/js/eye.js"></script>
    <script type="text/javascript" src="../picker/js/utils.js"></script>
<script type="text/javascript" src="../picker/js/layout.js?ver=1.0.2"></script>
<form method="POST" action="<?php echo $editFormAction; ?>" name="frmupdate" id="frmupdate">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="18%">Nama Project</td>
      <td width="1%">:</td>
      <td width="81%"><input name="namaproject" type="text" id="namaproject" value="<?php echo $row_vwproject['namaproject']; ?>"></td>
    </tr>
    <tr>
      <td>Tanggal Mulai</td>
      <td>:</td>
      <td><input name="tanggalmulai" type="text" id="tanggalmulai" value="<?php echo $row_vwproject['tglmulai']; ?>"></td>
    </tr>
    <tr>
      <td>Tanggal Akhir</td>
      <td>:</td>
      <td><input name="tanggalakhir" type="text" id="tanggalakhir" value="<?php echo $row_vwproject['tglakhir']; ?>"></td>
    </tr>
    <tr>
      <td>Penangguang Jawab</td>
      <td>:</td>
      <td><select name="id_karyawan" id="id_karyawan">
        <option value="" <?php if (!(strcmp("", $row_vwproject['id_karyawan']))) {echo "selected=\"selected\"";} ?>>Pilih Nama Karyawan</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rspj['id_karyawan']?>"<?php if (!(strcmp($row_rspj['id_karyawan'], $row_vwproject['id_karyawan']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rspj['namalengkap']?></option>
        <?php
} while ($row_rspj = mysql_fetch_assoc($rspj));
  $rows = mysql_num_rows($rspj);
  if($rows > 0) {
      mysql_data_seek($rspj, 0);
	  $row_rspj = mysql_fetch_assoc($rspj);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Warna</td>
      <td>:</td>
      <td><input type="text" name="warna"  maxlength="6" size="6" id="colorpickerField2" value="<?php echo $row_vwproject['warna']; ?>" style="background:#<?php echo $row_vwproject['warna']; ?>" /></td>
    </tr>
    <tr>
      <td><input name="id_project" type="hidden" id="id_project" value="<?php echo $row_vwproject['id_project']; ?>"></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" class="btn btn-primary" value="Update Project">
        <a class="btn btn-default" href="console.php?idhal=11&namahal=md_project/data_project.php"> Data Project</a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="frmupdate">
</form>
<?php
mysql_free_result($vwproject);

mysql_free_result($rspj);
?>
