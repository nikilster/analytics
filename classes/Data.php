<?php

include_once('apiConstants.php');
include_once('Slideshow.php');
include_once('Helper.php');

/*
	Manages Data
*/

class Data
{
	//Toggle whether we show related people or not
	private $SHOW_RELATED_USERS = false;

	private $GET_SLIDESHOW_BY_USER_BASE_URL = "http://www.slideshare.net/api/2/get_slideshows_by_user?";
	private $GET_SLIDESHOW_BY_ID_BASE_URL = "http://www.slideshare.net/api/2/get_slideshow?";
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
	//Usernames
	private $relatedUsers = array();

	/*
		Constructor takes in the username 
		of a person we want to show analtyics data for
	*/
	function __construct($username)
	{
		//Get the data
		$this->username = $username;
		$this->data = $this->getSlideshowForUser($username);
		$this->analyzeData();
	}


	/*
		Wrapper for getting the slideshow for the user (wrapper for get Data) 
	*/
	private function getSlideshowForUser($username)
	{
		$queryString = array('username_for' => $username);
		return $this->getData($this->GET_SLIDESHOW_BY_USER_BASE_URL, $queryString, 1);
	}

	/*
		Id -> Slideshow
	*/
	private function getSlideshowById($slideshowId)
	{
		$queryString = array('slideshow_id' => $slideshowId);
		return $this->getData($this->GET_SLIDESHOW_BY_ID_BASE_URL, $queryString, 1);
	}

	/*
		Make a get request to get the slideshow data for a given user
	*/
	private function getData($baseUrl, $specificParameter, $detailed)
	{

		//Needed for request
		$timestamp = time();
		$hash = sha1(ApiConstants::$API_SECRET . $timestamp);
		$detailed = 1;

		//Request Parameters
		$genericParameters = array('api_key' 		=> ApiConstants::$API_KEY,
								   'ts'	  			=> $timestamp,
								   'hash'    		=> $hash,
								   'detailed'       => $detailed);

		//Add the specific parameter
		$queryParameters = array_merge($genericParameters, $specificParameter);

		//Query Parameters in String
		$queryString = http_build_query($queryParameters);

		//Request String
		$request = $baseUrl . $queryString; 

		//Get data
		return file_get_contents($request);
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
		//Helper::sortSlideshows($this->slideshows);
		usort($this->slideshows, array(Helper, 'slideshowViewCountCmp'));

		//Related Users
		if($SHOW_RELATED_USERS) $this->getRelatedUsers();

		//Count Stuff
		$this->aggregateStatistics();
	}

	/*
		Get Related Users
	*/
	private function getRelatedUsers()
	{
		//Todo add for loop to get all of the related users
		if(count($this->slideshows) == 0) return;

		//Get Related Slideshow Ids
		$relatedSlideshowIds = array(); 
		foreach($this->slideshows as $slideshow)
			$relatedSlideshowIds = array_merge($relatedSlideshowIds, $slideshow->relatedSlideshowIds());
		
		//Get the usernames for each slideshow
		$NUM_RELATED_USERS_TO_SHOW = 5;

		//Min of the number we want and how many we have (should always have at least 10)
		//Each slideshow comes with 10 related ids
		$NUM_SLIDESHOW_IDS = min($NUM_RELATED_USERS_TO_SHOW, count($relatedSlideshowIds));
		for($i = 0; $i < $NUM_SLIDESHOW_IDS; $i++)
			array_push($this->relatedUsers, $this->getUsernameForSlideshowId($relatedSlideshowIds[$i]));
		
	}

	/*
		Get the username of the creator of the slideshow (with the given id)
	*/
	private function getUsernameForSlideshowId($slideshowId)
	{
		//Make api call and get the slideshow
		$slideshowXMLString = $this->getSlideshowById($slideshowId);
		$xml = simplexml_load_string($slideshowXMLString);

		//Get the username
		$username = (string)$xml->Username;

		return $username;
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
	}

	private function debugViewCount()
	{
		foreach($this->slideshows as $slideshow)
			echo "-".$slideshow->numViews()."-";
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