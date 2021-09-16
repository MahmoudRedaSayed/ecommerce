<!DOCTYPE html>
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
        <div class="container">anothor nav</div>
    <nav class="navbar navbar-expand-lg  ">
  <div class="container">
    <a class="navbar-brand" href="dashed.php">Home page</a>
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
 