<?php

function update_office($gta_id,$office_id,$random=0)
{
	$updateofficequery= <<<EOT
UPDATE `math_office_offices`
SET `gta_id`={$gta_id}, `random`={$random}
WHERE `id`={$office_id}
EOT;
	echo $updateofficequery . "\n\n";
	$result=mysql_query($updateofficequery);
    return $result;
}





session_start();

if($_SESSION['au_user_id']!="REDACTED" || !isset($_POST))
	{
	$_SESSION['msg']="Whoops! I don't think you accessed this page the right way... Please try again!";
	header( 'Location: index.php?p=home' ) ;
	die();
	}
	
if($_POST['code']!="REDACTED")
	{
	$_SESSION['msg']="Wroooong password. :(";
	header( 'Location: index.php?p=home' ) ;
	die();
	}

$database="REDACTED";
$username="REDACTED";
$password="REDACTED";
$host="REDACTED";

$_SESSION['test']=$_POST;

mysql_connect($host,$username,$password);
@mysql_select_db($database) or die("ERROR: Unable to select database. Please contact the webmaster for details.");





// ASSIGN BASED ON PREFERENCES AND ROOMMATES


$query = <<<EOT
SELECT *, math_office_gtas.id AS id, math_office_gtas.name AS name, math_office_requests.id AS request_id, math_office_requests.gta_id AS gta_id, math_office_offices.name AS office_name, math_office_offices.id AS office_id
FROM math_office_gtas
LEFT JOIN math_office_requests
ON math_office_gtas.id=math_office_requests.gta_id
LEFT JOIN math_office_offices
ON math_office_gtas.id=math_office_offices.gta_id
ORDER BY math_office_gtas.priority ASC
EOT;

$gtaresult=mysql_query($query);
?>

<pre>

<?php

echo $query."\n\n";

while ($gta=mysql_fetch_assoc($gtaresult))
	{ // GOES THROUGH EACH GTA
	
	if($gta['office_id']!=0)
		{
		$assigned[$gta['id']]=TRUE;
		}
		
	print_r($gta);
	echo "\n\n";
	
	for($i=1;$i<=10 && $assigned[$gta['id']]==FALSE;$i++)
		{ // GOES THROUGH PREFERENCES FOR EACH GTA
		
		$officequery= <<<EOT
SELECT `id`, `name`, `gta_id`
FROM `math_office_offices`
WHERE `name`='{$gta['request_'.$i]}' AND `gta_id` IS NULL
EOT;

		echo $officequery . "\n\n";
		
		$officeresult=mysql_query($officequery);
		
		while($office=mysql_fetch_assoc($officeresult))
		
			{ // GOES THROUGH EACH OFFICE
			
			
			print_r($office);
		
			
			if ($gta['officemate_id']==0)
				{ // IF NO OFFICEMATE IS DESIGNATED, ASSIGN THE OFFICE
				$result=update_office($gta['id'],$office['id']);
				$assigned[$gta['id']]=TRUE; // STOP TRYING TO ASSIGN AND MOVE TO NEXT GTA
				break;
				}
			else
				{ // IF THE GTA HAS A OFFICEMATE
				$officematequery= <<<EOT
SELECT `id`, `officemate_id`
FROM `math_office_gtas`
WHERE `id`={$gta['officemate_id']}
LIMIT 1
EOT;
				echo $officematequery."\n\n";
				$officemateresult=mysql_query($officematequery);
				$officemate=mysql_fetch_assoc($officemateresult);
				if ($officemate['officemate_id']==$gta['id'])
					{ // IF THE OFFICEMATE IS CONFIRMED
					$checkroomquery= <<<EOT
SELECT `id`
FROM `math_office_offices`
WHERE `name`='{$office['name']}' AND `id`!={$office['id']} AND `gta_id` IS NULL
LIMIT 1
EOT;
					echo $checkroomquery."\n\n";
					$checkroomresult=mysql_query($checkroomquery);
					if($checkroom=mysql_fetch_assoc($checkroomresult))
						{ // THERE IS ROOM FOR THE OFFICEMATE

						$result=update_office($gta['id'],$office['id']);
						$result=update_office($officemate['id'],$checkroom['id']);
						
						$assigned[$gta['id']]=TRUE; // STOP TRYING TO ASSIGN AND MOVE TO NEXT GTA
						$assigned[$officemate['id']]=TRUE; // ALSO DON'T REASSIGN OFFICEMATE
						
						break;
						}
					}
				else
					{ // IF THE OFFICEMATE IS NOT CONFIFRMED, ASSIGN THE OFFICE
					
					$result=update_office($gta['id'],$office['id']);
					
					$assigned[$gta['id']]=TRUE; // STOP TRYING TO ASSIGN AND MOVE TO NEXT GTA
					break;
					}
				}
			}
		}
	}









