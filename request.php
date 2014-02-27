<?php
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

<h1>Request an Office (Choose your room.)</h1>

<?php
if(!isset($_SESSION['id']))
	{
?>
<p>Sorry, it seems like you haven't logged in yet! <a href="?p=home">Click here so you can tell me who you are.</a></p>
<?php
	}
elseif(TRUE)
	{
?>
<p>Sorry, sign-ups are over!</p>
<?php
	}
else
	{
?>

<p>Okay, great. Now you can tell me which offices you want.</p>
<p>"Preference 1" should be the office you want most, while "Preference 10" is your last choice. It's okay if you don't submit ten preferences, but if all your preferences are unavailable, you may be assigned an office randomly.</p>
<p><em>If you've already made your requests, they should be displayed on the <a href="?p=home">home page</a>.</em></p>

<form name="request" action="submit_request.php" method="post">
<p>
<table>
<?php
for($i=1;$i<=10;$i++)
	{
?>
	<tr>
	<td>
	Preference <?php echo $i;?>:	
	</td>
	<td>
		<select name="office<?php echo $i; ?>">
			<option value="" SELECTED>No Preference</option>
<?php
	foreach($offices as $officename => $officeseats)
		{
?>
			<option value="<?php echo $officename;?>"><?php echo $officename; ?> (Seats: <?php echo $officeseats;?>)</option>
<?php
		}
?>
		</select>
	</td>
	</tr>
<?php
	}
?>
</table>
</p>
<p>Once you're made your selections, click "All done!" and I'll save your preferences to the database.
	<p style="text-align:center;">
	<input type="submit" value="All done!" />
	</p>
</form>

<?php
	}
?>