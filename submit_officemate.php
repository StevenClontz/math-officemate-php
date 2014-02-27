<?php
session_start();

if(!isset($_SESSION['id']) || !isset($_POST))
	{
	$_SESSION['msg']="Whoops! I don't think you accessed this page the right way... Please try again!";
	header( 'Location: index.php?p=home' ) ;
	die();
	}

$database="clontscdb";
$username="clontsc";
$password="clontscm4rch";
$host="web7.duc.auburn.edu";

$_SESSION['test']=$_POST;

mysql_connect($host,$username,$password);
@mysql_select_db($database) or die("ERROR: Unable to select database. Please contact the webmaster for details.");


$query = <<<EOT
UPDATE `math_office_gtas`
SET `officemate_id`={$_POST['officemate_id']}
WHERE `id`={$_SESSION['id']}
EOT;

$result=mysql_query($query);


	$_SESSION['officemate_id']=$_POST['officemate_id'];
	$_SESSION['msg']="I got your officemate request. Thanks!";
	header( 'Location: index.php?p=home' ) ;
mysql_close();
?>