<?php
//unset($_COOKIE['sessionId']);
class cart
{
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPswd = '';
    private $dbDB = 'spourt_test';
    private $dbCon;
    private function dbConnect(){
        $this->dbCon = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPswd, $this->dbDB);
    }
    private function dbClose(){
        if(is_resource($this->dbCon)) mysqli_close($this->dbCon);
    }
    public function createSession(){        
        if(isset($_COOKIE['sessionId']))
        {
            $sessionId = $_COOKIE['sessionId'];
        }else{
            $sessionId = $this->randomString();
            $this->dbConnect();
            $sql = "INSERT INTO tbl_cart (session_id) VALUES('".$sessionId."')";
            echo $sql;
            mysqli_query($this->dbCon, $sql);
            $cartID = mysqli_insert_id($this->dbCon);
            mysqli_close($this->dbCon);
            setcookie('cartID', $cartID, time() + (86400 * 30), "/"); // 86400 = 1 day
            setcookie('sessionId', $sessionId, time() + (86400 * 30), "/"); // 86400 = 1 day
        }
        return $sessionId;
    }
    public function randomString(){
        $str = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','9','8','7','6','5','4','3','2','1');
        $random = "";
        $i=1;
        for($i=1; $i<=16; $i++){
            $random .= $str[rand(0,35)];
        }
        return $random;
    }
    public function getCart(){
        $sessionID = $_COOKIE['sessionId'];
        $this->dbConnect();
        $sql = "SELECT prod.product_code, prod.product_name, prod.product_price, itm.quantity, 
        FORMAT(itm.quantity * prod.product_price, 2) rate
        FROM tbl_cartitems itm, tbl_cart cart, tbl_products prod 
        WHERE prod.product_code = itm.product_code AND cart.cart_id = itm.cart_id AND cart.session_id  = '".$sessionID."'";
        $rs = mysqli_query($this->dbCon, $sql);
        $result = array();
        $subTotal = 0;
        $deliveryCharges = 0;
        $discount = 0;
        $discountGiving = 0;
        while($row = mysqli_fetch_assoc($rs)){
            $result[] = $row;
            $subTotal = $subTotal + $row['rate'];
            if($row['product_code']=='R01') $discountGiving = 1;
        }
        if($discountGiving==1){
            foreach($result as $item){
                if($item['product_code']!='R01'){
                    $disTemp = ($item['product_price'] / 2) * $item['quantity'];
                    $discount = $discount + $disTemp; 
                }
            }
        }
        $this->dbClose();
        if($subTotal<50) $deliveryCharges = 4.95;
        elseif($subTotal<90) $deliveryCharges = 2.95;
        elseif($subTotal>90) $deliveryCharges = 0;

        $grandTotal = ($subTotal - $discount) + $deliveryCharges;
        return array('items'=>$result, 'subTotal'=>$subTotal, 'discount'=>$discount, 'deliverCharges'=>$deliveryCharges,'grandTotal'=>$grandTotal);
    }

    public function addToCart($productCode){
        $cartId = $_COOKIE['cartID'];
        $sql = "INSERT INTO tbl_cartitems (cart_id, product_code, quantity)"; 
        $sql .= "  VALUES('".$cartId."', '".$productCode."','1')";
        $sql .= " ON DUPLICATE KEY UPDATE quantity = quantity + 1";
        $this->dbConnect();
        mysqli_query($this->dbCon, $sql);
        $this->dbClose();
        return;
    }

    public function getProducts(){
        $sql = "select * from tbl_products";
        $this->dbConnect();
        $rs = mysqli_query($this->dbCon, $sql);
        $result = array();
        while($row = mysqli_fetch_assoc($rs)){
            $result[] = $row; 
        }
        $this->dbClose();
        return  $result ;
    }
    public function checkOut(){
        $cart = $this->getCart();
        $cartID = $_COOKIE['cartID'];
        $total = $cart['subTotal'];
        $discount = $cart['discount'];
        $delivery = $cart['deliverCharges'];
        $grandTotal = $cart['grandTotal'];
        $sql = "UPDATE tbl_cart set  total = '".$total."',
        discount = '".$discount."', grand_total = '".$grandTotal."',
        delivery_charges = '".$delivery."', cart_status = 'Close' where cart_id='".$cartID."'";
        $this->dbConnect();
        mysqli_query($this->dbCon, $sql);
        $this->dbClose();
        unset($_COOKIE['sessionId']);
        unset($_COOKIE['cartID']);
        $this->createSession();


    }
}
?>
