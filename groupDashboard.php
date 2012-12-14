<?php

 include_once('classes/Helper.php');
 include_once('classes/Group.php');

 $GROUP_KEY = 'g';

 if(!Helper::checkQueryParameter($GROUP_KEY))
 {
 	echo "Please enter a valid group id!";
 	exit();
 }


 $groupId = Helper::getQueryParameter($GROUP_KEY);
 $groupData = new Group($groupId);

?>