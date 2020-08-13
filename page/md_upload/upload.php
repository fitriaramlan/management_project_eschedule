 
<?php 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frminput")) {
	
	
	    
	
	      
 
		 
	

$uploadDir = "file_project/";
 // Apabila ada file yang di-upload
 if(is_uploaded_file($_FILES['file']['tmp_name']))
 
	{
		
		
  $uploadFile = $_FILES['file'];
 
  //$mimetype = mime_content_type($_FILES['file']['tmp_name']);
 
  // Extract nama file
  $extractFile = pathinfo($uploadFile['name']);  
  $size = $_FILES['file']['size']; //untuk mengetahui ukuran file
 // $tipe = mime_content_type($_FILES['gambar']['tmp_name']);// untuk mengetahui tipe file
 
  
  //Dibawah ini adalah untuk mengatur format gambar yang dapat di uplada ke server.
 // Anda bisa tambahakan jika ingin memasukan format yang lain tergantung kebutuhan anda.

 /* $exts =array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
  
   
 

 
  if(!in_array(($tipe),$exts)){
  echo 'Format file yang di izinkan hanya JPEG dan PNG image kecil';
  echo '<br /><input class="btn btn-primary"  type=button value="Refresh" onClick="window.location.reload()">';
  exit;
  } 
  */
 
  
  // dibawah ini script untuk mengatur ukuran file yang dapat di upload ke server
  if(($size !=0)&&($size>1000000)){
  echo '<div class="alert alert-error">';
  echo ('Ukuran file terlalu besar  max 1 Mb');
    
  echo '</div>';
  echo '<meta http-equiv="refresh" content="2">';
 exit;

  }  
  
  
 $sameName = 0; // Menyimpan banyaknya file dengan nama yang sama dengan file yg diupload
  $handle = opendir($uploadDir);
  while(false !== ($file = readdir($handle))){ // Looping isi file pada directory tujuan
   // Apabila ada file dengan awalan yg sama dengan nama file di uplaod
   if(strpos($file,$extractFile['filename']) !== false)    
    $sameName++; // Tambah data file yang sama 
  }  
  
   
   
  
  /* Apabila tidak ada file yang sama ($sameName masih '0') maka nama file pakai 
* nama ketika diupload, jika $sameName > 0 maka pakai format “namafile($sameName).ext */
$newName = empty($sameName) ? $uploadFile['name'] : $extractFile['filename'].'('.$sameName.').'.$extractFile['extension'];

 
     								
 	
  
  if(move_uploaded_file($uploadFile['tmp_name'],$uploadDir.$newName))
 
  {
 
 
 
  $insertSQL = sprintf("INSERT INTO tblfile (id_project, namafile, ket, `file`, tglinput, id_karyawan) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_project'], "int"),
                       GetSQLValueString($_POST['namafile'], "text"),
                       GetSQLValueString($_POST['ket'], "text"),
                       GetSQLValueString($newName, "text"),
                       GetSQLValueString($_POST['tglinput'], "date"),
                       GetSQLValueString($_POST['id_karyawan'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
  
    echo '<div class="alert alert-success">';
	echo 'File berhasil di upload';
	echo '</div>';
}
}}
$colname_vwproject = "-1";
if (isset($_GET['id_project'])) {
  $colname_vwproject = $_GET['id_project'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_vwproject = sprintf("SELECT * FROM vwproject WHERE id_project = %s", GetSQLValueString($colname_vwproject, "int"));
$vwproject = mysql_query($query_vwproject, $koneksi) or die(mysql_error());
$row_vwproject = mysql_fetch_assoc($vwproject);
$totalRows_vwproject = mysql_num_rows($vwproject);


$colname_vwfile = "-1";
if (isset($_GET['id_project'])) {
  $colname_vwfile = $_GET['id_project'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_vwfile = sprintf("SELECT * FROM tblfile WHERE id_project = %s ORDER BY id_file DESC", GetSQLValueString($colname_vwfile, "int"));
$vwfile = mysql_query($query_vwfile, $koneksi) or die(mysql_error());
$row_vwfile = mysql_fetch_assoc($vwfile);
$totalRows_vwfile = mysql_num_rows($vwfile);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td width="19%">Nama Project</td>
    <td width="1%">:</td>
    <td width="80%"><?php echo $row_vwproject['namaproject']; ?></td>
  </tr>
  <tr>
    <td>Nama Penanggung Jawab</td>
    <td>:</td>
    <td><?php echo $row_vwproject['namalengkap']; ?></td>
  </tr>
  <tr>
    <td>Jabatan</td>
    <td>:</td>
    <td><?php echo $row_vwproject['akseslavel']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<form method="POST" action="<?php echo $editFormAction; ?>" name="frminput" enctype="multipart/form-data" id="frminput">
  <fieldset>
  <legend>Upload File Project</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td colspan="3"></td>
    </tr>
    <tr>
      <td width="17%">Nama File</td>
      <td width="1%">:</td>
      <td width="82%"><input type="text" name="namafile" id="namafile" class="span7">
        <input name="id_project" type="hidden" id="id_project" value="<?php echo $row_vwproject['id_project']; ?>">
        <input name="id_karyawan" type="hidden" id="id_karyawan" value="<?php echo $row_rsuser['id_karyawan']; ?>">
        <input name="tglinput" type="hidden" id="tglinput" value="<?php echo date('Y/m/d'); ?>"></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td>:</td>
      <td><textarea name="ket" rows="5" class="span8" id="ket"></textarea></td>
    </tr>
    <tr>
      <td>File</td>
      <td>:</td>
      <td><input type="file" name="file" id="file"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Upload" class="btn btn-primary"></td>
    </tr>
  </table>
</fieldset>
  <input type="hidden" name="MM_insert" value="frminput">
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-striped table-bordered">
  <tr>
    <th width="6%">No</th>
    <th width="26%">Nama File</th>
    <th width="41%">Keterangan</th>
    <th width="19%">File</th>
    <th width="8%">Action</th>
  </tr>
  <?php $nourut=1; ?>
  <?php do { ?>
    <tr>
      <td><?php echo $nourut++; ?></td>
      <td><?php echo $row_vwfile['namafile']; ?></td>
      <td><?php echo $row_vwfile['ket']; ?></td>
      <td><?php echo $row_vwfile['file']; ?></td>
      <td><a class="icon-remove" title="Delete"></a>&nbsp;&nbsp;<a class="icon-download" title="Download"></a></td>
    </tr>
    <?php } while ($row_vwfile = mysql_fetch_assoc($vwfile)); ?>
</table>

<?php
mysql_free_result($vwproject);
mysql_free_result($vwfile);
?>
