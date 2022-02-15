<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
header('Access-Control-Max-Age: 3600');

error_reporting(0);
//echo md5('Test123');die;
//error_reporting(E_ALL);ini_set('display_errors', 1); 
	/* 
		This is an example class script proceeding secured API
		To use this class you should keep same as query string and function name
		Ex: If the query string value rquest=delete_user Access modifiers doesn't matter but function should be
		     function delete_user(){
				 You code goes here
			 }
		Class will execute the function dynamically;
		
		usage :
		
		    $object->response(output_data, status_code);
			$object->_request	- to get santinized input 	
			
			output_data : JSON (I am using)
			status_code : Send status message for headers
			
		Add This extension for localhost checking :
			Chrome Extension : Advanced REST client Application
			URL : https://chrome.google.com/webstore/detail/hgmloofddffdnphfgcellkdfbfbjeloo
     */
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
	require_once '../resources/vendor/autoload.php';
	require_once("Rest.inc.php");
    //define('SITE_URL', 'http://localhost/mindyourstep.nl/');
    define('SITE_URL', 'https://www.mindyourstep.nl/');
    define('COMPANY_IMAGE_URL', 'resources/images/companys/');
    define('PROJECT_IMAGE_URL', 'resources/images/projects/');
    define('PDF_FILE_URL', 'resources/pdf/');
	
	class API extends REST {
	
		public $data = "";
		public $per_page = 10;
        
        /*const DB_SERVER = "localhost";
		const DB_USER = "root";
		const DB_PASSWORD = "SohailSheikh";
		const DB = "metten_mindyourstep";*/
        
        const DB_SERVER = "rdbms.strato.de";
		const DB_USER = "U4185299";
		const DB_PASSWORD = "SohailSheikh#2020";
		const DB = "DB4185299";

		private $db = NULL;
        
		public function __construct(){
			parent::__construct();				// Init parent contructor
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') 
            {
                json_output(200, NULL);
                exit;
            }
			$this->dbConnect();					// Initiate Database connection            
		}
		
		/*
		 *  Database connection 
		*/
		private function dbConnect(){
			$this->db = mysqli_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db)
				mysqli_select_db($this->db, self::DB);
                mysqli_query($this->db, 'SET CHARACTER SET utf8');
		}
		
		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['request'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);				// If the method not exist with in this class, response would be "Page not found".
		}
        
        private function encrypt($sData){
            $id=(double)$sData*525325.24;
            return base64_encode($id);
        }
        
        private function login()
        {
            $UserPassword=$this->_request['UserPassword'];
            $UserEmail=$this->_request['UserEmail'];

            if(empty($UserPassword) || empty($UserEmail))
            {
                $result['msg']="Invalid data provided!";
                $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }
            $sql=mysqli_query($this->db, "select * from tbl_users where UserEmail='".$UserEmail."' and UserPassword='".md5($UserPassword)."'")or die(mysqli_error($this->db));
            $result = array();
            if(mysqli_num_rows($sql) == 0){
              $result['message']="Incorrect Login !";
              $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }
            else
            {
                while($rlt = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
                    $result['UserID'] = $rlt['UserID'];
                    $result['UserFullName'] = $rlt['UserFullName'];
                    $result['UserMobileNo'] =$rlt['UserMobileNo'];
                    $result['UserEmail'] = $rlt['UserEmail'];
				}
				// If success everythig is good send header as "OK" and return list of users in JSON format
				$this->response($this->json(array('success'=>'success', 'data'=>$result)), 200);
            }
        }
        
        private function questions()
        {
            $UserID = $this->_request['UserID'];
            $addquery = '';            
            $result = array();
            if(empty($UserID))
            {
                $result['msg']="Invalid data provided!";
                $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }

            $sql=mysqli_query($this->db, "select C.*, S.QuestionSetID from tbl_companys C, tbl_companyusers CU, tbl_questionsets S where C.CompanyStatus=1 and CU.UserID='".$UserID."' and CU.CompanyID=C.CompanyID AND C.CompanyID=S.QuestionSetCompanyID AND ('".date('Y-m-d')."' BETWEEN S.QuestionSetStartDate AND S.QuestionSetEndDate) ".$addquery." GROUP BY C.CompanyID") or die(mysqli_error($this->db));
            
            if(mysqli_num_rows($sql) == 0){
              $this->response($this->json(array('success'=>'success',  'msg'=>'No questions found for this user.', 'data'=>array())), 200);
            }
            while($rlt = mysqli_fetch_array($sql))
            {
                $result['CompanyID'] = $rlt['CompanyID'];
                $result['QuestionSetID'] = $rlt['QuestionSetID'];
                $result['CompanyName'] = stripslashes($rlt['CompanyName']);
                $result['CompanyLogo'] = SITE_URL.COMPANY_IMAGE_URL.$rlt['CompanyLogo'];
                $result['CompanyDescription'] = stripslashes($rlt['CompanyDescription']);
                
                $QuestionGroupsArray=array();
                $sql_questiongroups=mysqli_query($this->db, "select G.QuestionGroupID, G.QuestionGroupTitle from tbl_questiongroups G where G.QuestionGroupCompanyID='".$result['CompanyID']."' AND QuestionSetID='".$result['QuestionSetID']."' AND G.QuestionGroupType='0' ORDER BY G.QuestionGroupID") or die(mysqli_error($this->db));
                while($groupinfo = mysqli_fetch_assoc($sql_questiongroups))
                {
                    $sql_questions=mysqli_query($this->db, "select QuestionID, QuestionTitle from tbl_questions where QuestionGroupID='".$groupinfo['QuestionGroupID']."' AND QuestionCompanyID='".$result['CompanyID']."' ORDER BY QuestionID") or die(mysqli_error($this->db));
                    
                    $QuestionTitleArray=array();
                    while($questionsinfo = mysqli_fetch_assoc($sql_questions))
                    {
                        array_push($QuestionTitleArray, array("QuestionID" => stripslashes($questionsinfo['QuestionID']), "QuestionTitle" => stripslashes($questionsinfo['QuestionTitle'])));
                    }
                    array_push($QuestionGroupsArray, array("QuestionGroupTitle" => stripslashes($groupinfo['QuestionGroupTitle']), 'Question' => $QuestionTitleArray));
                }
                $result['QuestionGroups'] = $QuestionGroupsArray;
            }
            $this->response($this->json(array('success'=>'success','data'=>$result)), 200);
       }
    
        
        private function uploadfile()
        {
            $QuestionID = $this->_request['QuestionID'];
            $UserID = $this->_request['UserID'];
            
            if(empty($QuestionID) || empty($UserID) || !isset($_FILES["Image"]))
            {
                $result['msg']="Invalid data provided!";
                $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }

            $ProjectImageName = $_FILES["Image"]['name'];
            $file_name = $QuestionID.'_'.$UserID.'_'.time().$ProjectImageName;
            $file_tmp =$_FILES['Image']['tmp_name'];

            $file_ext=strtolower(end(explode('.', $ProjectImageName)));
            $expensions= array("jpeg","jpg","png");
            if(in_array($file_ext,$expensions)=== false){
             $errors="extension not allowed, please choose a JPEG or PNG file.";
            }
            if($errors == '')
            {
                move_uploaded_file($file_tmp, "../".PROJECT_IMAGE_URL.$file_name);
                $this->correctImageOrientation('../'.PROJECT_IMAGE_URL.$file_name);
                $result['ImageName']=$file_name;
                $result['QuestionID']=$QuestionID;
                $this->response($this->json(array('success'=>'success','data'=>$result)), 200);
            }
            else
            {
                $result['msg'] = $errors;
                $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }
            
            /*$data_image = file_get_contents($Image);
            $image_name = $QuestionID.'_'.$UserID.'_'.time().'.jpg';
            $new_image = '../'.PROJECT_IMAGE_URL.$image_name;

            if(file_put_contents($new_image, $data_image))
            {
                $result['ImageName']=$image_name;
                $this->response($this->json(array('success'=>'success','data'=>$result)), 200);
            }
            else
            {
                $result['msg']="Error occured while saving file!";
                $this->response($this->json(array('success'=>'error','data'=>$result)), 200);
            }*/
        }
        
        private function addproject()
        {
            $CompanyID = $this->_request['CompanyID'];
            $ProjectQuestionSetID = $this->_request['QuestionSetID'];
            $ProjectUserID = $this->_request['ProjectUserID'];
            $ProjectUserName = $this->_request['ProjectUserName'];
            $ProjectTitle = $this->_request['ProjectTitle'];
            $ProjectDate = $this->_request['ProjectDate'];
            $ProjectDescription = $this->_request['ProjectDescription'];
            $ProjectImage = $this->_request['ProjectImage'];
            $QuestionIDArray = $this->_request['QuestionIDArray'];
            $NewQuestionTotal = $this->_request['NewQuestionTotal'];
            $IsCompleted = $this->_request['IsCompleted'];
            $addquery='';
            //|| !is_array($QuestionIDArray)
            if(empty($CompanyID) || empty($ProjectQuestionSetID) || empty($ProjectUserID) || empty($ProjectTitle) || empty($ProjectDate) || empty($QuestionIDArray))
            {
                $result['msg']="Invalid data provided!";
                $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }
            
            if($IsCompleted == 1)
            {
                $addquery.= ", ProjectIsCompleted='".$IsCompleted."'";
            }
            
            $sql=mysqli_query($this->db, "insert into tbl_projects set ProjectCompanyID='".addslashes($CompanyID)."', ProjectQuestionSetID='".addslashes($ProjectQuestionSetID)."', ProjectUserID='".addslashes($ProjectUserID)."', ProjectTitle='".addslashes($ProjectTitle)."', ProjectDate='".addslashes($ProjectDate)."', ProjectUserName='".addslashes($ProjectUserName)."', ProjectDescription='".addslashes($ProjectDescription)."'".$addquery) or die(mysqli_error($this->db));
            $ProjectID = mysqli_insert_id($this->db);
            
            $QuestionIDArray = explode(",", $QuestionIDArray);
            foreach($QuestionIDArray as $QuestionID)
            {
                $addquery="";
                $Answer = $this->_request['Answer_'.$QuestionID];
                $PhotoName = $this->_request['PhotoName_'.$QuestionID];
                $Comment = $this->_request['Comment_'.$QuestionID];
                if(!empty($PhotoName))
                {
                    $addquery=" , AnswerPhotoName='".$PhotoName."'";
                }
                $sql = mysqli_query($this->db, "insert into tbl_questionanswers set AnswerQuestionID='".$QuestionID."', AnswerValue='".addslashes($Answer)."', AnswerComment='".addslashes($Comment)."', AnswerProjectID='".$ProjectID."'".$addquery) or die(mysqli_error($this->db));     
            }
            $QuestionGroupID = '0';
            for($i=1; $i<=$NewQuestionTotal; $i++)
            {
                $addquery="";
                if(isset($this->_request['NewQuestion_'.$i]))
                {
                    $NewQuestion = $this->_request['NewQuestion_'.$i];
                    $NewQuestionAnswer = $this->_request['NewQuestionAnswer_'.$i];
                    $NewComment = $this->_request['NewComment_'.$i];
                    $NewPhotoName = $this->_request['NewPhotoName_'.$i];
                    if(!empty($NewQuestion) || !empty($NewQuestionAnswer))
                    {
                        if($QuestionGroupID == '0')
                        {
                            $sql=mysqli_query($this->db, "insert into tbl_questiongroups set QuestionGroupCompanyID='".$CompanyID."', QuestionGroupType='1', QuestionGroupProjectID='".$ProjectID."', QuestionGroupTitle='ADD MORE GROUP'") or die(mysqli_error($this->db));
                            $QuestionGroupID = mysqli_insert_id($this->db);
                        }
                        else
                        {
                            if(!empty($NewPhotoName))
                            {
                                $addquery=" , AnswerPhotoName='".$NewPhotoName."'";
                            }
                            $sql=mysqli_query($this->db, "insert into tbl_questions set QuestionCompanyID='".$CompanyID."', QuestionGroupID='".$QuestionGroupID."', QuestionTitle='".addslashes($NewQuestion)."'") or die(mysqli_error($this->db));
                            $QuestionID = mysqli_insert_id($this->db);
                            $sql=mysqli_query($this->db, "insert into tbl_questionanswers set AnswerQuestionID='".$QuestionID."', AnswerValue='".addslashes($NewQuestionAnswer)."', AnswerComment='".addslashes($NewComment)."', AnswerProjectID='".$ProjectID."'".$addquery) or die(mysqli_error($this->db));
                        }
                    }
                }
            }
            if($IsCompleted == 1)
            {
                $this->generatepdf($ProjectID);
            }
            $result['ProjectID'] = $ProjectID;
            $result['msg'] = "Project posted successfully! ProjectID=".$ProjectID;
            $this->response($this->json(array('success'=>'success', 'data'=>$result)), 200);
       }
        
       private function editproject()
       {
           $ProjectID = $this->_request['ProjectID'];
           $ProjectUserID = $this->_request['ProjectUserID'];
           $ProjectUserName = $this->_request['ProjectUserName'];
           $ProjectTitle = $this->_request['ProjectTitle'];
           $ProjectDate = $this->_request['ProjectDate'];
           $ProjectDescription = $this->_request['ProjectDescription'];
           $QuestionIDArray = $this->_request['QuestionIDArray'];
           $IsCompleted = $this->_request['IsCompleted'];
           $addquery='';
           //|| !is_array($QuestionIDArray)
           if(empty($ProjectID) || empty($ProjectUserID) || empty($ProjectTitle) || empty($ProjectDate) || empty($QuestionIDArray))
           {
               $result['msg']="Invalid data provided!";
               $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
           }
           
           if($IsCompleted == 1)
           {
               $addquery.= ", ProjectIsCompleted='".$IsCompleted."'";
           }
           $sql=mysqli_query($this->db, "update tbl_projects set ProjectUserID='".addslashes($ProjectUserID)."', ProjectTitle='".addslashes($ProjectTitle)."', ProjectDate='".addslashes($ProjectDate)."', ProjectUserName='".addslashes($ProjectUserName)."', ProjectDescription='".addslashes($ProjectDescription)."'".$addquery." where ProjectID='".$ProjectID."'") or die(mysqli_error($this->db));
           
           $QuestionIDArray = explode(",", $QuestionIDArray);
           foreach($QuestionIDArray as $QuestionID)
           {
               $addquery="";
               $Answer = $this->_request['Answer_'.$QuestionID];
               $PhotoName = $this->_request['PhotoName_'.$QuestionID];
               $Comment = $this->_request['Comment_'.$QuestionID];
               //if(!empty($PhotoName)){
                $addquery=" , AnswerPhotoName='".$PhotoName."'";
               //}
               $sql = mysqli_query($this->db, "update tbl_questionanswers set AnswerValue='".addslashes($Answer)."', AnswerComment='".addslashes($Comment)."'".$addquery." where AnswerProjectID='".$ProjectID."' AND AnswerQuestionID='".$QuestionID."'") or die(mysqli_error($this->db));     
           }
            if($IsCompleted == 1)
            {
                $this->generatepdf($ProjectID);
            }
           $result['ProjectID'] = $ProjectID;
           $result['msg'] = "Project updated successfully! ProjectID=".$ProjectID;
           $this->response($this->json(array('success'=>'success', 'data'=>$result)), 200);
      }

        private function project()
        {
            $ProjectID=$this->_request['ProjectID'];

            if(empty($ProjectID))
            {
                $result['msg']="Invalid data provided!";
                $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }
            $sql=mysqli_query($this->db, "select * from tbl_projects where ProjectID='".$ProjectID."'")or die(mysqli_error($this->db));
            $result = array();
            if(mysqli_num_rows($sql) == 0){
              $result['message']="Incorrect ID !";
              $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }
            else
            {
                while($rlt = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                {
                    $result['ProjectUserID'] = $rlt['ProjectUserID'];
                    $result['ProjectCompanyID'] = $rlt['ProjectCompanyID'];
                    $result['ProjectTitle'] = $rlt['ProjectTitle'];
                    $result['ProjectDate'] =$rlt['ProjectDate'];
                    $result['ProjectDescription'] = $rlt['ProjectDescription'];

                    $sql=mysqli_query($this->db, "select C.* from tbl_companys C where C.CompanyID='".$result['ProjectCompanyID']."'") or die(mysqli_error($this->db));
                    while($rlt = mysqli_fetch_array($sql))
                    {
                        $result['CompanyID'] = $rlt['CompanyID'];
                        $result['CompanyName'] = stripslashes($rlt['CompanyName']);
                        $result['CompanyLogo'] = SITE_URL.COMPANY_IMAGE_URL.$rlt['CompanyLogo'];
                        $result['CompanyDescription'] = stripslashes($rlt['CompanyDescription']);

                        $QuestionGroupsArray=array();
                        $sql_questiongroups=mysqli_query($this->db, "select QuestionGroupID, QuestionGroupTitle from tbl_questiongroups where QuestionGroupCompanyID='".$result['CompanyID']."' ORDER BY QuestionGroupID") or die(mysqli_error($this->db));
                        while($groupinfo = mysqli_fetch_assoc($sql_questiongroups))
                        {
                            $sql_questions=mysqli_query($this->db, "select QuestionID, QuestionTitle from tbl_questions where QuestionGroupID='".$groupinfo['QuestionGroupID']."' AND QuestionCompanyID='".$result['CompanyID']."' ORDER BY QuestionID") or die(mysqli_error($this->db));

                            $QuestionTitleArray=array();
                            while($questionsinfo = mysqli_fetch_assoc($sql_questions))
                            {
                                array_push($QuestionTitleArray, array("QuestionID" => stripslashes($questionsinfo['QuestionID']), "QuestionTitle" => stripslashes($questionsinfo['QuestionTitle'])));
                            }
                            array_push($QuestionGroupsArray, array("QuestionGroupTitle" => stripslashes($groupinfo['QuestionGroupTitle']), 'Question' => $QuestionTitleArray));
                        }
                        $result['QuestionGroups'] = $QuestionGroupsArray;
                    }
				}
                /*$ProjectImage=array();
                $sql_images=mysqli_query($this->db, "select * from tbl_projectimages WHERE ProjectID='".$ProjectID."'") or die(mysqli_error($this->db));
                while($rlt = mysqli_fetch_array($sql_images, MYSQLI_ASSOC)){
                     array_push($ProjectImage, $rlt['ProjectImage']);
                }
                $result['ProjectImage'] = $ProjectImage;*/
				// If success everythig is good send header as "OK" and return list of users in JSON format
				$this->response($this->json(array('success'=>'success', 'data'=>$result)), 200);
            }
        }
    
        private function list()
        {
            $result_list=array();
            $UserID=$this->_request['UserID'];
            if(empty($UserID))
            {
                $result['msg']="Invalid data provided!";
                $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }
            
            $sql=mysqli_query($this->db, "select C.*, P.* from tbl_companys C, tbl_companyusers CU, tbl_projects P where C.CompanyStatus=1 and CU.UserID='".$UserID."' and CU.CompanyID=C.CompanyID and C.CompanyID=P.ProjectCompanyID and CU.UserID=P.ProjectUserID ORDER BY ABS(P.ProjectID) DESC LIMIT 0, 20") or die(mysqli_error($this->db));
            if(mysqli_num_rows($sql) == 0){
              $this->response($this->json(array('success'=>'success', 'msg'=>'No record found.', 'data'=>array())), 200);
            }
            else
            {
                $result=array();
                while($rlt = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                {
                    $result['ProjectUserID'] = $rlt['ProjectUserID'];
                    $result['ProjectID'] = $rlt['ProjectID'];
                    $result['ProjectTitle'] = stripslashes($rlt['ProjectTitle']);
                    $result['ProjectDate'] =$rlt['ProjectDate'];
                    $result['ProjectUserName'] = stripslashes($rlt['ProjectUserName']);
                    $result['ProjectDescription'] = stripslashes($rlt['ProjectDescription']);
                    $result['ProjectIsCompleted'] = $rlt['ProjectIsCompleted'];
                    $result['CompanyID'] = $rlt['CompanyID'];
                    $result['QuestionSetID'] = $rlt['ProjectQuestionSetID'];
                    $result['CompanyName'] = stripslashes($rlt['CompanyName']);
                    $result['CompanyLogo'] = SITE_URL.COMPANY_IMAGE_URL.$rlt['CompanyLogo'];
                    $result['CompanyDescription'] = stripslashes($rlt['CompanyDescription']);

                    $QuestionGroupsArray=array();
                    $sql_questiongroups=mysqli_query($this->db, "select QuestionGroupID, QuestionGroupTitle from tbl_questiongroups where QuestionGroupCompanyID='".$result['CompanyID']."' AND QuestionSetID='".$result['QuestionSetID']."' AND (QuestionGroupProjectID='0' OR QuestionGroupProjectID='".$result['ProjectID']."') ORDER BY QuestionGroupID") or die(mysqli_error($this->db));
                    while($groupinfo = mysqli_fetch_assoc($sql_questiongroups))
                    {
                        $sql_questions=mysqli_query($this->db, "select QuestionID, QuestionTitle from tbl_questions where QuestionGroupID='".$groupinfo['QuestionGroupID']."' AND QuestionCompanyID='".$result['CompanyID']."' ORDER BY QuestionID") or die(mysqli_error($this->db));

                        $QuestionTitleArray=array();
                        while($questionsinfo = mysqli_fetch_assoc($sql_questions))
                        {
                            $sql_questionanswers=mysqli_query($this->db, "select * from tbl_questionanswers where AnswerProjectID='".$result['ProjectID']."' AND AnswerQuestionID='".$questionsinfo['QuestionID']."'") or die(mysqli_error($this->db));
                            $questionanswersinfo = mysqli_fetch_assoc($sql_questionanswers);
                            $AnswerPhotoName='';
                            if(!empty($questionanswersinfo['AnswerPhotoName']))
                            {
                                $AnswerPhotoName=SITE_URL.PROJECT_IMAGE_URL.$questionanswersinfo['AnswerPhotoName'];
                            }
                        
                            array_push($QuestionTitleArray, array("QuestionID" => stripslashes($questionsinfo['QuestionID']), "QuestionTitle" => stripslashes($questionsinfo['QuestionTitle']), "Answer" => stripslashes($questionanswersinfo['AnswerValue']), "AnswerComment" => stripslashes($questionanswersinfo['AnswerComment']), "AnswerPhotoUrl" => $AnswerPhotoName, "AnswerPhotoName" => $questionanswersinfo['AnswerPhotoName']));
                        }
                        array_push($QuestionGroupsArray, array("QuestionGroupTitle" => stripslashes($groupinfo['QuestionGroupTitle']), 'Question' => $QuestionTitleArray));
                    }
                        $result['QuestionGroups'] = $QuestionGroupsArray;

                        array_push($result_list, $result);
				}
				// If success everythig is good send header as "OK" and return list of users in JSON format
				$this->response($this->json(array('success'=>'success', 'data'=>$result_list)), 200);
            }
        }
        
        private function generatepdf($ProjectID)
        {
            $sql=mysqli_query($this->db, "select P.*, C.* from tbl_projects P, tbl_companys C where C.CompanyID=P.ProjectCompanyID AND P.ProjectID='".$ProjectID."'")or die(mysqli_error($this->db));
            $result = array();
            if(mysqli_num_rows($sql) == 0){
              $result['message']="Incorrect ID !";
              $this->response($this->json(array('success'=>'error', 'data'=>$result)), 200);
            }
            else
            {
                while($rlt = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                {
                    $ProjectNumber = 'MYB-'.($ProjectID+100);
                    $update=mysqli_query($this->db, "update tbl_projects set ProjectNumber='".$ProjectNumber."' where ProjectID='".$ProjectID."'")or die(mysqli_error($this->db));
                    $html='<style>
                            table {
                                overflow: hidden;
                            }
                            td {
                                margin: 10px 0px 0px 0px;
                            }
                            .width-100 {
                                width:100%;
                                font-size: 12px;
                            }
                            .width-80 {
                                width:80%;
                            }
                            .width-50 {
                                width:50%;
                            }
                            .width-20 {
                                width:20%;
                            }
                            .block-title {
                                font-size:15px;
                                font-weight: bold;
                                margin: 10px 0px 10px 0px;
                            }
                            .block-sub-title {
                                font-weight: bold;
                            }
                            .color-gray {
                                color:gray;
                            }
                        </style>
                        <div class="block-title">Algemeen</div>';
                    
                    $result['ProjectTitle'] = stripslashes($rlt['ProjectTitle']);
                    $result['CompanyLogo'] = SITE_URL.COMPANY_IMAGE_URL.$rlt['CompanyLogo'];
                    $result['CompanyDescription'] = stripslashes($rlt['CompanyDescription']);
                    
                    $html.='<table class="width-100">
                                <tr>
                                    <td class="width-50">
                                        <div class="color-gray">Naam project</div>
                                        <div>'.stripslashes($rlt['ProjectTitle']).'</div>
                                    </td>
                                    <td class="width-50">
                                        <div class="color-gray">Bedrijfsnaam</div>
                                        <div>'.stripslashes($rlt['CompanyName']).'</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="width-50">
                                        <div class="color-gray">Projectnummer</div>
                                        <div>'.$ProjectNumber.'</div>
                                    </td>
                                    <td class="width-50">
                                        <div class="color-gray">Datum</div>
                                        <div>'.$rlt['ProjectDate'].'</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="width-50">
                                        <div class="color-gray">Ingevuld door</div>
                                        <div>'.stripslashes($rlt['ProjectUserName']).'</div>
                                    </td>
                                    <td class="width-50">
                                        <div class="color-gray">Bijzonderheden</div>
                                        <div>'.stripslashes($rlt['ProjectDescription']).'</div>
                                    </td>
                                </tr>
                            </table>';

                    $sql_questiongroups=mysqli_query($this->db, "select QuestionGroupID, QuestionGroupTitle from tbl_questiongroups where QuestionGroupCompanyID='".$rlt['CompanyID']."' AND QuestionSetID='".$rlt['ProjectQuestionSetID']."' AND (QuestionGroupProjectID='0' OR QuestionGroupProjectID='".$rlt['ProjectID']."') ORDER BY QuestionGroupID") or die(mysqli_error($this->db));
                    while($groupinfo = mysqli_fetch_assoc($sql_questiongroups))
                    {
                        $html.='<table class="width-100" style="border-collapse: separate;border-spacing: 0 1em;">
                                    <tr>
                                        <td class="width-80">
                                            <div class="block-sub-title">'.stripslashes($groupinfo['QuestionGroupTitle']).'</div>
                                        </td>
                                        <td class="width-20" align="right">
                                            <div class="block-sub-title">Resultaat</div>
                                        </td>
                                    </tr>';

                        $sql_questions=mysqli_query($this->db, "select QuestionID, QuestionTitle from tbl_questions where QuestionGroupID='".$groupinfo['QuestionGroupID']."' AND QuestionCompanyID='".$rlt['CompanyID']."' ORDER BY QuestionID") or die(mysqli_error($this->db));
                        while($questionsinfo = mysqli_fetch_assoc($sql_questions))
                        {
                            $sql_questionanswers=mysqli_query($this->db, "select * from tbl_questionanswers where AnswerProjectID='".$rlt['ProjectID']."' AND AnswerQuestionID='".$questionsinfo['QuestionID']."'") or die(mysqli_error($this->db));
                            $questionanswersinfo = mysqli_fetch_assoc($sql_questionanswers);
                            $AnswerCommentBlock='';
                            if(!empty($questionanswersinfo['AnswerComment']))
                            {
                                $AnswerCommentBlock='<div><span class="block-sub-title">Opmerking :-</span> '.stripslashes($questionanswersinfo['AnswerComment']).'</div>';
                            }
                            $AnswerPhotoBlock='';
                            if(!empty($questionanswersinfo['AnswerPhotoName']))
                            {
                                //$this->correctImageOrientation('../'.PROJECT_IMAGE_URL.$questionanswersinfo['AnswerPhotoName']);
                                $AnswerPhotoName='../'.PROJECT_IMAGE_URL.$questionanswersinfo['AnswerPhotoName'];
                                $AnswerPhotoBlock.='<div><br><img src="'.$AnswerPhotoName.'" width="80%"/></div>';
                            }
                            $html.='<tr style="padding-top: 10px;">
                                        <td class="width-80">
                                            <div>'.stripslashes($questionsinfo['QuestionTitle']).'</div>'.$AnswerCommentBlock.$AnswerPhotoBlock.'
                                        </td>
                                        <td class="width-20" align="right" style="vertical-align: top;">
                                            <div>'.stripslashes($questionanswersinfo['AnswerValue']).'</div>
                                        </td>
                                    </tr>';
                        }
                        $html.='</table><hr>';
                    }
				}
                //echo $html;die;
            }
            $mpdf = new \Mpdf\Mpdf(array(
                'mode' => 'utf-8', 
                'format' => 'A4',
                'margin_header' => 5,
                'margin_top' => 20,
                'margin_footer' => 10    
            ));
            $mpdf->SetHTMLHeader('<table width="100%"><tr><td width="80%" style="font-size:20px;font-weight:bold;">Werkplekinspectie: '.$result['ProjectTitle'].'</td><td width="20%" align="right"><img src="'.$result['CompanyLogo'].'" style="max-height: 50px;:"/></td></tr></table><br><br>');
            $mpdf->SetHTMLFooter('<table width="100%" style="font-size:10px;"><tr><td width="20%"><img src="../resources/images/rodenburg.png" width="120"/></td><td width="60%" align="center">Rodenburg & Van der Hoeven</td><td width="20%" style="text-align: right;">{PAGENO}/{nbpg}</td></tr></table>');
            $mpdf->WriteHTML($html);
            //$mpdf->Output();
            $mpdf->Output('../resources/pdf/'.$ProjectNumber.'.pdf', 'F');
            $this->sentemail($ProjectID);
        }
        
        private function correctImageOrientation($filename) {
          if (function_exists('exif_read_data')) {
            $exif = exif_read_data($filename);
            if($exif && isset($exif['Orientation'])) {
              $orientation = $exif['Orientation'];
              if($orientation != 1){
                $img = imagecreatefromjpeg($filename);
                $deg = 0;
                switch ($orientation) {
                  case 3:
                    $deg = 180;
                    break;
                  case 6:
                    $deg = 270;
                    break;
                  case 8:
                    $deg = 90;
                    break;
                }
                if ($deg) {
                  $img = imagerotate($img, $deg, 0);        
                }
                // then rewrite the rotated image back to the disk as $filename 
                imagejpeg($img, $filename, 95);
              } // if there is some rotation necessary
            } // if have the exif orientation info
          } // if function exists      
        }
        
        private function testpdf()
        {
            $this->generatepdf(1);
        }

        private function sentemail($ProjectID)
        {
            $sql=mysqli_query($this->db, "select P.*, C.*, U.UserFullName from tbl_projects P, tbl_companys C, tbl_users U where C.CompanyID=P.ProjectCompanyID AND U.UserID=P.ProjectUserID AND P.ProjectID='".$ProjectID."'")or die(mysqli_error($this->db));
            $rlt = mysqli_fetch_object($sql);

            $sql_email=mysqli_query($this->db, "select * from tbl_webemails where EmailID=1")or die(mysqli_error($this->db));
            $emailinfo = mysqli_fetch_object($sql_email);

            $EmailFrom = stripslashes($emailinfo->EmailFrom);
            $EmailReplyTo = stripslashes($emailinfo->EmailReplyTo);
            $EmailSubject = stripslashes($emailinfo->EmailSubject);
            $EmailMessage = $emailinfo->EmailMessage;

            $USERNAME = stripslashes($rlt->UserFullName);
            $COMPANYNAME = stripslashes($rlt->CompanyName);
            $EncryptProjectID = $this->encrypt($ProjectID);
            $PDFURL = '<a href="'.SITE_URL.'downloads.php?f='.$EncryptProjectID.'" target="_blank" title="pdf download">Click Here</a>';

            $EmailSubject = str_replace("{PDFURL}", $PDFURL, str_replace("{COMPANYNAME}", $COMPANYNAME, str_replace("{USERNAME}", $USERNAME, $EmailSubject)));
            $EmailMessage = str_replace("{PDFURL}", $PDFURL, str_replace("{COMPANYNAME}", $COMPANYNAME, str_replace("{USERNAME}", $USERNAME, $EmailMessage)));

            $CompanyEmails = explode('@@#@@', $rlt->CompanyEmails);
            foreach($CompanyEmails as $Email)
            {
                $mail = new PHPMailer;
                $mail->setFrom($EmailFrom, 'MindYourStep');
                $mail->addReplyTo($EmailReplyTo, 'MindYourStep');
                $mail->addAddress($Email, $COMPANYNAME);
                $mail->Subject = $EmailSubject;
                $mail->msgHTML($EmailMessage);
                $mail->AltBody = $EmailMessage;
                //$mail->addAttachment('images/phpmailer_mini.png');
                if (!$mail->send()) {
                    $res = 'Mailer Error: '. $mail->ErrorInfo;
                } else {
                    $res = 'Message sent!';
                }
            }
        }

        /*private function terms()
        {
            $sql=mysql_query("select * from tbl_staticpages where PID=1", $this->db) or die(mysql_error());
            $result = array();
            $rlt = mysql_fetch_array($sql, MYSQL_ASSOC);            
            $result['PID'] = $rlt['PID'];
            $result['Title'] = $rlt['PTitle'];
            $result['Description'] = $rlt['PDescription'];

            $this->response($this->json(array('success'=>'success', 'data'=>$result)), 200);
        }

        private function about()
        {
            $sql=mysql_query("select * from tbl_staticpages where PID=2", $this->db) or die(mysql_error());
            $result = array();
            $rlt = mysql_fetch_array($sql, MYSQL_ASSOC);            
            $result['PID'] = $rlt['PID'];
            $result['Title'] = $rlt['PTitle'];
            $result['Description'] = $rlt['PDescription'];

            $this->response($this->json(array('success'=>'success', 'data'=>$result)), 200);
        }

		/* 
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data, true);
			}
		}
	}
	
	// Initiiate Library
	
	$api = new API;
	$api->processApi();
?>