<?php
$pagetitle='cart page';
include "init.php";
if($_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['userid']))
{
    ?>
    <div class=' cartbackground'>
        <div>
            <a href="index.php">home></a><a href="<?php $_SERVER['PHP_SELF']?>">cart</a>
        </div>
    </div>
    <div class='container'>
        <div class='orders'>
                <div class='title'>
                    <h1>the orders</h1>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>trader</th>
                            <th>product</th>
                            <th>order Date</th>
                            <th>arrivail date</th>
                            <th>number of pieces</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $row = getuserorders($_SESSION['userid'],"trader_id","client_id");
                    if(!empty($row))
                    {
                        
                        foreach($row as $order)
                        {
                            $datenow=date("now");
                            $datenow=strtotime($datenow);
                            $orderdate=strtotime($order['ArrivalDate']);
                            if($order['ArrivalDate']==null||$datenow <$orderdate)
                            {
                                echo"<tr>";
                                echo "<td><a href='profile.php?userid=".$order['userid']."'>".$order['trader_id']."</a></td>";
                                echo "<td><a href='item.php?itemid=".$order['itemid']."'>".$order['itemname']."</a></td>";
                                echo "<td>".$order['orderDate']."</td>";
                                echo "<td>";
                                if($order['ArrivalDate']==null)
                                {
                                    echo "<p>wait the trader</p>";
                                }
                                else
                                {
                                    echo $order['ArrivalDate'];
                                }
                                echo"</td>";
                                echo "<td>".$order['num']."</td>";
                                echo"</tr>";
                            }
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
    </div>
    <?php
}
elseif($_SERVER['REQUEST_METHOD']=='GET'&&isset($_GET['do']))
{
    ?>
    <div class='container'>
        <div class='orders'>
                <div class='title'>
                    <h1>the orders</h1>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>client</th>
                            <th>product</th>
                            <th>order Date</th>
                            <th>arrivail date</th>
                            <th>number of pieces</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $row = getuserorders($_SESSION['userid'],"client_id","trader_id");
                    if(!empty($row))
                    {
                        
                        foreach($row as $order)
                        {
                            echo"<tr>";
                            echo "<td><a href='profile.php?userid=".$order['userid']."'>".$order['client_id']."</a></td>";
                            echo "<td><a href='item.php?itemid=".$order['itemid']."'>".$order['itemname']."</a></td>";
                            echo "<td>".$order['orderDate']."</td>";
                            echo "<td>";
                            if($order['ArrivalDate'] ==null)
                                echo"<button id='appear' value='".$order['orderid']."'>set date</button>";
                                else
                                {
                                    echo $order['ArrivalDate'];
                                }
                            echo"</td>";
                            echo "<td>".$order['num']."</td>";
                            echo"</tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
    </div>
    <div class='setarrival' id='setarrival'>
        <i class='fas fa-times'></i>
        <div >
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <input type="hidden" id='id' name='id'>
            <input type="datetime-local" name='date'>
            <input type="submit" value='set date'>
        </form>
        </div>
        </div>
    <?php
}
elseif($_SERVER['REQUEST_METHOD']=='POST')
{
    $date=$_POST['date'];
    $id=$_POST['id'];
    $stmt=$con->prepare("UPDATE orders SET ArrivalDate=? WHERE orderid=?");
    $stmt->execute([$date,$id]);
    header("location:".$_SERVER['HTTP_REFERER']);
}
include $tmp."/footer.php";