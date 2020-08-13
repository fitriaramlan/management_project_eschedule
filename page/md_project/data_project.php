 
<?php 
 
$maxRows_vwproject = 100;
$pageNum_vwproject = 0;
if (isset($_GET['pageNum_vwproject'])) {
  $pageNum_vwproject = $_GET['pageNum_vwproject'];
}
$startRow_vwproject = $pageNum_vwproject * $maxRows_vwproject;

mysql_select_db($database_koneksi, $koneksi);
$query_vwproject = "SELECT * FROM vwproject ORDER BY id_project DESC";
$query_limit_vwproject = sprintf("%s LIMIT %d, %d", $query_vwproject, $startRow_vwproject, $maxRows_vwproject);
$vwproject = mysql_query($query_limit_vwproject, $koneksi) or die(mysql_error());
$row_vwproject = mysql_fetch_assoc($vwproject);

if (isset($_GET['totalRows_vwproject'])) {
  $totalRows_vwproject = $_GET['totalRows_vwproject'];
} else {
  $all_vwproject = mysql_query($query_vwproject);
  $totalRows_vwproject = mysql_num_rows($all_vwproject);
}
$totalPages_vwproject = ceil($totalRows_vwproject/$maxRows_vwproject)-1;


?>

 
<a href="console.php?idhal=10&namahal=md_project/add.php" class="btn btn-primary">Add New Project</a>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table table-responsive">
  <tr>
    <th width="3%">No</th>
    <th width="23%">Nama Project</th>
    <th width="15%">Tanggal Mulai Project</th>
    <th width="20%">Tangal Berakhir Project</th>
    <th width="19%">Penanggung Jawab</th>
    <th width="12%">Jumlah Pekerjaan</th>
    <th width="8%">Action</th>
  </tr>
  <?php $nourut=1; ?>
  <?php do { ?>
    <tr>
      <td><?php echo $nourut++; ?>.</td>
      <td><?php echo $row_vwproject['namaproject']; ?></td>
      <td><?php echo $row_vwproject['tglmulai']; ?></td>
      <td><?php echo $row_vwproject['tglakhir']; ?></td>
      <td><?php echo $row_vwproject['namalengkap']; ?></td>
      <td>
      <?php 
	  mysql_select_db($database_koneksi, $koneksi);
$query_rspekerjaan = "SELECT * FROM tblpekerjaan WHERE id_project='".$row_vwproject['id_project']."'";
$rspekerjaan = mysql_query($query_rspekerjaan, $koneksi) or die(mysql_error());
$row_rspekerjaan = mysql_fetch_assoc($rspekerjaan);
$totalRows_rspekerjaan = mysql_num_rows($rspekerjaan);

?>
      
 <a title="Tambah Pekerjaan" href="console.php?idhal=20&namahal=md_pekerjaan/add.php&id_project=<?php echo $row_vwproject['id_project']; ?>"><?php echo $totalRows_rspekerjaan; ?></a></td>
      <td><a class="icon-edit" href="console.php?idhal=12&namahal=md_project/update.php&id_project=<?php echo $row_vwproject['id_project']; ?>"></a><a href="console.php?idhal=13&namahal=md_project/delete.php&id_project=<?php echo $row_vwproject['id_project']; ?>" class="icon-remove"></a></td>
    </tr>
    <?php } while ($row_vwproject = mysql_fetch_assoc($vwproject)); ?>
</table>
<?php
mysql_free_result($vwproject);

mysql_free_result($rspekerjaan);
?>
