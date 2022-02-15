<?php
session_start();
include("includes/config.php");
if(!isset($_SESSION['adminid']))
{?>
    <script>window.location.href='index.php';</script>
<?php
}
if(isset($_POST['Submit']))
{
$insert=mysqli_query($DbConn, "insert into tbl_users set UserFullName='".addslashes($_POST['UserFullName'])."', UserEmail='".addslashes($_POST['UserEmail'])."', UserMobileNo='".addslashes($_POST['UserMobileNo'])."', UserPassword='".md5($_POST['UserPassword'])."', UserStatus='".$_POST['UserStatus']."'") or die(mysqli_error($DbConn));
 
$message= "User added successfully.";
 
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Inspection User - Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
	 <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="dist/css/skins/skin-green.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
     <?php include("includes/header.php");?> 
      <!-- Left side column. contains the logo and sidebar -->
      
<?php include("includes/leftpanel.php");?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Inspection User
          </h1>
           
        </section>

        <!-- Main content -->
        <section class="content">
				  <div class="row">
            <div class="col-xs-12">
			<div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php if(isset($message)) { echo "<br><b>".$message."</b>"; }?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                   <form role="form" method="post">
                  <div class="box-body">
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Full Name</label>
                            <input type="text" class="form-control" id="UserFullName" name="UserFullName" required placeholder="Full Name" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="UserEmail" name="UserEmail"  placeholder="Email" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mobile No.</label>
                            <input type="text" class="form-control" id="UserMobileNo" name="UserMobileNo" placeholder="MobileNo" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" class="form-control" id="UserPassword" name="UserPassword" placeholder="Password" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <select class="form-control" id="UserStatus" name="UserStatus">
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                            </select>
                        </div>
                    </div>
                     
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                    <a href="users.php" class="btn btn-default m-b-sm">Cancel</a>
                  </div>
                </form>
                </div><!-- /.box-body -->
              </div>
			</div>
			</div>
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php include("includes/footer.php");?>
     
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
      $(function () {
      });
    </script>
  </body>
</html>