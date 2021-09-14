<?php
$dsn="mysql:host=localhost;dbname=shop";
$user="root";
$pass='';
$optional=array(
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'
);
try{
    $con=NEW PDO($dsn,$user,$pass,$optional);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOexception $e){
    echo "failed".$e->getMessage();
}