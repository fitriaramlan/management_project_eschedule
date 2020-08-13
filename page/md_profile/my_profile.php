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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmupdate")) {
  $updateSQL = sprintf("UPDATE tblkaryawan SET namalengkap=%s, alamat=%s, tgllahir=%s WHERE id_karyawan=%s",
                       GetSQLValueString($_POST['namalengkap'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['tanggallahir'], "date"),
                       GetSQLValueString($_POST['idkaryawan'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
}

$colname_rskaryawan = "-1";
if (isset($_SESSION['MM_idkaryawan'])) {
  $colname_rskaryawan = $_SESSION['MM_idkaryawan'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rskaryawan = sprintf("SELECT * FROM tblkaryawan WHERE id_karyawan = %s", GetSQLValueString($colname_rskaryawan, "int"));
$rskaryawan = mysql_query($query_rskaryawan, $koneksi) or die(mysql_error());
$row_rskaryawan = mysql_fetch_assoc($rskaryawan);
$totalRows_rskaryawan = mysql_num_rows($rskaryawan);
?>
<form method="POST" action="<?php echo $editFormAction; ?>" name="frmupdate" id="frmupdate"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td colspan="3">Profile Saya</td>
    </tr>
    <tr>
      <td width="15%">Nama</td>
      <td width="1%">:</td>
      <td width="84%"><input name="namalengkap" type="text" id="namalengkap" value="<?php echo $row_rskaryawan['namalengkap']; ?>">
      </td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td><textarea name="alamat" id="alamat"><?php echo $row_rskaryawan['alamat']; ?></textarea></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>:</td>
      <td><input name="tanggallahir" type="text" id="tanggallahir" value="<?php echo $row_rskaryawan['tgllahir']; ?>"></td>
    </tr>
    <tr>
      <td>Email</td>
      <td>:</td>
      <td><?php echo $row_rskaryawan['email']; ?></td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td><input name="pass" type="text" id="pass" value="<?php echo $row_rskaryawan['password']; ?>" /></td>
    </tr>
    <tr>
      <td>Foto</td>
      <td>:</td>
      <td rowspan="2"><img src="foto/" title="" />
      <a href="console.php?idhal=41&namahal=md_profile/update_foto.php">
      Update Foto
      </a>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="idkaryawan" type="hidden" id="idkaryawan" value="<?php echo $row_rskaryawan['id_karyawan']; ?>" />
      <input type="submit" name="button" id="button" value="Update"  class="btn btn-primary"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="frmupdate" />
</form>
<?php
mysql_free_result($rskaryawan);
?>
