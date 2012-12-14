<?

/*
	Group of People
*/

include_once('apiConstants.php');
include_once('Slideshow.php');
include_once("Data.php");

class Group
{
	private $FOLDER = "group";

	//Public (By Getters and Setters) Fields
	private $groupName; //Currently the filename also
	private $users;
	private $usernames;
	private $groupPicture;

	private $presentationCount;
	private $slideshows = array();
	private $totalViewCount;
	private $totalCommentCount;
	private $averageViewCount;

	/*
		Constructor - takes filename
	*/
	function __construct($groupName)
	{
		/*
			Load + Analyize
		*/
		$this->groupName = $groupName;
		$this->getUsers();
		$this->getData();
		$this->analyzeData();
	}	


	/*
		Load the list of users from the file
	*/
	private function getUsers()
	{
		
		//Init instance variable
		$this->usernames = array();

		//Open file
		$dataArray = file($this->getAbsolutePath($this->groupName));

		//Read file
		foreach($dataArray as $username)
			array_push($this->usernames, trim($username));

	}

	/*
		Get the absolute path (Folder/filename)
	*/
	private function getAbsolutePath($filename)
	{
		return $this->FOLDER . "/" . $filename;
	}

	/*
		Load Users
	*/
	private function getData()
	{
		//Build Users
		$this->users = array();
		foreach($this->usernames as $username)
			array_push($this->users, new Data($username));
	}


	/*
		Analyze Data
	*/
	private function analyzeData()
	{
		$this->presentationCount = 0;
		//$this->$slideshows;
		$this->totalViewCount = 0;
		$this->totalCommentCount = 0;
		$this->averageViewCount = 0;

		//Compile
		foreach($this->users as $user)
		{
			$this->presentationCount += $user->presentationCount();
			$this->slideshows = array_merge($this->slideshows, $user->slideshows());
			$this->totalViewCount += $user->totalViewCount();
			$this->totalCommentCount += $user->totalNumComments();
		}

		//Chose Picture
		$this->chooseGroupPicture();

		//Sort Slideshows (according to views)
		//Helper::sortSlideshows($this->slideshows);
		usort($this->slideshows, array(Helper, 'slideshowViewCountCmp'));

		//Average View Count
		//Handle 0
		if($this->presentationCount == 0)
			$this->averageViewCount = 0;
		else
			$this->averageViewCount = $this->totalViewCount / $this->presentationCount;

		//Sort Users based on total slideshow (all slideshows) view count
		usort($this->users, array($this, 'userViewCountCmp'));

	}

	/*
		Choose the group picture
			For now select a random picture from one of the people in the group! 
	*/
	private function chooseGroupPicture()
	{
		$randomPerson = $this->users[array_rand($this->users)];
		$this->groupPicture = $randomPerson->picture();
	}

	//Sorts according to the total view count of all the slideshows for a user(in decreasing order) 
	public function userViewCountCmp($a, $b)
	{
		if($a->totalViewCount() == $b->totalViewCount()) return 0;
		if($a->totalViewCount() > $b->totalViewCount()) return -1;
		return 1;
	}

	/*
		Getter Methods
	*/
	public function users()
	{
		return $this->users;
	}
	public function name()
	{
		return $this->groupName;
	}
	public function usernames()
	{
		return $this->usernames;
	}
	public function picture()
	{
		return $this->groupPicture;
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
	public function totalCommentCount()
	{
		return $this->totalCommentCount;
	}
	public function averageViewCount()
	{
		return $this->averageViewCount;
	}
}