<?php
session_start();
include("includes/config.php");
if(!isset($_SESSION['adminid']))
{
	?>
	<script>window.location.href='index.php';</script>
	<?php
}
if(isset($_POST['CompanyName']))
{
    $addquery="";
    $errors = '';
    $CompanyEmailArray=array();
    //$CompanyUsers = $_POST['CompanyUsers'];
    if($_FILES["CompanyLogo"]["size"] > 0) 
    {
        $ProjectImageName = $_FILES["CompanyLogo"]['name'];
        $file_name = time().$ProjectImageName;
        $file_tmp =$_FILES['CompanyLogo']['tmp_name'];

        $file_ext=strtolower(end(explode('.',$ProjectImageName)));
        $expensions= array("jpeg","jpg","png");
        if(in_array($file_ext,$expensions)=== false){
         $errors="extension not allowed, please choose a JPEG or PNG file.";
        }
        if($errors == '')
        {
            move_uploaded_file($file_tmp, "../resources/images/companys/".$file_name);
            $addquery.= ", CompanyLogo='".$file_name."'";
        }
    }
    if($errors == '')
    {
        for($k=1; $k<=$_POST['CompanyEmailCount']; $k++)
        {
            if(isset($_POST['CompanyEmail_'.$k]))
            {
                array_push($CompanyEmailArray, addslashes($_POST['CompanyEmail_'.$k]));
            }
        }
        $CompanyEmail = implode('@@#@@', $CompanyEmailArray);

        $insert=mysqli_query($DbConn, "insert into tbl_companys set CompanyName='".addslashes($_POST['CompanyName'])."', CompanyDescription='".addslashes($_POST['CompanyDescription'])."', CompanyEmails='".$CompanyEmail."', CompanyStatus='".$_POST['CompanyStatus']."'".$addquery) or die(mysqli_error($DbConn));
        $CompanyID = mysqli_insert_id($DbConn);
        
        for($i=1; $i<=$_POST['InspectionUserCount']; $i++)
        {
            if(isset($_POST['UserEmail_'.$i]))
            {
                $insert_group = mysqli_query($DbConn, "insert into tbl_users set UserFullName='".addslashes($_POST['UserFullName_'.$i])."', UserEmail='".addslashes($_POST['UserEmail_'.$i])."', UserMobileNo='".addslashes($_POST['UserMobileNo_'.$i])."', UserPassword='".addslashes($_POST['UserPassword_'.$i])."', UserStatus=1") or die(mysqli_error($DbConn));
                $UserID = mysqli_insert_id($DbConn);
                mysqli_query($DbConn, "insert into tbl_companyusers set CompanyID='".$CompanyID."', UserID='".$UserID."'") or die(mysqli_error($DbConn));
            }
        }
        /*foreach($CompanyUsers as $UserID)
        {
            mysqli_query($DbConn, "insert into tbl_companyusers set CompanyID='".$CompanyID."', UserID='".$UserID."'") or die(mysqli_error($DbConn));
        }*/
        
        $message= "Company added successfully.";
    }
    else
    {
        $message=$errors;
    }
 
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
    <title>Add Company - Admin</title>
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
            Add Company
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
                   <form role="form" method="post" enctype="multipart/form-data">
                  <div class="box-body">
                      <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Company Name</label>
                            <input type="text" class="form-control" id="CompanyName" name="CompanyName" required placeholder="Company Name">
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Logo (Max Size 400px) </label>
                            <input class="form-control" id="CompanyLogo" name="CompanyLogo" type="file" />
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea class="form-control" id="CompanyDescription" name="CompanyDescription"  placeholder="Company Description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <select class="form-control" id="CompanyStatus" name="CompanyStatus">
                                <option value="1">Active</option>
                                <option value="0">InActive</option>
                            </select>
                            <span style="float:right;margin-top:10px;font-weight:bold;">
                                <a href="javascript:void(0);" onclick="AddCompanyEmail();" >Add More Email</a>
                            </span>
                        </div>
                    </div>
                    <div class="row col-md-12" id="CompanyEmailsBlock">
                        <input type="hidden" name="CompanyEmailCount" id="CompanyEmailCount" value="1" />
                        <div id="CompanyEmailContainer_1"><div class="col-md-6"><div class="form-group"><label style="color:#00a65a;">Email </label><input type="email" class="form-control" id="CompanyEmail_1" name="CompanyEmail_1" required placeholder="Email"/></div></div></div>
                    </div>
                    <div class="row" id="InspectionUsersBlock">
                        <input type="hidden" name="InspectionUserCount" id="InspectionUserCount" value="0" />
                    </div>
                    <!--<div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Inspection User (press Ctrl to select multiple)</label>
                            <select class="form-control" id="CompanyUsers" name="CompanyUsers[]" multiple required>
                            <?php /*$select_users = mysqli_query($DbConn, "select UserID, UserFullName, UserEmail from tbl_users where UserStatus=1 AND UserID NOT IN (select UserID FROM tbl_companyusers group by UserID)") or die(mysqli_error($DbConn));
                            while($userinfo=mysqli_fetch_object($select_users)){
                                echo '<option value="'.$userinfo->UserID.'">'.$userinfo->UserFullName.' -- '.$userinfo->UserEmail.'</option>';
                            }*/?>
                            </select>
                        </div>
                    </div>-->
                     
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="companies.php" class="btn btn-default m-b-sm">Cancel</a>
                        <span style="float:right;">
                            <a href="javascript:void(0);" onclick="AddInspectionUser();" >Add More Inspection User</a>
                        </span>
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

    function RemoveContainer(id)
    {
        if($('#'+id))
        {
              $('#'+id).remove();
        }
    }
    function AddCompanyEmail()
    {
        TotalCount = $('#CompanyEmailCount').val();
        TotalCount++;
        $('#CompanyEmailsBlock').append('<div id="CompanyEmailContainer_'+TotalCount+'"><div class="col-md-6"><div class="form-group"><label style="color:#00a65a;">Email </label><a href="javascript:void(0);" onclick="RemoveContainer(\'CompanyEmailContainer_'+TotalCount+'\');" style="float:right;">Remove Email</a><input type="email" class="form-control" id="CompanyEmail_'+TotalCount+'" name="CompanyEmail_'+TotalCount+'" required placeholder="Email"/></div></div></div>');
        $('#CompanyEmailCount').val(TotalCount);
    }
    function AddInspectionUser()
    {
        TotalCount = $('#InspectionUserCount').val();
        TotalCount++;
        $('#InspectionUsersBlock').append('<div id="InspectionUserContainer_'+TotalCount+'"><div class="col-md-12"><label style="color:#00a65a;">Inspection User </label><a href="javascript:void(0);" onclick="RemoveContainer(\'InspectionUserContainer_'+TotalCount+'\');" style="float:right;">Remove Inspection User</a></div><div class="col-md-6"><div class="form-group"><label>Full Name</label><input type="text" class="form-control" id="UserFullName_'+TotalCount+'" name="UserFullName_'+TotalCount+'" required placeholder="Full Name"/></div></div><div class="col-md-6"><div class="form-group"><label>Email</label><input type="email" class="form-control" id="UserEmail_'+TotalCount+'" name="UserEmail_'+TotalCount+'" placeholder="Email" required></div></div><div class="col-md-6"><div class="form-group"><label>Mobile No.</label><input type="text" class="form-control" id="UserMobileNo_'+TotalCount+'" name="UserMobileNo_'+TotalCount+'" placeholder="MobileNo" /></div></div><div class="col-md-6"><div class="form-group"><label>Password</label><input type="password" class="form-control" id="UserPassword_'+TotalCount+'" name="UserPassword_'+TotalCount+'" placeholder="Password" required /></div></div></div>');
        $('#InspectionUserCount').val(TotalCount);
    }
    AddInspectionUser();
    </script>
  </body>
</html>