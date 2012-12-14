<?php
	
class Helper
{
	 //Check for key
	 public static function checkQueryParameter($KEY)
	 {
	 	if(!array_key_exists($KEY,$_GET) || $_GET[$KEY] === "")
	 		return false;

	 	return true;
	 }

	 //Get Key
	 public static function getQueryParameter($KEY)
	 {
	 	return $_GET[$KEY];
	 }

	 //Format Number
	 public static function formatNumber($number)
	 {
	 	return number_format($number);
	 }

	/*
		FIGURE OUT!
	*//*
	public static function sortSlideshows($slideshows)
	{
		if(usort($slideshows, array(Helper, 'slideshowViewCountCmp')))
			echo "GOOD SORT!";
		else 
			echo "BAD SORT!";
	}*/
		
	//Sorts according to the view count of the slideshow (in decreasing order) 
	public static function slideshowViewCountCmp($a, $b)
	{
		if($a->numViews() == $b->numViews()) return 0;
		if($a->numViews() > $b->numViews()) return -1;
		return 1;
	}
}
?>