<?php
session_start();
include("includes/config.php");
if(!isset($_SESSION['adminid']))
{
	?>
	<script>window.location.href='index.php';</script>
	<?php
}
if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete')
{
$deleteuser=mysqli_query($DbConn, "delete from tbl_admin where AID='".$_REQUEST['id']."'");
 
$message= "Admin deleted successfully.";
 
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
    <title>Admin Users - Admin</title>
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
            Manage Admin Users
          </h1>
          <ol class="breadcrumb">
            <li><a href="addadmin.php" class="btn btn-default m-b-sm">Add New</a></li>
             
          </ol>
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
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$i=1;
					$selectadmins=mysqli_query($DbConn, "select * from tbl_admin order by AUsername ASC");
					while($admininfo=mysqli_fetch_array($selectadmins)){?>
                      <tr>
					  	<td><?php echo $i;?></td>
                        <td><?php echo $admininfo['AUsername'];?></td>
                         <td><?php echo $admininfo['AEmail'];?></td>
                         <td><?php if($admininfo['AStatus'] == 1){ echo 'Active';}else{ echo 'Inactive';}?></td>
                        <td><a href="editadmin.php?id=<?php echo $admininfo['AID'];?>"><i class="fa fa-edit"></i>&nbsp;&nbsp;</a> <a href="admin-users.php?id=<?php echo $admininfo['AID'];?>&action=delete"><i class="fa fa-trash-o"></i></a> </td>
                      </tr>
                   <?php
				   $i++;
				   }
				   ?>  
                    </tbody>
                  </table>
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
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
  </body>
</html>