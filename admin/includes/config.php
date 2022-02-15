<?php
error_reporting(0);
//error_reporting(E_ALL);ini_set('display_errors', 1);
/*$DbConn=mysqli_connect("localhost", "root", "SohailSheikh") or die("Db connection issue!");
mysqli_set_charset($DbConn, 'utf8');
mysqli_select_db($DbConn, "metten_mindyourstep");*/

$DbConn=mysqli_connect("rdbms.strato.de", "U4185299", "SohailSheikh#2020") or die("Db connection issue!");
mysqli_set_charset($DbConn, 'utf8');
mysqli_select_db($DbConn, "DB4185299");
define("SITE_PATH", "https://localhost/mindyourstep.nl/admin/");

function encrypt($sData){
$id=(double)$sData*525325.24;
return base64_encode($id);
}
function decrypt($sData){
$url_id=base64_decode($sData);
$id=(double)$url_id/525325.24;
return $id;
}
?>