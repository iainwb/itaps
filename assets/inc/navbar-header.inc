    <!-- Fixed navbar -->
<nav class="navbar navbar-toggleable-sm navbar-inverse fixed-top bg-inverse">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">iTaps</a>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
<?php navbar($pagename) ?>
  <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-cogs fa-lg" aria-hidden="true"></span></a>
  <div class="dropdown-menu">
                  
  				 <a class="dropdown-item" href="profile.php">Profile</a> 
                  <a class="dropdown-item" href="settings.php">Settings</a>
                  <a class="dropdown-item" href="logout.php">Logout</a>
                </div> 
    </ul>
    <?php 
	new_button ($pagename)
?>


</div>

      



</nav>