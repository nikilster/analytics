<?php

/*
	Represents Slideshow
*/
class Slideshow
{
	private $id;
	private $title;
	private $url;
	private $thumbnailURL;
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
		$this->thumbnailURL = $slideshowXMLObject->ThumbnailURL;
		$this->numDownloads = $slideshowXMLObject->NumDownloads;
		$this->numViews		= $slideshowXMLObject->NumViews;
		$this->numComments  = $slideshowXMLObject->NumComments;
		$this->numFavorites = $slideshowXMLObject->NumFavorites;
		$this->numSlides    = $slideshowXMLObject->NumSlides;
	}

	public function title() {
		return $this->title;
	}
	public function numViews() {
		return $this->numViews;
	}
}