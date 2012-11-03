<?php

include_once('apiConstants.php');
include_once('Slideshow.php');

/*
	Manages Data
*/

class Data
{

	private $BASE_URL = "http://www.slideshare.net/api/2/get_slideshows_by_user?";
	private $data;
	
	/*
		User Info
	*/
	private $username;
	private $name;
	private $profileLink;
	private $userPicture;
	private $presentationCount;
	private $slideshows = array(); 
	private $totalViewCount;
	private $totalNumComments;
	private $averageViewCount;

	/*
		Constructor takes in the username 
		of a person we want to show analtyics data for
	*/
	function __construct($username)
	{
		//Get the data
		$this->username = $username;
		$this->getData($username);
		$this->analyzeData();
	}

	/*
		Make a get request to get the slideshow data for a given user
	*/
	private function getData($username)
	{

		//Needed for request
		$timestamp = time();
		$hash = sha1(ApiConstants::$API_SECRET . $timestamp);
		$detailed = 1;

		//Request Parameters
		$queryParameters = array('api_key' 		=> ApiConstants::$API_KEY,
								 'ts'	  		=> $timestamp,
								 'hash'    		=> $hash,
								 'username_for' => $username,
								 'detailed'     => $detailed);

		//Query Parameters in String
		$queryString = http_build_query($queryParameters);

		//Request String
		$request = $this->BASE_URL . $queryString; 

		//Get data
		$this->data = file_get_contents($request);
	}

	/*
		Analyze Input
	*/
	private function analyzeData()
	{
		$xml = simplexml_load_string($this->data);

		//Parse the document according to the analyzed structure
		$this->name = $xml->Name;

		//Profile page
		$this->profileLink ="http://www.slideshare.com/". $this->username;

		//User profile picture
		$this->userPicture = "http://cdn.slidesharecdn.com/profile-photo-".$this->username."-96x96.jpg";

		//Number of Presentations
		$this->presentationCount = (double) $xml->Count;

		//Get Slideshows, create objects, add
		foreach($xml->xpath('Slideshow') as $slideshowXML)
			array_push($this->slideshows, new Slideshow($slideshowXML));		

		//Sort Slideshows (according to views)
		usort($this->slideshows, array($this, 'slideshowViewCountCmp'));
		
		//Count Stuff
		$this->aggregateStatistics();
	}

	/*
		Count Statistics
	*/
	private function aggregateStatistics()
	{
		//Total Number of Views
		$this->totalViewCount = 0;

		//Total Number of Comments
		$this->totalNumComments = 0;

		//Count
		foreach($this->slideshows as $slideshow)
		{
			$this->totalViewCount += $slideshow->numViews();	
			$this->totalNumComments += $slideshow->numComments();
		}

		//Average
		if($this->presentationCount == 0)
			$this->averageViewCount = 0;
		else
			$this->averageViewCount = $this->totalViewCount / $this->presentationCount;

		//Number Format
		$this->presentationCount = $this->formatNumber($this->presentationCount);
		$this->totalViewCount = $this->formatNumber($this->totalViewCount);
		$this->totalNumComments = $this->formatNumber($this->totalNumComments);
		$this->averageViewCount = $this->formatNumber($this->averageViewCount);
	}

	//Sorts according to the view count of the slideshow (in decreasing order) 
	private function slideshowViewCountCmp($a, $b)
	{
		if($a->numViews() == $b->numViews()) return 0;
		if($a->numViews() > $b->numViews()) return -1;
		return 1;
	}

	private function debugViewCount()
	{
		foreach($this->slideshows as $slideshow)
			echo "-".$slideshow->numViews()."-";
	}

	//formats all numbers to have commas every 3 digits
	private function formatNumber($number)
	{
		$NUM_DECIMAL_PLACES = 2;
		return number_format($number);
	}
	/*
		Getter Methods
	*/
	public function name()
	{
		return $this->name;
	}
	public function profileLink()
	{
		return $this->profileLink;
	}
	public function picture()
	{
		return $this->userPicture;
	}
	public function presentationCount()
	{
		return $this->presentationCount;
	}
	public function slideshows()
	{
		return $this->slideshows;
	}
	public function totalViewCount()
	{
		return $this->totalViewCount;	
	}
	public function totalNumComments()
	{
		return $this->totalNumComments;
	}
	public function averageViewCount()
	{
		return $this->averageViewCount;
	}
}

?>