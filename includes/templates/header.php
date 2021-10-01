<!DOCTYPE html>
<!-- <?php session_start();
?> -->
<HTML>
    <head>
        <!-- google font color: #666; -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
        <meta charset="UTF-8" >
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <!-- fontowsome -->
        <link rel="stylesheet" href="<?php echo $css;?>/all.min.css">
        <!-- bootstrap -->
        <!-- <link rel="stylesheet" href="<?php echo $css;?>/bootstrap.min.css"> -->
        <!-- the main file  ?v=<?php echo time(); ?> to force the file to reload-->
        <link rel="stylesheet" href="<?php echo $css;?>/main.css?v=<?php echo time(); ?>">
        <title><?php getTitle();?></title>
    </head>
    <body>
        <!-- <div class="container">
          <ul class='new-nav'>
            <?php 
            if(!isset($_SESSION['user'])){
            ?>
            <li><a href="login.php?do=login">login|</a><a href="login.php?do=signup">signup</a></li>f
            <?php
            }
            else
            {
              ?>
                  <li><a href="logout.php">logout</a></li>
                  <?php if(checkisactive($_SESSION['userid'])==1) { ?>
                    <li> <a href='profile.php?userid=<?php echo $_SESSION['userid'];?>'>
                  <?php
                    $row=getDataProfile($_SESSION["userid"]);
                    echo $row[0]['fullname'];?>
                    <img class='profileimg' src="<?php
                    if(empty($row[0]['profileimg']))
                    {
                        if($row[0]['gander']==1)
                        {
                            echo 'uploads\default\user-icon.png';
                        }
                        else
                        {
                            echo'uploads\default\user-icon-female.jpg';
                        }
                    }
                    else
                    {
                        echo "uploads\profiles\\".$row[0]['profileimg'] ;
                    }
                    ?>
                    " alt="">
                    </a>
                   </li>
                   <?php if($_SESSION['usergroupid']!=0){ ?>
                  <li><a href="profile.php?userid=<?php echo $_SESSION['userid']?>&#items">My items</a></li>
                  <?php }?>
                  <li><a href="profile.php?userid=<?php echo $_SESSION['userid']?>&#comments">My comments</a></li>
                  <?php
                  }
                  ?>
                  <?php if($_SESSION['usergroupid']==1 || $_SESSION['usergroupid']==2) { ?>
                  <li><a href="admin\dashed.php">Admin page</a></li>
              <?php
                  }
                  
            }
            ?>
          </ul>
        </div>
    <nav class="navbar navbar-expand-lg  ">
  <div class="container">
    <a class="navbar-brand" href="index.php">Home page</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class='navbar'>
        <?php
        $row= getcat();
        foreach($row as $cata)
        {
            echo"<li><a  class='nav-link' href='catagories.php?catid=". $cata['catagory_id']."&catname=".str_replace(' ','-',$cata['catagory_name'])."'>";
            echo $cata['catagory_name'];
            echo"</a></li>";
        }
        
        ?>
    </ul>
    </div>
</div>
</nav> -->
<!-- the start of the nav bar  -->
<nav class="navbar">
<div class=container>
  <div class='logo'>
    <a href="index.php"><img src="logo.png" alt="logo"></a>
  </div>
  <div class='links' id='links'>
    <ul>
      <li><a href="index.php">home</a></li>
      <li><a href="shop.php">shop</a></li>
      <li> <a href="">contact us</a> </li>
      <?php if(isset($_SESSION['usergroupid'])&&$_SESSION['usergroupid']!=0&&$_SESSION['usergroupid']!=3){?>
      <li> <a href="admin/dashed.php">Admin page</a> </li>
      <?php } ?>
      <?php if(isset($_SESSION['usergroupid'])&&$_SESSION['usergroupid']!=0){?>
      <li> <a href="cart.php?do=required">required orders</a> </li>
      <?php } ?>
      <!-- <li></li> -->
    </ul>
  </div>
  <?php if(isset($_SESSION['userid'])) {?>
  <div class='user'>
  <ul>
    <li>
        <a href="cart.php?userid=<?php echo $_SESSION['userid'];?>"><i class="fas fa-shopping-cart">
          <span class="before">
          <?php
          echo getuserstatics($_SESSION['userid'],"orders","client_id");
          ?>
          </span>
        </i></a>
    </li>
    <li>
        <a href="loves.php?userid=<?php echo $_SESSION['userid']?>"><i class="far fa-heart">
        <span class="before">
          <?php
          echo getuserstatics($_SESSION['userid'],"loves","member_id");
          ?>
        </span>
        </i></a>
    </li>
    <li>
        <a href="profile.php?userid=<?php echo $_SESSION['userid']?>"><i class="far fa-user"></i></a>
    </li>
  </ul>
  </div>
  <?php }
  else
  {
    ?>
    <div class='login'><a href="login.php?do=login">login|</a><a href="login.php?do=signup">signup</a></div>
    <?php
  }
  ?>
  <i class="fas fa-bars" id='bars'></i> 
</div>
</nav>
<!-- the end of the nav bar  -->
 