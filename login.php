<?php
session_start();

if(!isset($_POST))
	{
	$_SESSION['msg']="Whoops! I didn't have the proper name and Banner ID, so I couldn't log you in. Please check your information and try again!";
	header( 'Location: index.php?p=home' ) ;
	die();
	}

$database="clontscdb";
$username="clontsc";
$password="clontscm4rch";
$host="web7.duc.auburn.edu";

mysql_connect($host,$username,$password);
@mysql_select_db($database) or die("ERROR: Unable to select database. Please contact the webmaster for details.");

$query = "
SELECT id, name, au_user_id, banner_id, officemate_id
FROM math_office_gtas
";
$result=mysql_query($query);

$id = 0;
$name = "";
$officemate_id = 0;
while ($gta=mysql_fetch_assoc($result))
	{
	if($_POST['au_user_id']==$gta['au_user_id'] && $_POST['banner_id']==$gta['banner_id'])
		{
		$id=$gta['id'];
		$name=$gta['name'];
		$officemate_id=$gta['officemate_id'];
		$au_user_id=$gta['au_user_id'];
		}
	}

if($id==0)
	{
	$_SESSION['msg']="Whoops! I didn't have the proper name and Banner ID, so I couldn't log you in. Please check your information and try again!";
	header( 'Location: index.php?p=home' ) ;
	die();
	}
else
	{
	$_SESSION['id']=$id;
	$_SESSION['name']=$name;
	$_SESSION['officemate_id']=$officemate_id;
	$_SESSION['au_user_id']=$au_user_id;
	header( 'Location: index.php?p=home' ) ;
	}
?>