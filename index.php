<?php
session_start();
include "init.php";
$count=0;
echo "<div class='container'>";
if(isset($_SESSION['user']))
{
    $nologin;
}
$items=getAllitems();
    echo "<div class='container items'>";
            foreach($items as $item)
            {
                if($item['approve']==1)
                {
                    echo "<div class='item'>";
                echo "<div class='itemimage'><img src='uploads\\";
                if(empty($item['itemimage']))
                {
                    echo"default\\item.png";
                }
                else
                {
                    echo"items\\".$item['itemimage'];
                }
                echo"'/>";
                echo "<div class='user-item'>";
                echo "<p class='text-center'>published by </p>";
                echo "<a href='profile.php?userid=".$item['userid']."'>";
                ?>
                    <img class='profileimg' src="<?php
                    if(empty($item['profileimg']))
                    {
                        if($item['gander']==1)
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
                        echo "uploads\cover\\".$item['profileimg'] ;
                    }
                    ?>
                    " alt="">
                <?php
                if(isset($_SESSION['userid']))
                {
                    if($item['userid']==$_SESSION['userid'])
                    {
                        echo "you";
                    }
                    else
                    {
                        echo $item['fullname'];
                    }
                }
                else
                {
                    echo $item['fullname'];
                }
                echo"</a>";
                echo "<a class='more-detials' href='item.php?itemid=";
                echo $item['itemid']."&itemname=".$item['itemname'];
                echo"'> more detials </a>";
                echo"</div>";
                echo "</div>";
                echo"<div class='itemdata'>";
                echo "<h2 class='itemname'>".$item['itemname']."</h2><hr>";
                echo "<div class='itemslider'>";
                echo "<p class='itemcountry'> country made : ".$item['country_made']."</p>";
                echo "<p class='itemcountry'> stutes : ";
                if($item['stutes']==1)
                {
                    echo "New";
                }
                elseif($item['stutes']==2)
                {
                    echo 'Used';
                }
                else
                {
                    echo 'old';
                }
                echo"</p>";
                echo "<p class='itemcountry'> days ago : ";
                /////////////////////////////another way/////////////////////////////
                // $time=new DateTime(date('Y-m-d'));
                // $time2=new DateTime($catitems['itemDate']);
                // $time2=$time->diff($time2);
                // echo $time2->d;
                // echo date('d',$time2);
                /////////////////////////////////////////////////////////////////////
                $interval=date_diff(new DateTime(date('y-m-d')),new DateTime($item['itemDate']));
                echo $interval->d;
                echo"</p>";
                echo "<p class='itemprice'>".$item['price']."$</p>";
                echo"</div>";
                echo"</div>";
                echo"</div>";
                }
                else
                {
                    $count++;
                }
            }
            echo"</div>";
            if($count!=0)
            {
                echo "<h2 class='h2-text'>there's ".$count." under control</h2>";
            }
echo"</div>";
echo"</div>";
include "includes/templates/footer.php";
?>