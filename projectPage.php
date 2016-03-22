<?php 

require_once("constants.php");

$mysqli = new mysqli(SERVER_ADDRESS, USER_NAME, PASSWORD, DATABASE);

$project_id = addslashes($_POST["project_id"]); 

if(strlen($project_id) <= 0)
{
	header("Location:index.php");
	die(0);
}

// Setup the code for the charges. 
$sql = 'SELECT `charge_id`,`charge_name`,`amount`,`date`,`paid`
		FROM `charge`
		WHERE `project_id` = '.$project_id.'
		ORDER BY `paid` ASC, `date` DESC
		
LIMIT 0,10';
		
$htmlCharges = ""; 

$result = $mysqli->query( $sql );

while( $row = $result->fetch_assoc() )
{
	$action = "setPaid";
	$actionLabel = "Mark as paid";
	$paidHTML = "<span id='paidLabel_".$row["charge_id"]."' style=\"color:#FF0000\"> No </span>";
	
	if($row['paid'])
	{
		$action = "setUnpaid";
		$actionLabel = "Unmark as paid";
		$paidHTML = "<span id='paidLabel_".$row["charge_id"]."' style=\"color:#00FF00\"> Yes </span>";
	}
	
	$htmlCharges  .= '<div class="elementPanelGroup">
						<div class="elementPanel">
							<div class="chargeName">'.$row["charge_name"].'</div>
							<div class="amount">| $'.$row["amount"].'</div>
							<div class="date">| '.$row["date"].'</div>
							<div class="paid">| '.$paidHTML.' | </div>
							<div class="actions">
								<button>Edit</button>
								<button id="chargeActionButton_'.$row["charge_id"].'"onclick="setChargePayStatus('.$row["charge_id"].', \''.$action.'\' )">
									'.$actionLabel.'
								</button>
							</div>
							&nbsp;
						</div>
					</div>';
}

// Setup the code for the billing cycles. 

$sql = 'SELECT  billingcycle.`cycle_id`, billingcycle.startdate, endDates.enddate, billingcycle.`paid`
FROM `billingcycle`, 
( SELECT `cycle_id`, DATE_ADD(`startdate`, INTERVAL `weeklength` WEEK)enddate FROM `billingcycle`)endDates
WHERE billingcycle.`cycle_id` = endDates.`cycle_id` AND billingcycle.`project_id` = '.$project_id.'
ORDER BY `paid` ASC, `startdate` DESC
LIMIT 0,10
';
		
$htmlPayCycles = ""; 

$result = $mysqli->query( $sql );

