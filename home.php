<?php
$query = "
SELECT id, name, au_user_id, banner_id, officemate_id
FROM math_office_gtas
ORDER BY name
";
$gtaresult=mysql_query($query);
?>

<h1>Office Requests (Home)</h1>

<?php
if(!isset($_SESSION['id']))
	{
?>

<form name="login" action="login.php" method="post">
<p>Hey! To get started, I'll need you to select your name.</p>
<p> <strong>Name:</strong>
	<select name="au_user_id">
		<option value="No Selection" selected>No Selection</option>
<?php
while ($gta=mysql_fetch_assoc($gtaresult))
	{
?>
		<option value="<?php echo $gta['au_user_id']; ?>"><?php echo $gta['name']; ?></option>
<?php
	}
?>
	</select>
</p>
<p>Once you've selected your name, I'll need you to confirm your identity by entering your Banner ID number. That's the nine-digit number on your Tiger Card which begins with "902".</p>
<p> <strong>Banner ID:</strong>
	<input type="text" name="banner_id" maxlength="9" size="10" />
</p>
<p>Once you've done all that, hit "Ready!" and I'll check your information to make sure there's no errors.</p>
<p style="text-align:center;">
	<input type="submit" value="Ready!" />
</p>
</form>

<?php
	}
else
	{
$query = <<<EOF
SELECT `request_1`, `request_2`, `request_3`, `request_4`, `request_5`, `request_6`, `request_7`, `request_8`, `request_9`, `request_10`
FROM `math_office_requests`
WHERE `gta_id`={$_SESSION['id']}
EOF;
$requestresult=mysql_query($query);
?>

<p>If you are "<?php echo $_SESSION['name'];?>", then we're all set. <a href="?p=home&session=destroy">(Click here to log in as someone else.)</a></p>

<p>You may now either submit your preferences for offices, or request a roommate.</p>

<p>
<ul>
	<li><a href="?p=request">Submit Office Preferences</a></li>
	<li><a href="?p=officemate">Request an Officemate</a></li>
</ul>
</p>

<?php
while ($request=mysql_fetch_assoc($requestresult))
	{
?>
	<h3>
	Office Requests
	</h3>

	<p>
	Your current office requests are:
	</p>
	
	<p><ul>
	<?php
	for($i=1;$i<=10;$i++)
		{
	?>
		<li>Preference <?php echo $i; ?>: <?php echo $request['request_'.$i]; ?></li>
	<?php
		}
	?>
	</ul></p>
	
	<p>These can be updated by <a href="?p=request">resubmitting your office preferences</a>.</p>
	

<?php
	}
?>

<?php
if ($_SESSION['officemate_id']!=0)
	{
?>
	<h3>
	Officemate Request
	</h3>

	<p>
	You've requested 
"<?php
mysql_data_seek ($gtaresult, 0);

while ($gta=mysql_fetch_assoc($gtaresult))
	{
	if ($gta['id']==$_SESSION['officemate_id'])
		{
			echo $gta['name'];
		}
	}
?>" to be your officemate.
	</p>
	
<?php
mysql_data_seek ($gtaresult, 0);

while ($gta=mysql_fetch_assoc($gtaresult))
	{
	if ($gta['officemate_id']==$_SESSION['id'])
		{
?>
<p>He/she has confirmed you as their officemate.</p>
<?php
		}
	elseif ($_SESSION['officemate_id']==$gta['id'] && $gta['officemate_id']!=0 && $gta['officemate_id']!=$_SESSION['id'])
		{
?>
<p>He/she has requested a different officemate from you. Please select another roommate.</p>
<?php
		}
	elseif ($_SESSION['officemate_id']==$gta['id'])
		{
?>
<p>He/she has not requested an officemate yet. Contact that person to have them confirm you as their officemate selection.</p>
<?php
		}
	}
?>

	

<?php
	}
?>


<?php
	}
?>