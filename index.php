<?php 
session_start();

if($_GET['session']=='destroy')
	{
	session_destroy();
	unset($_SESSION);
	}

$database="clontscdb";
$username="clontsc";
$password="clontscm4rch";
$host="web7.duc.auburn.edu";

mysql_connect($host,$username,$password);
@mysql_select_db($database) or die("ERROR: Unable to select database. Please contact the webmaster for details.");
?>
<!DOCTYPE html> 
<html> 
<head> 
<title>Math GTA Office Assignments</title> 

  <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="description" content="Math GTA Office Assignments" />
  <meta name="author" content="Steven Clontz steven.clontz@gmail.com" />

<link rel="stylesheet" href="http://auburn.edu/gsc/css/" media="screen" type="text/css" /> 
<meta charset="utf-8" /> 
<link rel="stylesheet" type="text/css" media="only screen and (max-device-width: 480px)" href="/template/styles/mobile.css" /> 
<link rel="stylesheet" href="/template/styles/print.css" media="print" type="text/css" /> 
<link rel="shortcut icon" href="/template/images/favicon.ico" /> 
<script type="text/javascript" src="/template/js/jquery-1.4.2.min.js"></script> 
 
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="/template/styles/ie.css" />
<![endif]--> 
<STYLE type="text/css">
table.result
{
background:#FFFFFF;
}
table.result th
{
border:1px solid black;
}
table.result td
{
border:1px solid black;
}
</STYLE>
</head> 

<?php /* Allows to limit a string to first n words, ignoring HTML */
function limit_text($text, $limit, $ending=" [...]") {
    $text = strip_tags($text);
    $words = str_word_count($text, 2);
    $pos = array_keys($words);
    if (count($words) > $limit) {
        $text = substr($text, 0, $pos[$limit]) . $ending;
    }
    return $text;
}
?>


<body> 
<div id="pageWrap">
  <div id="headerWrap"> 


<!-- Header section -->


    <div id="header"> 
      <div id="logo"> 
      	<a href="http://www.auburn.edu"><img src="/template/styles/images/headerLogo.png" alt="Auburn University Homepage" /></a> 
      </div> 
      <div id="headerTitle"> 
        <div class="topLinks"> 
          <a href="http://www.auburn.edu/main/sitemap.php">A-Z Index</a> | 
          <a href="http://www.auburn.edu/map">Map</a> | 
          <a href="http://www.auburn.edu/main/auweb_campus_directory.html" class="lastTopLink">People Finder</a> 
        </div> 
        <form action="http://search.auburn.edu" id="searchForm" method="get"> 
          <div class="searchBox"> 
            <input type="text" name="q" id="q" accesskey="q" size="28" tabindex="1" class="searchField" onfocus="if(this.value=='Search AU...'){this.value='';this.style.color='black'}" onblur="if(this.value=='')this.value='Search AU...';this.style.color='grey'" value="Search AU..." /> 
            <input type="image" src="/template/styles/images/searchButton2.png" name="sa" accesskey="z" tabindex="2" alt="Search" value="Submit" class="searchButton" /> 
          </div> 
          <input type="hidden" name="cx" value="006456623919840955604:pinevfah6qm" /> 
          <input type="hidden" name="ie" value="utf-8" /> 
          <label for="q" style=" position:absolute; left:-9999px; visibility:hidden;">Enter your search terms</label> 
        </form> 
        <div class="titleArea">Math GTA Office Assignments</div> 
      </div> 
    </div> 
<table class="nav"> 
	<tr> 
		<td><a href="http://math.auburn.edu/">Back to Math Department Website</td>
	</tr> 
</table> 
  </div> 


<!-- End header section -->


  <div id="contentArea"> 
    <div class="contentDivision"> 
	<p class="breadcrumb">
<?php
if(isset($_SESSION['id']))
	{
?>
Logged in as "<?php echo $_SESSION['name'];?>". <a href="?p=home&session=destroy">Log in as someone else.</a>
<?php
	}
else
	{
?>
(Not logged in.)
<?php
	}
?>
	</p>
	
<?php
// DISPLAY SESSION MESSAGES
if (isset($_SESSION["msg"]))
	{
?>
<p style="color:#f68026;"><?php echo $_SESSION["msg"]; ?></p>
<?php
	unset($_SESSION["msg"]);
	}
	
// BEGIN PAGE REQUESTS
if ($_GET['p']=="home"||$_GET['p']=="")
	{
	include "home.php";
	}
elseif ($_GET['p']=="request")
	{
	include "request.php";
	}
elseif ($_GET['p']=="assign")
	{
	include "assign.php";
	}
elseif ($_GET['p']=="how")
	{
	include "how.php";
	}
elseif ($_GET['p']=="submit")
	{
	include "submit.php";
	}
elseif ($_GET['p']=="officemate")
	{
	include "officemate.php";
	}
elseif ($_GET['p']=="result"||$_GET['p']=="fullresult")
	{
	include "result.php";
	}
else
	{
?>
	<h1>Page Not Found</h1>
	<p>Sorry, we couldn't find the page you were looking for. Our bad! Try a link on the left.</p>
<?php
	}
// END PAGE REQUESTS
?>

    </div> 
    <div class="sidebar"> 
      <h1>Links</h1> 

<ul>
	<li><a href="?p=home">Office Request Home</a>
	<li><a href="?p=how">How Offices were Assigned</a>
	<li><a href="?p=fullresult">Office Assignment Results</a></li>
</ul>




    </div> 
  </div> 
  <div id="contentArea_bottom"></div> 
  <div id="footerWrap"> 
    <div id="footer"> 
    <div id="footSectionWrap"> 
	  <div class="footSection"> 
        <ul> 
          <li>
			Auburn University<br />
			Auburn, AL 36849
		  </li> 
        </ul> 
      </div> 
      <div class="footSection"> 
        <ul> 
          <li></li>
        </ul> 
      </div> 
      <div class="footSection noBorder"> 
        <ul> 
          <li>email the designer:<br /> <a href="mailto:steven.clontz@auburn.edu">steven.clontz@auburn.edu</a></li> 
        </ul> 
      </div> 
    </div> 
    </div>  
  </div> 
  <script type="text/javascript"> 
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
 
	try {
		var mainAU_tracker = _gat._getTracker("UA-2228003-3");
		mainAU_tracker._trackPageview();
	} catch(err) {}
</script> 
</div> 
<!--#include virtual="/template/includes/gatc.html" -->
</body> 
</html>
<?php
mysql_close();
?>