while( $row = $result->fetch_assoc() )
{
	$sql = 'SELECT COUNT(`cycle_id`)count
			FROM `timesheet` 
			WHERE `cycle_id` = '.$row["cycle_id"];
			
	$secondResult = $mysqli->query( $sql );
	
	$secondRow = $secondResult->fetch_assoc();
	
	
	$action = "setPaid";
	$actionLabel = "Mark as paid";
	$paidHTML = "<span id='cyclePaidLabel_".$row["cycle_id"]."' style=\"color:#FF0000\"> No </span>";
	
	if($row['paid'])
	{
		$action = "setUnpaid";
		$actionLabel = "Mark as unpaid";
		$paidHTML = "<span id='cyclePaidLabel_".$row["cycle_id"]."' style=\"color:#00FF00\"> Yes </span>";
	}
	
	$htmlPayCycles  .= '<div class="elementPanelGroup">
						<div class="elementPanel">
							<div class="startDate">'.$row["startdate"].'</div>
							<div class="endDate">| '.$row["enddate"].'</div>
							<div class="timeSheets">| Timesheets( '.$secondRow["count"].' )</div>
							<div class="paid">| '.$paidHTML.' | </div>
							<div class="actions">
								<button>Edit</button>
								<button id="cycleActionButton_'.$row["cycle_id"].'" id="chargeActionButton_'.$row["charge_id"].'"onclick="setCyclePayStatus('.$row["cycle_id"].', \''.$action.'\' )">
									Mark as paid
								</button>
							</div>
							&nbsp;
						</div>
					</div>';
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Project Page | Freelance Punch Card | Presented by: Andrew Ribeiro</title>

<!-- BEGIN Includes !-->
<script language="javascript" type="text/javascript" src="scripts/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="scripts/projectPage.js"></script>

<link rel="icon" type="image/png" href="_images/fav.png">
<link href="styles/styles.css" rel="stylesheet" type="text/css" />
<link href="styles/projectPage.css" rel="stylesheet" type="text/css" />
<!-- END Includes !-->

<style type="text/css">
<!--
.style9 {color: #FF0000}
-->
</style>
</head>

<body>
<input type="hidden" id="projectID" value="<?php echo($project_id); ?>" />

<!-- BEGIN Popup Boxes !-->

<div id="createCharge">
	<div style="background-color:#FFFFFF; border:medium inset #999999; height:300px; width:600px; margin:0 auto; padding:10px;">
		<div class="settingPopup">
			<div style="padding-bottom:10px;">Create Charge</div>
			<div onclick="hidePopup('createCharge')" style="float:right; position:relative; top:-35px; color:#FF0000; cursor:pointer">( X )</div>
		</div>
		<div style="background-color:#CCCCCC; height:88%; width:100%; margin:0 auto; overflow:auto; position:relative; top:-18px;">
			<div style="padding:5px; ">
				<table width="100%" border="0">
				  <tr>
				    <td width="54%" rowspan="8" valign="top">
						<div style="width:90%; height:100%; padding-right:10px; border-right:thin dotted #000000; text-align:left; ">
						  <p>Welcome to the charge creation window. This window allows you to add additional charges to a project. Charges are useful for adding on additional flat rate project costs. Below are explanations of each of the fields for a charge:</p>
						  <ul>
						    <li><em><strong>Charge Name</strong></em>: identifier for the charge. </li>
					        <li><strong><em>Date Issued</em></strong>: the date you want to list the charge for. The format is <span class="style9">Year-Month-Day</span>. This date should coincide with when you told the client you where adding an extra charge. </li>
						    <li><strong><em>Billing Cycle</em></strong>: if you want to group this charge with a billing cycle, select which billing cycle to include this charge. </li>
						    <li><strong><em>Amount</em></strong>: the cost of the charge. In the form dolars.cents (i.e. 4.56).</li>
						    <li><em><strong>Charge Paid</strong></em>: if you are just adding this charge for record keeping and have already received funds for the charge, choose yes; else wise, chose no. </li>
						    <li><strong><em>Notes</em></strong>: this field enables you to describe what the charge is for</li>
						  </ul>
						</div>					</td>
					<td width="17%"><label>
					  <div align="left">Charge Name: </div>
					</label></td>
					<td width="28%"><div align="left">
					  <input id="chargeName" name="name" type="text" />
				    </div></td>
					<td width="1%">&nbsp;</td>
				  </tr>
				  <tr>
				    <td><label>
					<div align="left">Date issued: </div>
					</label></td>
					<td><div align="left">
					  <input id="chargeDateIssued" name="" type="text" />
					  </div></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><label>
					<div align="left">Billing cycle: </div>
					</label></td>
					<td>
						<div align="left">
						  <select id="chargeBillingCycle" name="">
						    <option value="0">Independent charge</option>
					      </select>
				        </div></td>
					<td>&nbsp;</td>
				  </tr>
				  
				  <tr>
				    <td><label>
					<div align="left">Amount($): </div>
					</label></td>
					<td><div align="left">
					  <input id="chargeAmount" name="" type="text" />
					  </div></td>
					<td>&nbsp;</td>
				  </tr>
				  
				  <tr>
				    <td><label>
					<div align="left">Charge paid: </div>
					</label></td>
					<td><div align="left">
					    <select id="chargePaid" name="">
						    <option value="0">No</option>
							<option value="1">Yes</option>
				      </select>
					  </div></td>
					<td>&nbsp;</td>
				  </tr>
				  
				  <tr>
				    <td><label>
					<div align="left">Notes: </div>
					</label></td>
					<td><div align="left">
					  <textarea id="chargeNotes" name="textarea" style="height:50px;"></textarea>
					   
					  </div></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td colspan="2"><div align="center" style="margin-top:10px;">
				      <input onclick="createCharge('createCharge', 'chargeName', 'chargeDateIssued', 'chargeBillingCycle', 'chargeAmount', 'chargePaid', 'chargeNotes','projectID','chargesHTML')" type="button" name="Button" value="Create Charge" />
			        </div></td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="2">&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
			  </table>

			</div>
		</div>
	</div>
</div>


<div id="createCycle">
	<div style="background-color:#FFFFFF; border:medium inset #999999; height:300px; width:600px; margin:0 auto; padding:10px;">
		<div class="settingPopup">
			<div style="padding-bottom:10px;">Create Billing Cycle </div>
			<div onclick="hidePopup('createCycle')" style="float:right; position:relative; top:-35px; color:#FF0000; cursor:pointer">( X )</div>
		</div>
		<div style="background-color:#CCCCCC; height:88%; width:100%; margin:0 auto; overflow:auto; position:relative; top:-18px;">
			<div style="padding:5px; ">
				<table width="100%" border="0">
				        <tr>
				          <td width="54%" rowspan="6" valign="top">
				            <div style="width:90%; height:100%; padding-right:10px; border-right:thin dotted #000000; text-align:left; ">
				              <p>Welcome to the billing cycle creation window. This window enables you to create a billing cycle. A billing cycle allows you to group multiple time sheets and charges. </p>
						    <ul>
						      <li><em><strong>Start Date </strong></em>: the date that the billing cycle starts. The format for this field is <span class="style9">yyyy-mm-dd</span>. </li>
					          <li><em><strong>Length</strong></em>: the length of the billing cycle in weeks. </li>
						      <li><strong><em>Paid</em></strong>: if the billing cycle has been paid in full by your client. </li>
					        </ul>
						  </div>					</td>
				          <td height="65">&nbsp;</td>
				          <td>&nbsp;</td>
				          <td>&nbsp;</td>
		          </tr>
		          <tr>
				    <td width="17%"><label>
					  <div align="left">Start Date: </div>
					</label></td>
					<td width="28%"><div align="left">
					  <input id="cycleStartDate" name="name" type="text" />
				    </div></td>
					<td width="1%">&nbsp;</td>
				  </tr>
				  <tr>
				    <td><label>
					<div align="left">Length:</div>
					</label></td>
					<td><div align="left">
					  <input id="cycleLength" name="" type="text" />
					  </div></td>
					<td>&nbsp;</td>
				  </tr>
				  
				  

				  <tr>
				    <td><label>
					<div align="left">Paid: </div>
					</label></td>
					<td><div align="left">
					    <select id="cyclePaid" name="">
						    <option selected="selected" value="0">No</option>
							<option value="1">Yes</option>
				      </select>
					  </div></td>
					<td>&nbsp;</td>
				  </tr>
				  
				  <tr>
				    <td colspan="2"><div align="center" style="margin-top:10px;">
				      <input onclick="createCycle('createCycle', 'cycleStartDate', 'cycleLength', 'cyclePaid', 'projectID','cylclesHTML')" type="button" name="Button" value="Create Charge" />
			        </div></td>
				    <td>&nbsp;</td>
			      </tr>
				  <tr>
				    <td colspan="2">&nbsp;</td>
				    <td>&nbsp;</td>
			      </tr>
			  </table>
			</div>
		</div>
	</div>
</div>

<!-- END popup boxes !-->

<center>
	<div style="width:70%; border-top-width:0px;">
		<div id="mainBody" align="center">
			<div align="center">
				<p><a href="index.php"><img src="_images/logo.jpg" alt="Freelance Punch Card Logo" width="445" height="95" border="0" /></a></p>
				<hr />
				<div style="float:left; width:25%; height:100px; padding-top:23px; ">
				
				<div style="border:dotted thin #000000; margin-right:10px; background-color:#FFFFFF;"><span class="style7">Menu
				  </span></div>
				  <div style="background-image:url(_images/navbg.jpg); background-repeat:repeat-x; height:100px; padding:5px; margin-right:10px; border:dotted thin #000000; ">
						<span onclick="showPopup('createCycle')"  class="style5">New Billing Cycle </span><br />
						<span onclick="showPopup('createCharge')" class="style5">Add Charge</span><br />
					</span><a href="settings.php" class="style5" style="text-decoration:none;;">Project Settings</a><br />
				  </div>
			  </div>
				
				<div style="width:75%; float:left; clear:right;" >
				
				  <div style="padding:5px;">
					  <p style="text-align:justify">
						Welcome to the project page. Bellow you will see three sections: Basic Project Information, Billing Cycles, and Charges. This page allows you to do anything in respect to a project, these things include:                                             
					  <div style="margin-top:-10px;">
					    <ul>
					      <li>
					        <div align="left"><em><strong>Create Billing Cycles</strong></em>: billing cycles are periods of time in which you have done work. Billing cycles consist of multiple time sheets. Click the <em>New Billing Cycle</em> button on the menu box to the left. </div>
					      </li>
						  <li>
						   <div align="left"><em><strong>Add Project Charges</strong></em>: project charges are special fees that are applied to a project. Charges can be grouped with billing cycles to enable simple billing. </div>
						  </li>
				          <li>
				            <div align="left"><em><strong>Project Information</strong></em>: this page allows you to add notes on a project and modify project settings-- such as client. </div>
				          </li>
					    </ul>
				      </div>
				  </div>
				
				<div>
					<div>
					<em><strong><span class="style8">Billing Cycles </span></strong></em>
					<img " src="_images/questionMark.jpg" alt="About Pay Periods" width="17" height="23" /></div>
					<div class="seeAllLink">See All ></div>
					<div style="clear:both;">
					  <hr />
					  <div id="cylclesHTML">
							<!-- Pay Cylce code here !-->
							<?php
							
								if(strlen($htmlPayCycles) > 0)
								{
									echo($htmlPayCycles);
								}
								else
								{
									// No charges.
									echo("<center><h3><em><span id='noBillingCycles'>No billing cylces</span></em></h3></center>");
								}
								
							
							?>
					  </div>
					<hr />
				  </div>
				</div>
				
				<div style="margin-bottom:2em; margin-top:2em;">
				
					<div><em><strong><span class="style8">Charges </span></strong></em><img " src="_images/questionMark.jpg" alt="About Pay Periods" width="17" height="23" /></div>
					
					<div class="seeAllLink">See All ></div>
					
					<div style="clear:both;">
						<hr />
							<div id="chargesHTML">
								<!-- List all charges here !-->
								<?php
									
									if(strlen($htmlCharges) > 0)
									{
										echo($htmlCharges);
									}
									else
									{
										// No charges.
										echo("<center><h3><em><span id='noCharges'>No charges</span></em></h3></center>");
									}
									
								?>
				
							</div>
						<hr />
					</div>
				</div>
				
			  </div>
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