$query = <<<EOT
SELECT *, math_office_gtas.id AS id, math_office_gtas.name AS name, math_office_offices.id AS office_id, math_office_offices.name AS office_name
FROM math_office_gtas
LEFT JOIN math_office_offices
ON math_office_gtas.id=math_office_offices.gta_id
WHERE math_office_offices.name IS NULL
ORDER BY RAND()
EOT;

$gtaresult=mysql_query($query);

echo $query."\n\n";

while($gta=mysql_fetch_assoc($gtaresult))
	{ // GOES THROUGH EACH GTA
	
	if($gta['office_id']!=0)
		{
		$assigned[$gta['id']]=TRUE;
		}
		
	print_r($gta);
	echo "\n\n";
	
	if($assigned[$gta['id']]!=TRUE)
		{
		
		$officequery= <<<EOT
SELECT `id`, `name`, `gta_id`
FROM `math_office_offices`
WHERE `gta_id` IS NULL
EOT;

		echo $officequery . "\n\n";
		
		$officeresult=mysql_query($officequery);
		
		while($office=mysql_fetch_assoc($officeresult))
		
			{ // GOES THROUGH EACH OFFICE
			
			
			print_r($office);
		
			
			if ($gta['officemate_id']==0)
				{ // IF NO OFFICEMATE IS DESIGNATED, ASSIGN THE OFFICE
				$result=update_office($gta['id'],$office['id'],1);
				$assigned[$gta['id']]=TRUE; // STOP TRYING TO ASSIGN AND MOVE TO NEXT GTA
				break;
				}
			else
				{ // IF THE GTA HAS A OFFICEMATE
				$officematequery= <<<EOT
SELECT `id`, `officemate_id`
FROM `math_office_gtas`
WHERE `id`={$gta['officemate_id']}
LIMIT 1
EOT;
				echo $officematequery."\n\n";
				$officemateresult=mysql_query($officematequery);
				$officemate=mysql_fetch_assoc($officemateresult);
				if ($officemate['officemate_id']==$gta['id'])
					{ // IF THE OFFICEMATE IS CONFIRMED
					$checkroomquery= <<<EOT
SELECT `id`
FROM `math_office_offices`
WHERE `name`='{$office['name']}' AND `id`!={$office['id']} AND `gta_id` IS NULL
LIMIT 1
EOT;
					echo $checkroomquery."\n\n";
					$checkroomresult=mysql_query($checkroomquery);
					if($checkroom=mysql_fetch_assoc($checkroomresult))
						{ // THERE IS ROOM FOR THE OFFICEMATE

						$result=update_office($gta['id'],$office['id'],1);
						$result=update_office($officemate['id'],$checkroom['id'],1);
						
						$assigned[$gta['id']]=TRUE; // STOP TRYING TO ASSIGN AND MOVE TO NEXT GTA
						$assigned[$officemate['id']]=TRUE; // ALSO DON'T REASSIGN OFFICEMATE
						
						break;
						}
					}
				else
					{ // IF THE OFFICEMATE IS NOT CONFIFRMED, ASSIGN THE OFFICE
					
					$result=update_office($gta['id'],$office['id'],1);
					
					$assigned[$gta['id']]=TRUE; // STOP TRYING TO ASSIGN AND MOVE TO NEXT GTA
					break;
					}
				}
			}
		}
	}



?>
</pre>
<?php




//	$_SESSION['msg']="Rooms assigned.";
//	header( 'Location: index.php?p=home' ) ;
mysql_close();
?>