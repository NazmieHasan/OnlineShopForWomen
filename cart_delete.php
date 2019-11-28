<?php

session_name('store');
session_start();

include('config.php');
include('connect.php');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id == FALSE || $id == NULL) 
    header("HTTP/1.0 404 Not Found");

@$ref = $_SERVER['HTTP_REFERER'];

if (isset($_SESSION['cart'])) { 
    $cart = unserialize($_SESSION['cart']); 
    $sum = $_SESSION['sum']; 
}
else 
    Header("Location: $ref");
    
if (isset($cart[$id])) {

    $qty = $cart[$id];
    unset($cart[$id]);      // удаляем из корзины элемент
  
    // Определяем цену товара
    $q = "select * from products where id=$id limit 1";
    $res = $conn->query($q);

    // Проверяем, а есть ли такой товар вообще
    if ($res->num_rows > 0) {
        $product = $res->fetch_assoc();
        $price = $product['price'];
    }
    else
        $price = 0;    
        
     $sum = $sum - $price * $qty;

    // обновляем данные в сессии
    $_SESSION['sum'] = $sum;
    $_SESSION['cart'] = serialize($cart);
}

// уходим туда, откуда вызвано
Header("Location: $ref");   
        
?>    