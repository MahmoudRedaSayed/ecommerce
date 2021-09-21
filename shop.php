<?php
session_start();
include "init.php";
?>
<div class="container">
<div class=" newproducts">
    <div class='head text-center'>
        <p>our products</p>
    </div>
    <div class='products'>
        <?php
        $stmt=$con->prepare("SELECT * FROM items ORDER BY itemDate DESC ");
        $stmt->execute();
        $row=$stmt->fetchAll();
        if(!empty($row))
        {
            foreach($row as $product)
            {
                echo "<div class='product'>";
                echo "<img src='uploads\items\\".$product['itemimage']."' loading='lazy'>";
                echo "<p>".$product['itemname']."</p>";
                echo "<span>".$product['price']."</span>";
                echo "<div class='itemselection'><a href='item.php?itemid=".$product['itemid']."&itemname=".$product['itemname']."' class='select'>select options</a></div>";
                echo"</div>";
            }
        }
        ?>
    </div>
</div>
</div>
<?php
include $tmp."/footer.php";