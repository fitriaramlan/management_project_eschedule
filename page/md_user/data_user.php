 
<?php 

 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "inputkaryawan")) {
  $insertSQL = sprintf("INSERT INTO tblkaryawan (namalengkap, alamat, tgllahir, idakseslavel, email, password) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['tgllahir'], "date"),
                       GetSQLValueString($_POST['idakseslavel'], "int"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['pass'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frminpujabatan")) {
  $insertSQL = sprintf("INSERT INTO tblakseslavel (akseslavel) VALUES (%s)",
                       GetSQLValueString($_POST['akseslavel'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
}

mysql_select_db($database_koneksi, $koneksi);
$query_rsdatajab = "SELECT * FROM tblakseslavel ORDER BY akseslavel ASC";
$rsdatajab = mysql_query($query_rsdatajab, $koneksi) or die(mysql_error());
$row_rsdatajab = mysql_fetch_assoc($rsdatajab);
$totalRows_rsdatajab = mysql_num_rows($rsdatajab);

mysql_select_db($database_koneksi, $koneksi);
$query_vwuser = "SELECT * FROM vwuser ORDER BY namalengkap ASC";
$vwuser = mysql_query($query_vwuser, $koneksi) or die(mysql_error());
$row_vwuser = mysql_fetch_assoc($vwuser);
$totalRows_vwuser = mysql_num_rows($vwuser);

mysql_select_db($database_koneksi, $koneksi);
$query_rslevel = "SELECT * FROM tblakseslavel ORDER BY akseslavel ASC";
$rslevel = mysql_query($query_rslevel, $koneksi) or die(mysql_error());
$row_rslevel = mysql_fetch_assoc($rslevel);
$totalRows_rslevel = mysql_num_rows($rslevel);
?>

<form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal" id="inputkaryawan" name="inputkaryawan">
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add User</h3>
  </div>
  <div class="modal-body">
    <div class="row">

 

 
 

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="nama">Nama</label>
  <div class="controls">
    <input id="nama" name="nama" type="text" placeholder="Input Nama" class="input-large"
     required="">
 
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="alamat">Alamat</label>
  <div class="controls">                     
    <textarea id="alamat" name="alamat" required=""> </textarea>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="tgllahir">Tanggal Lahir</label>
  <div class="controls">
    <input id="tgllahir"  name="tgllahir" type="text" placeholder="2014/10/10" class="input-small" required="">
   
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="idakseslavel">Jabatan</label>
  <div class="controls">
    <select id="idakseslavel" name="idakseslavel" class="input-xlarge">
      <option value="">Pilih Jabatan</option>
      <?php
do {  
?>
      <option value="<?php echo $row_rsdatajab['idakseslavel']?>"><?php echo $row_rsdatajab['akseslavel']?></option>
      <?php
} while ($row_rsdatajab = mysql_fetch_assoc($rsdatajab));
  $rows = mysql_num_rows($rsdatajab);
  if($rows > 0) {
      mysql_data_seek($rsdatajab, 0);
	  $row_rsdatajab = mysql_fetch_assoc($rsdatajab);
  }
?>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">Email</label>
  <div class="controls">
    <input id="email" name="email"   type="text" placeholder="email@yahoo.com" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="pass">Password</label>
  <div class="controls">
    <input id="pass" name="pass" type="password" placeholder="Password" class="input-xlarge" required="">
    
  </div>
</div>

 

    
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>
<input type="hidden" name="MM_insert" value="inputkaryawan" />
</form>


 <form method="POST" action="<?php echo $editFormAction; ?>" class="form-horizontal" id="frminpujabatan" name="frminpujabatan">
<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Modal header</h3>
  </div>
  <div class="modal-body">

 

<!-- Form Name -->
 

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="nama">Nama</label>
  <div class="controls">
    <input id="akseslavel" name="akseslavel" type="text" placeholder="Input Nama Jabatan" class="input-large" required="">
  
  </div>
</div>

 

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>
<input type="hidden" name="MM_insert" value="frminpujabatan" />
</form>



<div class="row">
<div class="span8">
 <a href="#myModal" role="button" class="btn btn-primary" data-toggle="modal">Add</a>
  <fieldset>
  <legend>Data User</legend>
    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-striped table-bordered">
      <tr>
        <th width="3%">No</th>
        <th width="22%">Nama</th>
        <th width="23%">Email</th>
        <th width="25%">Password</th>
        <th width="21%">Jabatan</th>
        <th width="6%">Action</th>
        </tr>
        <?php $nourut=1; ?>
      <?php do { ?>
        <tr>
          <td><?php  echo $nourut++; ?></td>
          <td><?php echo $row_vwuser['namalengkap']; ?></td>
          <td><?php echo $row_vwuser['email']; ?></td>
          <td><?php echo $row_vwuser['password']; ?></td>
          <td><?php echo $row_vwuser['akseslavel']; ?></td>
          <td><a class="icon-edit" href="console.php?idhal=61&namahal=md_user/update_user.php&id_karyawan=<?php echo $row_vwuser['id_karyawan']; ?>"></a><a class="icon-remove"></a></td>
        </tr>
        <?php } while ($row_vwuser = mysql_fetch_assoc($vwuser)); ?>
    </table>
  </fieldset>

</div>

<div class="span3">
 <a href="#myModal2" role="button" class="btn btn-primary" data-toggle="modal">Add</a>
<fieldset>
<legend>Data Jabatan</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="4"  class="table table-striped table-bordered">
  <tr>
    <th>No</th>
    <th>Jabatan</th>
    <th>Action</th>
  </tr>
  <?php $nouruts=1; ?>
  <?php do { ?>
    <tr>
      <td><?php echo $nouruts++; ?></td>
      <td><?php echo $row_rslevel['akseslavel']; ?></td>
      <td><a class="icon-edit"></a></td>
    </tr>
    <?php } while ($row_rslevel = mysql_fetch_assoc($rslevel)); ?>
</table>
</fieldset>

</div>

</div>
<?php
mysql_free_result($vwuser);

mysql_free_result($rslevel);

mysql_free_result($rsdatajab);
?>
