 
<?php 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmupdate")) {
  $updateSQL = sprintf("UPDATE tblkaryawan SET namalengkap=%s, alamat=%s, tgllahir=%s, idakseslavel=%s, email=%s, password=%s WHERE id_karyawan=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['tgllahir'], "date"),
                       GetSQLValueString($_POST['idakseslevel'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['pass'], "text"),
                       GetSQLValueString($_POST['id_karyawan'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
}

$colname_rsuser = "-1";
if (isset($_GET['id_karyawan'])) {
  $colname_rsuser = $_GET['id_karyawan'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsuser = sprintf("SELECT * FROM vwuser WHERE id_karyawan = %s", GetSQLValueString($colname_rsuser, "int"));
$rsuser = mysql_query($query_rsuser, $koneksi) or die(mysql_error());
$row_rsuser = mysql_fetch_assoc($rsuser);
$totalRows_rsuser = mysql_num_rows($rsuser);

mysql_select_db($database_koneksi, $koneksi);
$query_rslevel = "SELECT * FROM tblakseslavel ORDER BY akseslavel ASC";
$rslevel = mysql_query($query_rslevel, $koneksi) or die(mysql_error());
$row_rslevel = mysql_fetch_assoc($rslevel);
$totalRows_rslevel = mysql_num_rows($rslevel);
?>
<form method="POST" action="<?php echo $editFormAction; ?>" name="frmupdate" id="frmupdate">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="14%">Nama</td>
      <td width="1%">:</td>
      <td width="85%"><input name="nama" type="text" id="nama" value="<?php echo $row_rsuser['namalengkap']; ?>"></td>
    </tr>
    <tr>
      <td>Email</td>
      <td>:</td>
      <td><input name="email" type="text" id="email" value="<?php echo $row_rsuser['email']; ?>"></td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td><input name="alamat" type="text" id="alamat" value="<?php echo $row_rsuser['alamat']; ?>"></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>:</td>
      <td><input name="tgllahir" type="text" id="tgllahir" value="<?php echo $row_rsuser['tgllahir']; ?>"></td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td>:</td>
      <td><select name="idakseslevel" id="idakseslevel">
        <option value="" <?php if (!(strcmp("", $row_rsuser['idakseslavel']))) {echo "selected=\"selected\"";} ?>>Pilih Jabatan</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rslevel['idakseslavel']?>"<?php if (!(strcmp($row_rslevel['idakseslavel'], $row_rsuser['idakseslavel']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rslevel['akseslavel']?></option>
        <?php
} while ($row_rslevel = mysql_fetch_assoc($rslevel));
  $rows = mysql_num_rows($rslevel);
  if($rows > 0) {
      mysql_data_seek($rslevel, 0);
	  $row_rslevel = mysql_fetch_assoc($rslevel);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td><input name="pass" type="text" id="pass" value="<?php echo $row_rsuser['password']; ?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Update" class="btn btn-primary">
      <a class="btn btn-danger" href="console.php?idhal=60&namahal=md_user/data_user.php">Back</a>
      <input name="id_karyawan" type="hidden" id="id_karyawan" value="<?php echo $row_rsuser['id_karyawan']; ?>"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="frmupdate">
</form>

<?php
mysql_free_result($rsuser);

mysql_free_result($rslevel);
?>
