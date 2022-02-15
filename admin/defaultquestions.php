<?php
session_start();
include("includes/config.php");
if(!isset($_SESSION['adminid']))
{
	?>
	<script>window.location.href='index.php';</script>
	<?php
}
if(isset($_POST['Submit']))
{
    //print_r($_POST);die;
    $TRUNCATE=0;
    for($i=1; $i<=$_POST['GroupCount']; $i++)
    {
        if(isset($_POST['QuestionGroupTitle_'.$i]))
        {
            if($TRUNCATE == 0)
            {
                mysqli_query($DbConn, "TRUNCATE tbl_defaultquestiongroups") or die(mysqli_error($DbConn));
                mysqli_query($DbConn, "TRUNCATE tbl_defaultquestions") or die(mysqli_error($DbConn));
                $TRUNCATE++;
            }
            $insert_group = mysqli_query($DbConn, "insert into tbl_defaultquestiongroups set QuestionGroupTitle='".addslashes($_POST['QuestionGroupTitle_'.$i])."'") or die(mysqli_error($DbConn));
            $QuestionGroupID = mysqli_insert_id($DbConn);
            for($k=1; $k<=$_POST['QuestionCount_'.$i]; $k++)
            {
                if(isset($_POST['QuestionTitle_'.$i.'_'.$k]))
                {
                    $insert_question = mysqli_query($DbConn, "insert into tbl_defaultquestions set QuestionTitle='".addslashes($_POST['QuestionTitle_'.$i.'_'.$k])."', QuestionGroupID='".$QuestionGroupID."'") or die(mysqli_error($DbConn));
                }
            }
        }
    }
        $message= "Defaut question added successfully.";
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
    <title>Defaut Questions- Admin</title>
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
            Defaut Questions
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
                  <div class="box-body" id="box-body">
                    <?php 
                          $count_group=0;
                          $select_groups = mysqli_query($DbConn, "select * from tbl_defaultquestiongroups") or die(mysqli_error($DbConn));
                          echo '<input type="hidden" name="GroupCount" id="GroupCount" value="'.mysqli_num_rows($select_groups).'"/>';
                          while($groupinfo=mysqli_fetch_object($select_groups))
                          {
                              $count_question=0;
                              $count_group++;
                      ?>
                      <div id="GroupContainer_<?php echo $count_group;?>">
                      <?php if($count_group != 1){?>
                          <div class="col-md-12"><hr style="background-color: blue; height: 1px;"></div>
                          <?php } ?>
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>GROUP <?php //echo $count_group;?></label>
                                    <span style="float:right;">
                                    <a href="javascript:void(0);" onclick="RemoveContainer('GroupContainer_<?php echo $count_group;?>');">Remove Group</a> || 
                                    <a href="javascript:void(0);" onclick="AddQuestion('<?php echo $count_group;?>', 'QuestionCount_<?php echo $count_group;?>');" >Add More Question</a>
                                    </span>    
                                    <input type="text" class="form-control" id="QuestionGroupTitle_<?php echo $count_group;?>" name="QuestionGroupTitle_<?php echo $count_group;?>" required placeholder="Group Title" value="<?php echo stripslashes($groupinfo->QuestionGroupTitle);?>" style="background-color:#eee;font-size:15px;font-weight:bold;">
                                </div>
                             </div>
                      <?php
                           $select_questions = mysqli_query($DbConn, "select * from tbl_defaultquestions where QuestionGroupID='".$groupinfo->QuestionGroupID."'") or die(mysqli_error($DbConn));
                            echo '<input type="hidden" name="QuestionCount_'.$count_group.'" id="QuestionCount_'.$count_group.'" value="'.mysqli_num_rows($select_questions).'"/>';
                          while($questioninfo=mysqli_fetch_object($select_questions))
                          {
                              $count_question++;
                      ?>
                             <div class="col-md-12" id="QuestionContainer_<?php echo $count_group;?>_<?php echo $count_question;?>">  
                                <div class="form-group">
                                    <label>Question <?php //echo $count_question;?></label>
                                    <a href="javascript:void(0);" onclick="RemoveContainer('QuestionContainer_<?php echo $count_group;?>_<?php echo $count_question;?>');" style="float:right;">Remove Question</a>
                                    <input type="text" class="form-control" id="QuestionTitle_<?php echo $count_group;?>_<?php echo $count_question;?>" name="QuestionTitle_<?php echo $count_group;?>_<?php echo $count_question;?>" required placeholder="Question Title" value="<?php echo stripslashes($questioninfo->QuestionTitle);?>">
                                </div>
                             </div>
                      
                      
                    <?php } ?>
                    </div>
                          
                    <?php } ?>
                    
                    
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                      <div class="col-md-12"><a style="float:right;" href="javascript:void(0);" onclick="AddGroup('box-body', 'GroupCount');" >Add More Group</a></div>
                    <input type="submit" class="btn btn-primary" name="Submit" value="Submit" />
                    <a href="index.php" class="btn btn-default m-b-sm">Cancel</a>
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
    function AddQuestion(GroupNumber, QuestionCountID)
    {
        //
        TotalCount = $('#'+QuestionCountID).val();
        TotalCount++;
        $('#GroupContainer_'+GroupNumber).append('<div class="col-md-12" id="QuestionContainer_'+GroupNumber+'_'+TotalCount+'"><div class="form-group"><label>Question <!--'+TotalCount+'--></label><a href="javascript:void(0);" onclick="RemoveContainer(\'QuestionContainer_'+GroupNumber+'_'+TotalCount+'\');" style="float:right;">Remove Question</a><input type="text" class="form-control" id="QuestionTitle_'+GroupNumber+'_'+TotalCount+'" name="QuestionTitle_'+GroupNumber+'_'+TotalCount+'" required placeholder="Question Title"></div></div>');
        $('#'+QuestionCountID).val(TotalCount);
        //$('#QuestionContainer_'+GroupNumber+'_'+TotalCount).effect( "highlight", {color:"#669966"}, 3000 );
    }
        
    function AddGroup(boxbody, GroupCount)
    {
        TotalCount = $('#'+GroupCount).val();
        TotalCount++;
        $('#'+boxbody).append('<div id="GroupContainer_'+TotalCount+'"><div class="col-md-12"><hr style="background-color: blue; height: 1px;"></div><div class="col-md-12"><div class="form-group"><label>GROUP <!--'+TotalCount+'--></label><span style="float:right;"><a href="javascript:void(0);" onclick="RemoveContainer(\'GroupContainer_'+TotalCount+'\');">Remove Group</a> || <a href="javascript:void(0);" onclick="AddQuestion(\''+TotalCount+'\', \'QuestionCount_'+TotalCount+'\');" >Add More Question</a></span><input type="text" class="form-control" id="QuestionGroupTitle_'+TotalCount+'" name="QuestionGroupTitle_'+TotalCount+'" required placeholder="Group Title" style="background-color:#eee;font-size:15px;font-weight:bold;"/></div></div><input type="hidden" name="QuestionCount_'+TotalCount+'" id="QuestionCount_'+TotalCount+'" value="0"/></div>');
        $('#'+GroupCount).val(TotalCount);
        AddQuestion(TotalCount, 'QuestionCount_'+TotalCount);
    }
    </script>
  </body>
</html>