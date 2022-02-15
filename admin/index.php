<?php
//echo md5('Derika');die;
session_start();
include("includes/config.php");
if(isset($_SESSION['adminid']))
{
	?>
	<script>window.location.href='dashboard.php';</script>
	<?php
}
if(isset($_POST['username']))
{
    if(isset($_POST['RememberMe']))
    {
        setcookie("username",$_POST['username'],time() + (86400  * 10));
        setcookie("password",$_POST['password'],time() + (86400  * 10));
    }
	$checklogin=mysqli_query($DbConn, "select * from tbl_admin where (AUsername='".addslashes($_POST['username'])."' or AEmail='".addslashes($_POST['username'])."') and APassword='".md5($_POST['password'])."' and AStatus=1") or die(mysqli_error($DbConn));
	if(mysqli_num_rows ($checklogin)>0)
	{
	
		$admininfo=mysqli_fetch_array($checklogin);
		$_SESSION['adminid']=$admininfo['AID'];
		$_SESSION['adminusername']=$admininfo['AUsername'];
		$_SESSION['adminemail']=$admininfo['AEmail'];
		$_SESSION['admintype']=$admininfo['AType'];
        ?>
		<script>window.location.href='dashboard.php';</script>
		<?php
	}
	else
	{
		$message='Invalid username or password!';	
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mind Your Step - Admin | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/green.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="index2.html"><b>Mind Your Step</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session <?php if(isset($message)) { echo "<br><b>".$message."</b>"; }?></p>
        <form  method="post">
          <div class="form-group has-feedback">
            <input type="text"  name="username" id="username" class="form-control" placeholder="Username" value="<?php if(isset($_COOKIE['username'])){echo $_COOKIE['username'];}?>">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password'];}?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" value="1" name="RememberMe"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

         
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>