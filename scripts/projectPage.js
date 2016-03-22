// JavaScript Document
function showPopup(id)
{
	document.getElementById(id).style.visibility = "visible";
}

function hidePopup(id)
{
	document.getElementById(id).style.visibility = "hidden";
}

function getElement(id)
{
	return document.getElementById(id);
}

function setCyclePayStatus( cycleID, action)
{
	var prefixForButton = "cycleActionButton_";
	var prefixForLabel = "cyclePaidLabel_";
	
	if(action == "setPaid" || action == "setUnpaid")
	{
		 var garbage = $.ajax({
	   type: "POST",
	   url: "actions/do.setBillingCyclePayment.php",
	   data: "cycle_id="+ cycleID +"&action="+ action,
	   success: function(msg){
	 	
			if(msg.length > 0)
			{
				alert(msg);
			}
			else
			{
				if(action == "setPaid")
				{
					// Set color to green. 
					document.getElementById(prefixForLabel+cycleID).style.color = "#00FF00";
					document.getElementById(prefixForLabel+cycleID).innerHTML = "Yes";
					document.getElementById(prefixForButton+cycleID).innerHTML = "Unmark as paid";
					document.getElementById(prefixForButton+cycleID).setAttribute('onclick',"setCyclePayStatus("+cycleID+",'setUnpaid')");
				}
				else 
				{
					// Set color to red. Unpaid.
					document.getElementById(prefixForLabel +cycleID).style.color = "#FF0000";
					document.getElementById(prefixForLabel +cycleID).innerHTML = "No";
					document.getElementById(prefixForButton+cycleID).innerHTML = "Mark as paid";
					document.getElementById(prefixForButton+cycleID).setAttribute('onclick',"setCyclePayStatus("+cycleID+",'setPaid')");
				
				}
			}
			
		}});
		
	}
	else
	{
		alert("Invalid call to 'setCyclePayStatus' function");
	}
}

function setChargePayStatus(chargeID, action)
{
	var prefixForButton = "chargeActionButton_";
	var prefixForLabel = "paidLabel_";
	
	if(action == "setPaid" || action == "setUnpaid")
	{
		 var garbage = $.ajax({
	   type: "POST",
	   url: "actions/do.setChargePayment.php",
	   data: "charge_id="+ chargeID +"&action="+ action,
	   success: function(msg){
	 	
			if(msg.length > 0)
			{
				alert(msg);
			}
			
			if(action == "setPaid")
			{
				// Set color to green. 
				document.getElementById(prefixForLabel+chargeID).style.color = "#00FF00";
				document.getElementById(prefixForLabel+chargeID).innerHTML = "Yes";
				document.getElementById(prefixForButton+chargeID).innerHTML = "Unmark as paid";
				document.getElementById(prefixForButton+chargeID).setAttribute('onclick',"setChargePayStatus("+chargeID+",'setUnpaid')");
			}
			else 
			{
				// Set color to red. Unpaid.
				document.getElementById(prefixForLabel +chargeID).style.color = "#FF0000";
				document.getElementById(prefixForLabel +chargeID).innerHTML = "No";
				document.getElementById(prefixForButton+chargeID).innerHTML = "Mark as paid";
				document.getElementById(prefixForButton+chargeID).setAttribute('onclick',"setChargePayStatus("+chargeID+",'setPaid')");
			
			}
	   }});
	}
	else
	{
		alert("Invalid call to 'setChargePayStatus' function");
	}
}

function createCycle(popupID, startDateID, weekLengthID, paidID, projectID, cyclesContainerID)
{
	var startDate       = getElement( startDateID ).value; 
	var weekLength      = getElement( weekLengthID ).value;
	var paid            = getElement( paidID ).value; 
	var project         = getElement( projectID ).value;
	var cyclesContainer = getElement( cyclesContainerID );
	
	 var garbage = $.ajax({
	   type: "POST",
	   url: "actions/do.createBillingCylce.php",
	   data: "startDate="+startDate+"&weekLength="+weekLength+"&paid="+paid+"&projectID="+project,
	   success: function(msg){
	 		// Update the html and show the charge. 
			if(msg.length > 0)
			{
				// Fail
				alert(msg);
			}
			else
			{
				// Success 
				var paidCategory = "<span style=\"color:#FF0000\"> No </span>";
				
				if(paid == 1)
				{
					paidCategory = "<span style=\"color:#00FF00\"> Yes </span>";
				}
				
				hidePopup(popupID); 
				
				
				var html = '<div class="elementPanelGroup">'+
						'<div class="elementPanel">'+
							'<div class="startDate">'+ startDate +'</div>'+
							'<div class="endDate">| '+ weekLength +'</div>'+
							'<div class="timeSheets">| Timesheets( 0 )</div>'+
							'<div class="paid">| '+ paidCategory  +' | </div>'+
							'<div class="actions">'+
								'<button>Edit</button>'+
								'<button>'+
									'Mark as paid'+
								'</button>'+
							'</div>'+
							'&nbsp;'+
						'</div>'+
					'</div>';
	 
	 			// Incase this is the first charge. 
				if(getElement("noBillingCycles"))
				{
					getElement("noBillingCycles").innerHTML = "";
				}
	 			
				
				// Update the html. 
	 			cyclesContainer.innerHTML = ( html + cyclesContainer.innerHTML );
			}
			
	   }});
	
}

function createCharge(popupID , chargeNameID, chargeDateID, chargeBillingCycleID, chargeAmountID, chargePaidID, chargeNotesID,projectID, chargesContainerID)
{
	var chargeName         = getElement( chargeNameID ).value; 
	var chargeDate         = getElement( chargeDateID ).value; 
	var chargeBillingCycle = getElement( chargeBillingCycleID ).value; 
	var chargeAmount       = getElement( chargeAmountID ).value; 
	var chargePaid         = getElement( chargePaidID ).value; 
	var chargeNotes        = getElement( chargeNotesID ).value; 
	var project            = getElement( projectID ).value;
	var chargesContainer   = getElement( chargesContainerID );
	
	 var garbage = $.ajax({
	   type: "POST",
	   url: "actions/do.createCharge.php",
	   data: "name="+ chargeName +"&date="+ chargeDate +"&cycleID="+ chargeBillingCycle  +"&amount="+ chargeAmount +"&paid="+ chargePaid +"&notes="+ chargeNotes+"&projectID="+project,
	   success: function(msg){
	 		// Update the html and show the charge. 
			if(msg.length > 0)
			{
				// Fail
				alert(msg);
			}
			else
			{
				// Success 
				var paidCategory = "<span style=\"color:#FF0000\"> No </span>";
				
				if(chargePaid == 1)
				{
					paidCategory = "<span style=\"color:#00FF00\"> Yes </span>";
				}
				
				hidePopup(popupID); 
	
				var html = '<div class="elementPanelGroup">'+
						'<div class="elementPanel">'+
							'<div class="chargeName">'+ chargeName +'</div>'+
							'<div class="amount">| $'+ chargeAmount +'</div>'+
							'<div class="date">| '+ chargeDate +'</div>'+
							'<div class="paid">| '+ paidCategory +' | </div>'+
							'<div class="actions">'+
								'<button>Edit</button>'+
								'<button>'+
									'Mark as paid'+
								'</button>'+
							'</div>'+
							'&nbsp;'+
						'</div>'+
					'</div>';
	 
	 
	 			getElement("noCharges").innerHTML = "";
	 			chargesContainer.innerHTML = ( html + chargesContainer.innerHTML );
			}
			
	   }});
}