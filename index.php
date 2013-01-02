<!DOCTYPE html>
<html>
  <head>
    <title>Slideshare Analytics | Made By Nikil</title>
  
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
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
        
        <h1 id="heading">Slideshare Analytics</h1>
        <h2 id="tagline">Beautiful Sideshow Dashboards</h2>

        <div id="browse">
          See some example dashboards: <br/> <br/>
          <a href="user.php?u=bjfogg">BJ Fogg </a> <br/>
          <a href="user.php?u=nikilster">Nikil Viswanathan</a> <br/>
          <a href="user.php?u=maditabalnco">maditabalnco</a> <br/>
          <br/>
          or jump to a specific person
        </div>
        <div id="userForm">
          <form class="form-horizontal" type="GET" action="user.php">
            <input id="username" type="text" class="input-large" placeholder="Slideshare username" name="u"/>
            <button id="submitButton" class="btn btn-primary btn-large" type="submit">Go!</button>
          </form>
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
    <!--<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>-->

  </body>
</html>