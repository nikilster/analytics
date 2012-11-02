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
	private $userName;
	private $numSlideshows;
	private $slideshows = array(); 
	private $totalViewCount;

	/*
		Constructor takes in the username 
		of a person we want to show analtyics data for
	*/
	function __construct($username)
	{
		//Get the data
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
		$this->userName = $xml->Name;
		$this->numSlideshows = $xml->Count;

		//Get Slideshows, create objects, add
		foreach($xml->xpath('Slideshow') as $slideshowXML)
			array_push($this->slideshows, new Slideshow($slideshowXML));		

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
		foreach($this->slideshows as $slideshow)
			$this->totalViewCount += $slideshow->numViews();	
	}

	/*
		Getter Methods
	*/
	public function name()
	{
		return $this->userName;
	}

	public function totalViewCount()
	{
		return $this->totalViewCount;	
	}

	public function slideshows()
	{
		return $this->slideshows;
	}
}

?>