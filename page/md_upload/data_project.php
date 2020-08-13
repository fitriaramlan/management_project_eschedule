 
<?php 
 
mysql_select_db($database_koneksi, $koneksi);
$query_vwproject = "SELECT * FROM vwproject ORDER BY id_project DESC";
$vwproject = mysql_query($query_vwproject, $koneksi) or die(mysql_error());
$row_vwproject = mysql_fetch_assoc($vwproject);
$totalRows_vwproject = mysql_num_rows($vwproject);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-striped table-bordered">
  <tr>
    <th width="4%">No</th>
    <th width="20%">Nama Project</th>
    <th width="27%">Penanggung Jawab Project</th>
    <th width="17%">Banyak Pekerjaan</th>
    <th width="23%">Banyak File Upload</th>
    <th width="9%">Action</th>
  </tr>
  <?php  $nourut=1; ?>
  <?php do { ?>
    <tr>
      <td><?php echo $nourut++; ?></td>
      <td><?php echo $row_vwproject['namaproject']; ?></td>
      <td><?php echo $row_vwproject['namalengkap']; ?></td>
      <td>  <?php 
	  mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan = "SELECT * FROM tblpekerjaan WHERE id_project='".$row_vwproject['id_project']."'";
$rspekerjaan = mysql_query($query_rspekerjaan, $koneksi) or die(mysql_error());
$row_rspekerjaan = mysql_fetch_assoc($rspekerjaan);
$totalRows_rspekerjaan = mysql_num_rows($rspekerjaan);



?>
      
      <?php echo $totalRows_rspekerjaan; ?> </td>
      <td><?php 
mysql_select_db($database_koneksi, $koneksi);
$query_rsfile = "SELECT * FROM tblfile WHERE id_project = '".$row_vwproject['id_project']."'";
$rsfile = mysql_query($query_rsfile, $koneksi) or die(mysql_error());
$row_rsfile = mysql_fetch_assoc($rsfile);
$totalRows_rsfile = mysql_num_rows($rsfile);

echo $totalRows_rsfile;
 ?></td>
      <td><a class="icon-upload" href="console.php?idhal=51&namahal=md_upload/upload.php&id_project=<?php echo $row_vwproject['id_project']; ?>"></a></td>
    </tr>
    <?php } while ($row_vwproject = mysql_fetch_assoc($vwproject)); ?>
</table>
<?php
mysql_free_result($vwproject);

mysql_free_result($rsfile);


?>