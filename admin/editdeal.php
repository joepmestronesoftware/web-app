<?php
session_start();
include("includes/config.php");
if(!isset($_SESSION['adminid']))
{
	?>
	<script>window.location.href='index.php';</script>
	<?php
}
if(isset($_POST['SubmitDeal']))
{
$addquery="";
$target_path = "uploads/deals/"; // Upload directory
if($_FILES['DealImage']['size'] > 0)
{
    $filename = time().basename($_FILES['DealImage']['name']);
    $target_path = $target_path.$filename; 
    if(move_uploaded_file($_FILES['DealImage']['tmp_name'], $target_path)) 
    {
        $addquery = ", DealImage='".$filename."'";
    }
}

$insert=mysqli_query($DbConn, "update tbl_deals set DealCompanyID='".addslashes($_POST['DealCompanyID'])."', DealTitle='".addslashes($_POST['DealTitle'])."', DealTagline='".addslashes($_POST['DealTagline'])."', DealDescription='".addslashes($_POST['DealDescription'])."', DealCity='".addslashes($_POST['DealCity'])."', DealEndDate='".date('Y-m-d', strtotime($_POST['DealEndDate']))."', DealLocationAddress='".addslashes($_POST['DealLocationAddress'])."', DealNoOfSmilesNeeded ='".addslashes($_POST['DealNoOfSmilesNeeded'])."', DealIsWebShop='".$_POST['DealIsWebShop']."', DealWebsiteLink='".$_POST['DealWebsiteLink']."', DealWebShopVoucherCode='".$_POST['DealWebShopVoucherCode']."', DealStatus='".$_POST['DealStatus']."'".$addquery." where DealID='".$_POST['DealID']."'") or die(mysqli_error($DbConn));

$message= "Deal updated successfully.";
 
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
    <title>Edit Deal - Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
	 <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	  <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
      
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
            Edit Deal
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
                <?php $select_deal = mysqli_query($DbConn, "select * from tbl_deals where DealID=".$_GET['id']) or die(mysqli_error($DbConn));
                        $dealinfo=mysqli_fetch_object($select_deal);
                       ?>
                <input type="hidden" value="<?php echo $dealinfo->DealID;?>" name="DealID" />
                  <div class="box-body">
                      <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Company</label>
                            <select class="form-control" id="DealCompanyID" name="DealCompanyID">
                            <?php $select_com=mysqli_query($DbConn, "select CompanyID, CompanyName from tbl_companys where CompanyStatus=1 order by CompanyName ASC") or die(mysqli_error($DbConn));
                            while($companyinfo = mysqli_fetch_object($select_com)){
                                if($dealinfo->DealCompanyID == $companyinfo->CompanyID){$selected='selected';}else{$selected='';}
                                echo '<option value="'.$companyinfo->CompanyID.'" '.$selected.'>'.$companyinfo->CompanyName.'</option>';
                            }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" class="form-control" id="DealTitle" name="DealTitle"  placeholder="Title" required value="<?php echo stripslashes($dealinfo->DealTitle);?>">
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tagline</label>
                            <input type="text" class="form-control" id="DealTagline" name="DealTagline"  placeholder="Tagline" required value="<?php echo stripslashes($dealinfo->DealTagline);?>">
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">City</label>
                            <input type="text" class="form-control" id="DealCity" name="DealCity"  placeholder="City" value="<?php echo stripslashes($dealinfo->DealCity);?>">
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea class="form-control" id="DealDescription" name="DealDescription"  placeholder="Description"><?php echo stripslashes($dealinfo->DealDescription);?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Location Address</label>
                            <textarea class="form-control" id="DealLocationAddress" name="DealLocationAddress"  placeholder="Address"><?php echo stripslashes($dealinfo->DealLocationAddress);?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">End Date</label>
                            <input type="text" class="form-control" id="DealEndDate" name="DealEndDate" required value="<?php echo date('m/d/Y', strtotime($dealinfo->DealEndDate));?>">
                        </div>
                    </div>
                      
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Smiles Needed</label>
                            <input type="number" class="form-control" id="DealNoOfSmilesNeeded" name="DealNoOfSmilesNeeded"  placeholder="Smiles Needed" required value="<?php echo stripslashes($dealinfo->DealNoOfSmilesNeeded);?>">
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">IsWebShop</label>
                            <select class="form-control" id="DealIsWebShop" name="DealIsWebShop">
                                <option value="1" <?php if($dealinfo->DealIsWebShop == 1) echo 'selected';?>>Yes</option>
                                <option value="0" <?php if($dealinfo->DealIsWebShop == 0) echo 'selected';?>>No</option>>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Website Link</label>
                            <input type="text" class="form-control" id="DealWebsiteLink" name="DealWebsiteLink"  placeholder="Website Link" value="<?php echo stripslashes($dealinfo->DealWebsiteLink);?>">
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Voucher Code</label>
                            <input type="text" class="form-control" id="DealWebShopVoucherCode" name="DealWebShopVoucherCode"  placeholder="Voucher Code" value="<?php echo stripslashes($dealinfo->DealWebShopVoucherCode);?>">
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <select class="form-control" id="DealStatus" name="DealStatus">
                                <option value="1" <?php if($dealinfo->DealStatus == 1) echo 'selected';?>>Active</option>
                                <option value="0" <?php if($dealinfo->DealStatus == 0) echo 'selected';?>>InActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Image</label>
                            <input type="file" id="DealImage" name="DealImage">
                        </div>
                    </div>
                     
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name="SubmitDeal" class="btn btn-primary">Submit</button>
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
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
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
         $("#DealEndDate").datepicker({dateFormat: "yy-mm-dd"});
         $("#DealEndDate").on('change', function(){
         var date = Date.parse($(this).val());
         if (date < Date.now()){
             alert('!alert End Date can not be less than current date.');
             $(this).val('');
         }
         });
      });
    </script>
  </body>
</html>