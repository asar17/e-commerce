<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">E-Commerce</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="dashboard.php">Home</a></li>
        <li class="active"><a href="catagory.php">Catagories</a></li>
        <li class="active"><a href="items.php">Items</a></li>
        <li class="active"><a href="members.php">Members</a></li>
        <li class="active"><a href="comments.php">Comments</a></li>
        <li class="active"><a href="#">Logs</a></li>





        
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $_SESSION['username'] ?>
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="members.php?action=edit&userid=<?php echo $_SESSION['userID'] ?>">Edit Profile</a></li>
          <li><a href="#">Setting</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </li>
      </ul>
    </div>
  </div>
</nav>