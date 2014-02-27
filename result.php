<?php
$gtaquery=<<<EOT
SELECT *, math_office_gtas.id AS id, math_office_gtas.name AS name, math_office_requests.id AS request_id, math_office_requests.gta_id AS gta_id, math_office_offices.name AS office_name, math_office_offices.id AS office_id
FROM math_office_gtas
LEFT JOIN math_office_requests
ON math_office_gtas.id=math_office_requests.gta_id
LEFT JOIN math_office_offices
ON math_office_gtas.id=math_office_offices.gta_id
ORDER BY math_office_gtas.priority ASC
EOT;
$gtaresult=mysql_query($gtaquery);

$query = "
SELECT id, name
FROM math_office_offices
ORDER BY name ASC
";
$result=mysql_query($query);

while ($office=mysql_fetch_assoc($result))
	{
	$offices[$office['name']]++;
	}
?>

<h1>Assignment Results</h1>

<p>The following table has the computed results for office assignments by GTA, sorted by their priority:</p>

<p>
<ul>
	<li>* designates offices assigned randomly, as all requested offices were taken.</li>
	<li>✝ designates that the GTA was "pulled up" by a confirmed officemate of higher priority, and that their preferences were ignored.</li>
	<li><strike>Struck Through Officemates</strike> were officemate requests that were not confirmed by the desired officemate.</li>
</ul>
</p>

<table class="result">
	<tr>
		<th>Priority</th>
		<th>GTA Name</th>
		<th>Officemate</th>
		<th style="border-right:double;">Assigned Office</th>
<?php
if ($_GET['p']=="fullresult")
	{ // ONLY SHOW FOR STAFF
?>
		<th>1st Choice</th>
		<th>2nd Choice</th>
		<th>3rd Choice</th>
		<th>4th Choice</th>
		<th>5th Choice</th>
		<th>6th Choice</th>
		<th>7th Choice</th>
		<th>8th Choice</th>
		<th>9th Choice</th>
		<th>10th Choice</th>
	</tr>
<?php
	}
?>

<?php
while($gta=mysql_fetch_assoc($gtaresult))
	{
	if($gta['officemate_id']!=0)
		{// FIND THE OFFICEMATE'S NAME
		$officematequery=<<<EOT
SELECT `id`, `officemate_id`, `name`
FROM `math_office_gtas`
WHERE `id`={$gta['officemate_id']}
LIMIT 1
EOT;
		$officemateresult=mysql_query($officematequery);
		$officemate=mysql_fetch_assoc($officemateresult);
		if($officemate['officemate_id']==$gta['id'])
			{
			$officematetext=$officemate['name'];
			$isofficemate[$officemate['id']]="✝";
			}
		else
			{
			$officematetext="<strike>".$officemate['name']."</strike>";
			}
		}
	else
		{
		$officematetext="(none)";
		}
		
	if($gta['random']==1)
		{
		$randomast="*";
		}
	else
		{
		$randomast="";
		}

	
	echo <<<EOT
	<tr>
		<td>{$gta['priority']}</td>
		<td>{$gta['name']}</td>
		<td>{$officematetext}</td>
		<td style="border-right:double;font-weight:bold;">{$gta['office_name']}{$randomast}{$isofficemate[$gta['id']]}<br />
		({$offices[$gta['office_name']]})</td>
EOT;
	if ($_GET['p']=="fullresult")
		{ // ONLY SHOW FOR STAFF
		for($i=1;$i<=10;$i++)
			{// CREATE CELL FOR EACH OFFICE REQUEST
			if($gta['request_'.$i]==$gta['office_name'])
				{// THIS REQUEST WAS CHOSEN
				$chosen='style="font-weight:bold;"';
				}
			else
				{
				$chosen='';
				}
			echo <<<EOT
		<td {$chosen}>{$gta['request_'.$i]}<br />
		({$offices[$gta['request_'.$i]]})</td>
EOT;
			}
		}
	echo <<<EOT
	</tr>
EOT;
	}
?>

</table>

<p>On the sorting, a note from Dr. Smith:</p>

<p><blockquote>
The number of prelims passed was the main factor used for prioritization together with a weighted randomization.  The weighing had something to do with progress towards the plan of study and included such factors as entry date and other publically available information. You can tell them that I personally created the ordered list and passed it on to you.  I made sure that, with the exception of number of prelims passed, that the list has such a high degree of randomness that it does not indicate a ranking of the students by any confidential measure (such
as GPA).
</blockquote></p>
