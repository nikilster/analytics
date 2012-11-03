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
	private $createdDate;
	private $numDownloads;
	private $numViews;
	private $numComments;
	private $numFavorites;
	private $numSlides;

	function __construct($slideshowXMLObject)
	{
		$this->id 			= $slideshowXMLObject->ID;
		$this->title 		= $slideshowXMLObject->Title;
		$this->url 			= $slideshowXMLObject->URL;
		$this->thumbnailUrl = $slideshowXMLObject->ThumbnailURL;
		//These are actually of the form
		//SimpleXMLElement Object ( [0] => 33 )
		$this->createdDate  = $slideshowXMLObject->Created;
		$this->numDownloads = (double) $slideshowXMLObject->NumDownloads;
		$this->numViews		= (double) $slideshowXMLObject->NumViews;
		$this->numComments  = (double) $slideshowXMLObject->NumComments;
		$this->numFavorites = (double) $slideshowXMLObject->NumFavorites;
		$this->numSlides    = (double) $slideshowXMLObject->NumSlides;

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
	
}