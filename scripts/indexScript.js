// indexScript.js
// Contains functions for use with index.php

var totalTimeSheets;

$(document).ready(function()
{	   
totalTimeSheets = $("#timeSheets").children().length - 1;
});

function markAsComplete(projectID, projectDIV)
{
	$(projectDIV).fadeOut("slow");
	
	totalTimeSheets--;
	
	if(!totalTimeSheets)
	{
		 $("#timeSheets").html("<center><h3>No current projects</h3></center><hr />");
	}
	
	var  garbage = $.ajax({
	   type: "POST",
	   url: "actions/do.markProjectComplete.php",
	   data: "project_id="+projectID,
	   success: function(msg){
		   
	   }
	 });
}