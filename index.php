<?php
  include('dashboard.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $userData->name();?>'s Analytics</title>
  
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/index.css" rel="stylesheet" media="screen">

  </head>
  <body>
 	
  <!-- GA-->
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36059984-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  </script>

 	<!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div class="container">
       
      <div class="spacer"></div>

      <div class="search">
        <form id="userForm" class="form-search">
          <input id="usernameField" class="input-medium" type="text" placeholder="slideshare username"/>
          <button class="btn" type="submit">See</button>
        </form>
      </div>

       <div class="overview">
         <div class="picture">
           <a href="<?php echo $userData->profileLink();?>" target="_BLANK" class="thumbnail">
            <img id="profilePicture" src="<?php echo $userData->picture();?>" alt="Profile Picture"/>
           </a>
         </div>

         <div class="profileInfo">
         		<h1><?php 
                //TODO: get the real name!
                echo $userData->name();
                ?></h1>
         </div>
       </div>

       <div class="statistics row-fluid">
        <div class="box well span3">
          <div class="number"><?php echo $userData->totalViewCount();?></div>
          <div class="statistic muted">Total Views</div>
        </div>
        <div class="box well span3">
          <div class="number"><?php echo $userData->presentationCount();?></div>
          <div class="statistic muted">Presentations</div>
        </div>
        <div class="box well span3">
          <div class="number"><?php echo $userData->totalNumComments();?></div>
          <div class="statistic muted">Comments</div>
        </div>
        <div class="box well span3">
          <div class="number"><?php echo $userData->averageViewCount();?></div>
          <div class="statistic muted">Average Views / Pres</div>
        </div>
       </div>

       <div class="details">
         <div class="page-header">
          <h2>Top Slideshows</h2>
         </div>

         <?php 

         //Display the presentations
         foreach($userData->slideshows() as $slideshow) {
         ?>
         

           <div class="presentation muted">

            <div class="image">
              <a class="thumbnail" target="_BLANK" href="<?php echo $slideshow->url();?>">
                <img src="<?php echo $slideshow->thumbnailUrl();?>" alt="title"/>
              </a>
            </div>

            <div class="presentationInfo">
              <div class="title"><?php echo $slideshow->title();?></div>
              <div class="date"><?php echo $slideshow->createdDate();?></div>
              <div class="views"><span class="number"><?php echo formatNumber($slideshow->numViews());?></span> Views</div>
              <div class="favorites"><span class="number"><?php echo formatNumber($slideshow->numFavorites());?></span> Favorites</div>
              <div class="comments"><span class="number"><?php echo formatNumber($slideshow->numComments());?></span> Comments</div>
            </div>

           </div>

          <?php
          } //End Foreach Loop
          ?>

       </div>

      </div>

      <div id="push"></div>
    </div>

    <!-- Footer -->
    <div id="footer">
      <div class="container">
        <p class="muted credit">Created by <a href="http://www.nikilster.com">Nikil</a> &middot; &copy; 2012</p>
      </div>
    </div>
  	  
    <!-- jquery -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>

  </body>
</html>