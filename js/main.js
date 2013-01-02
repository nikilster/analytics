//Main JS File
$(document).ready(function(){
	
	//Make sure we load the default profile picture if the user doesn't have a valid profile picture
	getCorrectProfilePicture();

	//Form Submission
	$("#userForm").submit(goToUser)
});


/*
	Get Correct Profile Picture
 	
 	Load the correct profile picture
 		User has profile picture - we have loaded it in html
 		If the user DOES NOT have a profile picture we load in the default user picture
 		
 		We detect this	by creating / loading a new image (with the same url as picture )
 		 and then checking to see if that image loaded properly.

 		 If we see that it didn't, we load a new picture
*/
function getCorrectProfilePicture()
{
	$("<img/>")
    .error(loadDefaultPicture)
    .attr("src", $("#profilePicture").attr("src"));
}


/*
	Load default
*/
function loadDefaultPicture()
{
	var DEFAULT_PICTURE_URL = "http://public.slidesharecdn.com/images/user-96x96.png";
	$("#profilePicture").attr("src", DEFAULT_PICTURE_URL);
}

/*
	User Page
*/
function goToUser()
{
	var username = $("#usernameField").val();

	//Handle better
	if(username != "")
	{
		var newUrl = "user.php?u=" +username;
		window.location.href = newUrl; 
	}

	//Cancel submission
	return false;
}