<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Client | Freelance Punch Card | Presented by: Andrew Ribeiro</title>
<style type="text/css">
<!--

#mainBody 
{
	background-color:#CBFF97;
	padding:1em;
	position:relative; 
	top:-1px;
	left:-1px;
	min-width:800px;
	
}
-->
</style>
<link href="styles/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>

<center>
	<div style="width:70%; border-top-width:0px;">
		<div id="mainBody" align="center">
			<div align="center">
				<div class="pageTitle">ADD NEW CLIENT </div>
				<p><a href="index.php"><img src="_images/logo.jpg" alt="Freelance Punch Card Logo" width="445" height="95" border="0" /></a></p>
				<p><a href="index.php" style="text-decoration:none;"><button>HOME</button></a></p>
				<hr />
				<form id="form1" name="form1" method="post" action="actions/do.createClient.php">
			      <label>Client Name: </label><input type="text" name="fname" />&nbsp;<input type="text" name="lname" /><br /><br />
				  <label>Email Address: </label><input name="email" type="text" size="50" /><br /><br />
				  
				  <input name="" type="submit" value="Create Client" /><input name="" type="reset" />
		      </form>
	      </div>

		</div>
	</div>
	
	<div style="width:70.5%; ">
	<center>
    </center>
	</div>
	
</center>

</body>
</html>
