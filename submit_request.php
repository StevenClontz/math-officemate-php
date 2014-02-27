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
DELETE FROM `math_office_requests`
WHERE `gta_id`='{$_SESSION['id']}'
EOT;
$result=mysql_query($query);

$query = <<<EOT
INSERT INTO `math_office_requests` (`gta_id`,`request_1`,`request_2`,`request_3`,`request_4`,`request_5`,`request_6`,`request_7`,`request_8`,`request_9`,`request_10`)
VALUES
	({$_SESSION['id']}, '{$_POST['office1']}', '{$_POST['office2']}', '{$_POST['office3']}', '{$_POST['office4']}', '{$_POST['office5']}', '{$_POST['office6']}', '{$_POST['office7']}', '{$_POST['office8']}', '{$_POST['office9']}', '{$_POST['office10']}');
EOT;

$result=mysql_query($query);



	$_SESSION['msg']="Requests submitted!";
	header( 'Location: index.php?p=home' ) ;

?>