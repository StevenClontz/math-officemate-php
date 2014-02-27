<?php
$query = "
SELECT id, name, au_user_id, officemate_id
FROM math_office_gtas
";
$result=mysql_query($query);
?>

<h1>Designate a Officemate</h1>

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

<p>Let me know if you want an officemate.</p>

<form name="request" action="submit_officemate.php" method="post">
<p>
Officemate:
	<select name="officemate_id">
		<option value="" SELECTED>No Preference</option>
<?php
while ($gta=mysql_fetch_assoc($result))
	{
	if ($gta['id']!=$_SESSION['id'])
		{
?>
		<option value="<?php echo $gta['id']; ?>"><?php echo $gta['name']; ?></option>
<?php
		}
	}
?>
	</select>
</p>
<p>Once you've made your selection, click "Got it." and I'll save your preference to the database.
	<p style="text-align:center;">
	<input type="submit" value="Got it." />
	</p>
</form>

<p>
Note that your desired officemate must ALSO designate you or your preference will be ignored. Here is a list of GTAs who have designated you as a desired officemate:
</p>

<ul>
	<li><strong>People who have requested you as an officemate:</strong>
	<ul>
	
<?php
mysql_data_seek ($result, 0);

while ($gta=mysql_fetch_assoc($result))
	{
	if ($gta['officemate_id']==$_SESSION['id'])
		{
?>
		<li><?php echo $gta['name']; ?></li>
<?php
		}
	}
?>
	</ul></li>
</ul>



<?php
	}
?>