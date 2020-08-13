<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Time Schedule | helps you to manage your precious time</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="../module_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../module_admin/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="../module_admin/css/font-awesome.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="../module_admin/css/style.css" rel="stylesheet" type="text/css">
<link href="../module_admin/css/pages/signin.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="index.php"> TimeSchedule </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class=""> <a href="login.php" class=""> Already have an account? Login now </a> </li>
          <li class=""> <a href="index.php" class=""> <i class="icon-chevron-left"></i> Back to Homepage </a> </li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
      
    </div>
    <!-- /container --> 
    
  </div>
  <!-- /navbar-inner --> 
  
</div>
<!-- /navbar -->

<div class="account-container register">
  <div class="content clearfix">
    <form action="signup.php" method="post">
      <h1>Signup for Free Account</h1>
      <div class="login-fields">
        <p>Create your free account:</p>
        <div class="field">
          <label for="name">Username:</label>
          <input type="text" id="name" name="name" value="" placeholder="Username" class="login" />
        </div>
        <!-- /field -->
        
        <div class="field">
          <label for="e-mail">Email Address:</label>
          <input type="text" id="e-mail" name="e-mail" value="" placeholder="Email" class="login"/>
        </div>
        <!-- /field -->
        
        <div class="field">
          <label for="Password">Password:</label>
          <input type="password" id="Password" name="Password" value="" placeholder="Password" class="login"/>
        </div>
        <!-- /field --> 
        
      </div>
      <!-- /login-fields -->
      
      <div class="login-actions"><br>
        <input type="hidden" name="formsubmitted" value="TRUE" />
        <input type="submit" value="Register" />
      </div>
      <!-- .actions -->
      
    </form>
  </div>
  <!-- /content --> 
  
</div>
<!-- /account-container --> 

<!-- Text Under Box -->
<div class="login-extra"> Already have an account? <a href="login.php">Login to your account</a> </div>
<!-- /login-extra --> 

<script src="../module_admin/js/jquery-1.7.2.min.js"></script> 
<script src="../module_admin/js/bootstrap.js"></script> 
<script src="../module_admin/js/signin.js"></script>
</body>
</html>
