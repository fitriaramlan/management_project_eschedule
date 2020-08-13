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

if ((isset($_POST["MM_insertpekerjaan"])) && ($_POST["MM_insertpekerjaan"] == "frminputpekerjaan")) {
  $insertSQL = sprintf("INSERT INTO tblpekerjaan (id_project, namapekerjaan, status, id_karyawan) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_project'], "int"),
                       GetSQLValueString($_POST['namapekerjaan'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['id_karyawan'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
  $Sukses_komentar = '<div class="success">Komentar berhasil di input</div>';
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frminput")) {
  $insertSQL = sprintf("INSERT INTO tblkomentar (id_project, id_karyawan, komentar, tglinput) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_project'], "int"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['komentar'], "text"),
                       GetSQLValueString($_POST['tglinput'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
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
$query_rskaryawan = "SELECT * FROM tblkaryawan ORDER BY namalengkap ASC";
$rskaryawan = mysql_query($query_rskaryawan, $koneksi) or die(mysql_error());
$row_rskaryawan = mysql_fetch_assoc($rskaryawan);
$totalRows_rskaryawan = mysql_num_rows($rskaryawan);

$colname_vwpekerjaan = "-1";
if (isset($_GET['id_project'])) {
  $colname_vwpekerjaan = $_GET['id_project'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_vwpekerjaan = sprintf("SELECT * FROM vwpekerjaan WHERE id_project = %s ORDER BY id_pekerajaan ASC", GetSQLValueString($colname_vwpekerjaan, "int"));
$vwpekerjaan = mysql_query($query_vwpekerjaan, $koneksi) or die(mysql_error());
$row_vwpekerjaan = mysql_fetch_assoc($vwpekerjaan);
$totalRows_vwpekerjaan = mysql_num_rows($vwpekerjaan);

$colname_vwkomentar = "-1";
if (isset($_GET['id_project'])) {
  $colname_vwkomentar = $_GET['id_project']; 
}
mysql_select_db($database_koneksi, $koneksi);
$query_vwkomentar = sprintf("SELECT * FROM vwkomentar WHERE id_project = %s", GetSQLValueString($colname_vwkomentar, "int"));
$vwkomentar = mysql_query($query_vwkomentar, $koneksi) or die(mysql_error());
$row_vwkomentar = mysql_fetch_assoc($vwkomentar);
$totalRows_vwkomentar = mysql_num_rows($vwkomentar);
?>



<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="20%">Nama Project</td>
    <td width="1%">:</td>
    <td width="79%"><?php echo $row_vwproject['namaproject']; ?></td>
  </tr>
  <tr>
    <td>Nama Penanggung Jawab</td>
    <td>:</td>
    <td><?php echo $row_vwproject['namalengkap']; ?></td>
  </tr>
  <tr>
    <td>Jabatan</td>
    <td>:</td>
    <td> <?php echo $row_vwproject['akseslavel']; ?></td>
  </tr>
</table>
<form method="POST" action="<?php echo $editFormAction; ?>" name="frminputpekerjaan" id="frminputpekerjaan">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td>Nama Pekerjaan</td>
      <td>Status</td>
      <td>Nama Karyawan
      <input name="id_project" type="hidden" id="id_project" value="<?php echo $row_vwproject['id_project']; ?>"></td>
      <td>&nbsp;</td>
     </tr>
    <tr>
      <td><input type="text" name="namapekerjaan" id="namapekerjaan" class="span5"></td>
      <td><select name="status" id="status">
        <option value="Progress">Progress</option>
        <option value="Pending">Pending</option>
        <option value="Tidak Selesai">Tidak Selesai</option>
        <option value="Selesai">Selesai</option>
      </select></td>
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
      <td><input type="submit" class="btn btn-danger" name="button" id="button" value="Add"></td>
     </tr>
  </table>
  <input type="hidden" name="MM_insertpekerjaan" value="frminputpekerjaan">
</form>

<fieldset>
<legend>Data Pekerjaan Untuk Project <?php echo $row_vwproject['namaproject']; ?> </legend>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-bordered">
  <tr>
    <th width="3%">No</th>
    <th width="15%">Nama Karyawan </th>
    <th width="15%">Status</th>
    <th width="60%">Nama Pekerjaan</th>
    <th width="7%">Action</th>
  </tr>
  <?php $nourut=1; ?>
  <?php do { ?>
    <tr
    <?php 
	if ($row_vwpekerjaan['status']=='Progress'){
		echo '';
		}
	 else if ($row_vwpekerjaan['status']=='Pending'){
		 	echo '';
		 } else if ($row_vwpekerjaan['status']=='Pending'){
			 echo '';
			 }
	?>
    >
      <td><?php echo $nourut++;  ?></td>
      <td> <?php echo $row_vwpekerjaan['namalengkap']; ?></td>
      <td><?php echo $row_vwpekerjaan['status']; ?></td>
      <td><?php echo $row_vwpekerjaan['namapekerjaan']; ?></td>
      <td>&nbsp; </td>
    </tr>
    <?php } while ($row_vwpekerjaan = mysql_fetch_assoc($vwpekerjaan)); ?>
</table>
</fieldset>

<fieldset>
<legend>Form Komentar Project <?php echo $row_vwproject['namaproject']; ?></legend>
<div class="span7">
<strong>Tambah komentar </strong>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-bordered">
  <tr>
    <th width="3%">No</th>
    <th width="21%">Nama Karyawan</th>
    <th width="46%">Komentar</th>
    <th width="17%">Tanggal Post</th>
    <th width="13%">Balasan</th>
  </tr>
  <?php $nourutkomentar = 1;?>
  <?php do { ?>
    <tr>
      <td><?php  echo  $nourutkomentar++; ?></td>
      <td><?php echo $row_vwkomentar['namalengkap']; ?></td>
      <td><div  style="word-break: break-word;"><?php echo $row_vwkomentar['komentar']; ?></div></td>
      <td><?php echo $row_vwkomentar['tglinput']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <?php } while ($row_vwkomentar = mysql_fetch_assoc($vwkomentar)); ?>
</table>
</div>

<div class="span4">

<form method="POST" action="<?php echo $editFormAction; ?>" name="frminput" id="frminput">
    <fieldset>
    <legend><strong>Tambah komentar </strong></legend>
      <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr>
          <td colspan="3"><?php echo   $Sukses_komentar; ?></td>
          </tr>
        <tr>
          <td width="36%">Nama Karyawan</td>
          <td width="1%">:</td>
          <td width="63%"><?php echo $row_rsuser['namalengkap']; ?><?php echo $row_rsuser['id_karyawan']; ?>
            <input name="id_karyawan" type="hidden" value="<?php echo $row_rsuser['id_karyawan']; ?>" />
            <input name="id_project" type="hidden" value="<?php echo $row_vwproject['id_project']; ?>" />
            </td>
          </tr>
        <tr>
          <td>Tanggal</td>
          <td>:</td>
          <td><?php echo date('Y/m/d'); ?>
            
            <input type="hidden" name="tglinput" value="<?php echo date('Y/m/d'); ?>"  />
            </td>
          </tr>
        <tr>
          <td>Komentar</td>
          <td>:</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3"><textarea name="komentar" id="komentar" class="span4"></textarea></td>
          </tr>
        <tr>
          <td><input type="submit" name="button2" id="button2" value="Submit" class="btn btn-primary" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
      </table>
    </fieldset>
    <input type="hidden" name="MM_insert" value="frminput" />
  </form>
</div>
</fieldset>


<?php
mysql_free_result($vwproject);

mysql_free_result($rskaryawan);

mysql_free_result($vwpekerjaan);

mysql_free_result($vwkomentar);
?>

