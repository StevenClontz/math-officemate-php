<?php
$query = "
SELECT id, name, au_user_id, officemate_id
FROM math_office_gtas
";
$result=mysql_query($query);
?>

<h1>Compute Assignments</h1>

<p>Enter the code and hit submit to regenerate office assignments based on the preferences listed by the GTAs.</p>

<form name="assign" action="generate_assignments.php" method="post">
<p>Code: <input type="text" name="code" /></p>
	<p style="text-align:center;">
	<input type="submit" value="Submit" />
	</p>
</form>


