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
        <!-- <div class="container"> -->
          <ul class='new-nav'>
            <?php 
            if(!isset($_SESSION['user'])){
            ?>
            <li><a href="login.php?do=login">login|</a><a href="login.php?do=signup">signup</a></li>
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
                        echo "uploads\cover\\".$row[0]['profileimg'] ;
                    }
                    ?>
                    " alt="">
                    </a>
                   </li>
                  <li><a href="profile.php?userid=<?php echo $_SESSION['userid']?>&#items">My items</a></li>
                  <li><a href="profile.php?userid=<?php echo $_SESSION['userid']?>&#comments">My comments</a></li>
                  <?php
                  }
                  ?>
                  <?php if(checkisadmin($_SESSION['userid'])==1) { ?>
                  <li><a href="admin\dashed.php">Admin page</a></li>
              <?php
                  }
                  
            }
            ?>
          </ul>
        <!-- </div> -->
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
</nav>
 