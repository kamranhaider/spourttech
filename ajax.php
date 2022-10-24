<?php
include("classes/cart.php");
$cart = new cart();
$action = $_REQUEST['action'];
switch($action){
    case "loadcart":
        $cartItems = $cart->getCart();
        
        ?>
        <table class="table bordered">
            <thead>
                <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Rate</th>
            </tr>
            <tbody>
            <?php 
                $subtotal = 0;
                $diliveryCarges = $cartItems['deliverCharges'];
                $discount = $cartItems['discount'];
                $grandTotal = $cartItems['grandTotal'];
                $subtotal = $cartItems['subTotal'];
                foreach($cartItems['items'] as $item){ 
                
                
                ?>
                <tr>
                    <td><?php echo $item['product_name']?></td>
                    <td><?php echo $item['quantity']?></td>
                    <td><?php echo $item['rate']?></td>
                </tr>                
            <?php }?>
                <tr><td colspan="3"></td></tr>
                <tr>
                    <td><strong>Sub Total</strong></td><td></td><td><?php echo $subtotal?></td>
                </tr>
                <tr>
                    <td><strong>Delivery Charges</strong></td><td></td><td><?php echo $diliveryCarges?></td>
                </tr>
                <tr>
                    <td><strong>Discount</strong></td><td></td><td><?php echo $discount?></td>
                </tr>
                <tr>
                    <td><strong>Grand Total</strong></td><td></td><td><?php echo $grandTotal?></td>
                </tr>
        </table>
        
        <?php
        break;
    case "addToCart":
        $productCode=$_POST['code'];
        $cart->addToCart($productCode);
        break;
    case "checkOut":
        $cart->checkOut();
        break;
}