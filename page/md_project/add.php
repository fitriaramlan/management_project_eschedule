 
<?php
 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frminsert")) {
  $insertSQL = sprintf("INSERT INTO tblproject (namaproject, tglmulai, tglakhir, id_karyawan, warna) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['namaproject'], "text"),
                       GetSQLValueString($_POST['tanggalmulai'], "date"),
                       GetSQLValueString($_POST['tanggalakhir'], "date"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
					   GetSQLValueString($_POST['warna'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}
 

mysql_select_db($database_koneksi, $koneksi);
$query_rskaryawan = "SELECT * FROM tblkaryawan ORDER BY namalengkap ASC";
$rskaryawan = mysql_query($query_rskaryawan, $koneksi) or die(mysql_error());
$row_rskaryawan = mysql_fetch_assoc($rskaryawan);
$totalRows_rskaryawan = mysql_num_rows($rskaryawan);
?>
   <link rel="stylesheet" href="../picker/css/colorpicker.css" type="text/css" />
	<script type="text/javascript" src="../picker/js/jquery.js"></script>
	<script type="text/javascript" src="../picker/js/colorpicker.js"></script>
    <script type="text/javascript" src="../picker/js/eye.js"></script>
    <script type="text/javascript" src="../picker/js/utils.js"></script>
    <script type="text/javascript" src="../picker/js/layout.js?ver=1.0.2"></script>
<form method="POST" action="<?php echo $editFormAction; ?>" name="frminsert" id="frminsert">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="18%">Nama Project</td>
      <td width="1%">:</td>
      <td width="81%"><input type="text" name="namaproject" id="namaproject"></td>
    </tr>
    <tr>
      <td>Tanggal Mulai</td>
      <td>:</td>
      <td><input type="text" name="tanggalmulai" id="tanggalmulai"></td>
    </tr>
    <tr>
      <td>Tanggal Akhir</td>
      <td>:</td>
      <td><input type="text" name="tanggalakhir" id="tanggalakhir"></td>
    </tr>
    <tr>
      <td>Penangguang Jawab</td>
      <td>:</td>
      <td><select name="id_karyawan" id="id_karyawan">
        <option value="">Pilih Nama Karyawan</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rskaryawan['id_karyawan']?>"><?php echo $row_rskaryawan['namalengkap']?></option>
        <?php
} while ($row_rskaryawan = mysql_fetch_assoc($rskaryawan));
  $rows = mysql_num_rows($rskaryawan);
  if($rows > 0) {
      mysql_data_seek($rskaryawan, 0);
	  $row_rskaryawan = mysql_fetch_assoc($rskaryawan);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Warna</td>
      <td>:</td>
      <td><input type="text" name="warna"  maxlength="6" size="6" id="colorpickerField2" value="ff0000" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" class="btn btn-primary" value="Add Project">
      <a class="btn btn-default" href="console.php?idhal=11&namahal=md_project/data_project.php">
  Data Project</a>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="frminsert">
</form>
<?php
mysql_free_result($rskaryawan);
?>
