<?php

 include_once('Data.php');
 
 $USERNAME_KEY = 'u';

 //check
 if(!array_key_exists($USERNAME_KEY,$_GET) || $_GET[$USERNAME_KEY] === "")
 {
 	echo "Please enter a user to show statistics!";
 	exit();
 }

 $username = $_GET[$USERNAME_KEY];
 $userData = new Data($username);

 echo "User Name: " . $userData->name();
 echo "<br/>";
 echo "Number of Slideshows: " . count($userData->slideshows());
 echo "<br/>";
 echo "Total View Count: " . $userData->totalViewCount();
 echo "<br/>";
 echo "Slideshows: <br/>";
 foreach($userData->slideshows() as $slideshow)
 	echo "&nbsp &nbsp" . $slideshow->title() . " (". $slideshow->numViews() . " views) <br/>";
?>