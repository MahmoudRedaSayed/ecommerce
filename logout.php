<?php
//destroy the session
session_start();    //open the session
session_unset();    //remove the data
session_destroy();  //destroy it
header('location: index.php');
exit();
