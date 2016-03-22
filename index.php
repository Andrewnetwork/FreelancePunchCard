<?php 

require_once("constants.php");

$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);

$sql = 'SELECT project.project_id, project.name,DATE_FORMAT(project.dateCreated,"%m-%d-%Y")dateCreated,clientName.fullName      
        FROM project,
       (SELECT client_id , CONCAT(fname," ",lname)"fullName" FROM client)clientName
        WHERE clientName.client_id = project.client_id AND project.finished IS NULL 
		ORDER BY project.project_id DESC;';
		
$htmlProjects = ""; 

$result = $mysqli->query( $sql );

while( $row = $result->fetch_assoc() )
{
	$sql = 'SELECT COUNT(project_id)"count"
			FROM timesheet
			WHERE `project_id` = '.$row["project_id"].';';
	$re = $mysqli->query( $sql );
	$rowCount = $re->fetch_assoc();
	
	$htmlProjects .='<div style="clear:both; margin-bottom:35px;">
		<div class="timeSheetLink">
			<div class="projectName">'.$row["name"].'</div>
			<div class="clientName">| '.$row["fullName"].'</div>
			<div class="dateStart">| '.$row["dateCreated"].'</div>
			<div class="timeSheets">| Timesheets('.$rowCount["count"].')</div>
			&nbsp;
		</div>
		<div style="float:right;">
			<form style="float:left" action="projectPage.php" method="POST">
				<button type="submit">Project Page</button>
				<input name="project_id" type="hidden" value="'.$row['project_id'].'" />
			</form>
				
				<button onclick="markAsComplete(\''.$row['project_id'].'\',this.parentNode.parentNode)">
					Mark as complete
				</button>
			
			
		</div>
	</div>';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Home | Freelance Punch Card | Presented by: Andrew Ribeiro</title>
<script language="javascript" type="text/javascript" src="scripts/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="scripts/indexScript.js"></script>

<link rel="icon" type="image/png" href="_images/fav.png">

<style type="text/css">
<!--


.timeSheetLink
{
background-color:#B5FF6A;
border:#999999 thin dotted;

}


.projectName , .clientName , .dateStart, .timeSheets
{
	float:left;
	margin-right:10px;
	overflow:hidden;
}

.projectName
{
width:35%;
padding-left:1em;
}

.clientName
{
width:20%;
}

.dateStart
{
width:15%;
}

.timeSheets
{

}


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
<style type="text/css">
<!--
.style5 {font-size: large; color: #70DF00; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style7 {
	font-size: 24px;
	font-weight: bold;
	color: #58B000;
}
-->
</style>
</head>

<body>

<center>
	<div style="width:70%; border-top-width:0px;">
		<div id="mainBody" align="center">
			<div align="center">
				<p><img src="_images/logo.jpg" alt="Freelance Punch Card Logo" width="445" height="95" /></p>
				<hr />
				<div style="float:left; width:25%; height:100px; padding-top:23px; ">
				
				<div style="border:dotted thin #000000; margin-right:10px; background-color:#FFFFFF;"><span class="style7">Menu
				  </span></div>
				  <div style="background-image:url(_images/navbg.jpg); background-repeat:repeat-x; height:100px; padding:5px; margin-right:10px; border:dotted thin #000000; ">
						<span style="color: #669900"><a href="newProject.php" class="style5" style="text-decoration:none;">Create Project</a><br />
						<a href="addClient.php" class="style5" style="text-decoration:none;">Add Client</a><br />
						</span><a href="settings.php" class="style5" style="text-decoration:none;;">Settings</a><br />
				  </div>
			  </div>
				
				<div style="width:75%; float:left; clear:right;" >
				
				  <div style="padding:5px;">
					  <p style="text-align:justify">
						Welcome to the Freelance Punch Card time management and tracking software. I designed this software with freelance software developers in mind. The software is open ended and can be customized easily. On your left you will see the main navigation, which includes:
					  <div style="text-align:left;">
					<ul>
						  <li><em><strong>Create Project</strong></em>: every time you take on a new project, you need to add the project to this system. First you need to add the client for a particular project, then create a project. 
						  
						  <li><em><strong>Settings</strong></em>: lists various settings used across the application. You can easily add your own settings for new custom features. </li>
						  <li><em><strong>Add Client</strong></em>: if you plan on doing work for a client, you need to add them to the system. This menu asks only for their name and email address by default, but more attributes for a particular client may be added.</li>
					</ul> 
					</div>
						</p>
					  <span style="font-size:25px;"><strong><i>Projects in progress </i></strong></span>
						<hr />
					    <div id="timeSheets" style="text-align:left;">
							<?php
								if(strlen($htmlProjects) != 0)
								{
									echo($htmlProjects);
								}
								else
								{
					
									echo("<center><h3>No current projects</h3></center>");
								}
							?>
							<hr />
						</div>
				  </div>
				</div>
				<p>&nbsp;</p>
				
			</div>
<center>
		<hr />
		Presented by: Andrew Ribeiro
	| AndrewRibeiro.com 
</center>
		</div>
		
	</div>
	
	
</center>

</body>
</html>
