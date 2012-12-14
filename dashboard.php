<?php

 include_once('classes/Helper.php');
 include_once('classes/Data.php');

 $USERNAME_KEY = 'u';

 if(!Helper::checkQueryParameter($USERNAME_KEY))
 {
 	echo "Please enter a valid user id!";
 	exit();
 }

 $username = Helper::getQueryParameter($USERNAME_KEY);
 $userData = new Data($username);


 //Debug
 if($DEBUG)
 {
	 echo "User Name: " . $userData->name();
	 echo "<br/>";
	 echo "Number of Slideshows: " . count($userData->slideshows());
	 echo "<br/>";
	 echo "Total View Count: " . $userData->totalViewCount();
	 echo "<br/>";
	 echo "Slideshows: <br/>";
	 foreach($userData->slideshows() as $slideshow)
	 	echo "&nbsp &nbsp" . $slideshow->title() . " (". $slideshow->numViews() . " views) <br/>";
 }
?>