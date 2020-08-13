 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Time Schedule | helps you to manage your precious time</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
 
 <div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span11">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> </h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div id='calendar'>
              </div>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          <!-- /widget --> 
        </div>
        
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="../module_admin/js/jquery-1.7.2.min.js"></script> 
<script src="../module_admin/js/excanvas.min.js"></script> 
<script src="../module_admin/js/chart.min.js" type="text/javascript"></script> 
<script src="../module_admin/js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="../module_admin/js/full-calendar/fullcalendar.min.js"></script>
 
<script src="../module_admin/js/base.js"></script> 
 
 <script>
//<![CDATA[
	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			editable: true,
			events: [
				
				 
       <?php 
	   $qw = mysql_query("SELECT * FROM vwproject");  
	    while($data  = mysql_fetch_assoc($qw)){?> 
 
				{
					title: '<?php echo "# ".$data['namaproject']."# ". $data['title']; ?>',
					start: new Date('<?php echo $data['tglmulai']; ?>'),
					end: new Date('<?php echo $data['tglakhir']; ?>'),
					url: '<?php echo $data['url']; ?>',
				 
					
			     },
           <?php } ?>
  
				 ]
		});
		
	});
	</script>
</body>
</html>
