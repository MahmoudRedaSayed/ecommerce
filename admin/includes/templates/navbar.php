<?php
?>
<nav class="navbar navbar-expand-lg navbar-light ">
  <div class="container">
    <a class="navbar-brand" href="dashed.php">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="catagory.php?do=manage">catagorise</a>
        </li>
        <li> 
          <a class="nav-link" href="members.php">members</a>
        </li>
        <li>
          <a class="nav-link" href="items.php">items</a>
        </li>
        <li> 
          <a class="nav-link" href="comments.php">comments</a>
        </li>
        <li> 
          <a class="nav-link" href="statistics.php">statistics</a>
        </li>
        <li class="nav-item dropdown nav-right">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mahmoud
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="../index.php">visit shop</a></li>
            <li><a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['userid'];?>">Edit Profile</a></li>
            <li><a class="dropdown-item" href="#">settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
