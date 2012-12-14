<?php

/*
	Represents Slideshow
*/
class Slideshow
{
	private $id;
	private $title;
	private $url;
	private $thumbnailUrl;
	private $username;
	private $userProfileLink;
	private $createdDate;
	private $numDownloads;
	private $numViews;
	private $numComments;
	private $numFavorites;
	private $numSlides;
	private $relatedSlideshowIds = array();

	function __construct($slideshowXMLObject)
	{
		$this->id 			= $slideshowXMLObject->ID;
		$this->title 		= $slideshowXMLObject->Title;
		$this->url 			= $slideshowXMLObject->URL;
		$this->thumbnailUrl = $slideshowXMLObject->ThumbnailURL;
		$this->username 	= $slideshowXMLObject->Username;
		$this->userProfileLink  = "http://www.slideshare.com/". $this->username;

		//These are actually of the form
		//SimpleXMLElement Object ( [0] => 33 )
		$this->createdDate  = $slideshowXMLObject->Created;
		$this->numDownloads = (double) $slideshowXMLObject->NumDownloads;
		$this->numViews		= (double) $slideshowXMLObject->NumViews;
		$this->numComments  = (double) $slideshowXMLObject->NumComments;
		$this->numFavorites = (double) $slideshowXMLObject->NumFavorites;
		$this->numSlides    = (double) $slideshowXMLObject->NumSlides;
		
		

		//Get Related
		foreach($slideshowXMLObject->RelatedSlideshows[0] as $id)
			#http://stackoverflow.com/questions/2867575/get-value-from-simplexmlelement-object
			array_push($this->relatedSlideshowIds, (string)$id);

		//Format
		$this->format();
	}

	//Date
	private function format()
	{
		$this->createdDate = date('M j, Y', strtotime($this->createdDate));
	}

	public function title() {
		return $this->title;
	}
	public function url() {
		return $this->url;
	}
	public function thumbnailUrl() {
		return $this->thumbnailUrl;
	}
	public function username() {
		return $this->username;
	}
	public function userProfileLink() {
		return $this->userProfileLink;
	}
	public function createdDate() {
		return $this->createdDate;
	}
	public function numViews() {
		return $this->numViews;
	}
	public function numFavorites() {
		return $this->numFavorites;
	}
	public function numComments() {
		return $this->numComments;
	}
	public function relatedSlideshowIds() {
		return $this->relatedSlideshowIds;
	}
	
}