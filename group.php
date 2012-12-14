<?php
  include('groupDashboard.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $groupData->name();?>'s Analytics</title>
  
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
           <a href="#" target="_BLANK" class="thumbnail">
            <img id="profilePicture" src="<?php echo $groupData->picture();?>" alt="Profile Picture"/>
           </a>
         </div>

         <div class="profileInfo">
         		<h1><?php 
                //TODO: get the real name!
                echo $groupData->name();
                ?></h1>
         </div>
       </div>

       <div class="statistics row-fluid">
        <div class="box well span3">
          <div class="number"><?php echo Helper::formatNumber($groupData->totalViewCount());?></div>
          <div class="statistic muted">Total Views</div>
        </div>
        <div class="box well span3">
          <div class="number"><?php echo Helper::formatNumber($groupData->presentationCount());?></div>
          <div class="statistic muted">Presentations</div>
        </div>
        <div class="box well span3">
          <div class="number"><?php echo Helper::formatNumber($groupData->totalCommentCount());?></div>
          <div class="statistic muted">Comments</div>
        </div>
        <div class="box well span3">
          <div class="number"><?php echo count($groupData->usernames());?></div>
          <div class="statistic muted">Members</div>
        </div>
       </div>

       <div class="users row-fluid">
         <table class="table table-bordered table-hover">
          <thead>
            <tr >
              <th>Username</th>
              <th>Total Views</th>
              <th>Total Presentations</th>
              <th>Average Views / Presentation</th>
            </tr>
          </thead>

          <?php foreach($groupData->users() as $user) {?>
          <tr>
            <td class="username"><a href="<?php echo $user->profileLink();?>" target='_BLANK'><?php echo $user->name();?></a></td>
            <td><?php echo Helper::formatNumber($user->totalViewCount());?></td>
            <td><?php echo Helper::formatNumber($user->presentationCount());?></td>
            <td><?php echo Helper::formatNumber($user->averageViewCount());?></td>
          </tr>
          <?php }?>

         </table>
       </div>

       <div class="details">
         <div class="page-header">
          <h2>Top Slideshows</h2>
         </div>

         <?php 

         //Display the presentations
         foreach($groupData->slideshows() as $slideshow) {
         ?>
         

           <div class="presentation muted">

            <div class="image">
              <a class="thumbnail" target="_BLANK" href="<?php echo $slideshow->url();?>">
                <img src="<?php echo $slideshow->thumbnailUrl();?>" alt="title"/>
              </a>
            </div>

            <div class="presentationInfo">
              <div class="title"><?php echo $slideshow->title();?></div>
              <div class="creator"><a href="<?php echo $slideshow->userProfileLink();?>" target="_BLANK"><?php echo $slideshow->username();?></a></div>
              <div class="date"><?php echo $slideshow->createdDate();?></div>
              <div class="views"><span class="number"><?php echo Helper::formatNumber($slideshow->numViews());?></span> Views</div>
              <div class="favorites"><span class="number"><?php echo Helper::formatNumber($slideshow->numFavorites());?></span> Favorites</div>
              <div class="comments"><span class="number"><?php echo Helper::formatNumber($slideshow->numComments());?></span> Comments</div>
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