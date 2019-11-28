<?php

session_name('store');
session_start();

include('config.php');
include('connect.php');

if (isset($_SESSION['cart'])) { 
    $cart = unserialize($_SESSION['cart']); 
    $sum = $_SESSION['sum']; 
}
else 
    $sum = 0;

// обработка переменных
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$qty = filter_input(INPUT_GET, 'qty', FILTER_VALIDATE_INT);

if ($qty == FALSE || $qty == NULL) 
    $qty = 1;
    
if ($id == FALSE || $id == NULL) 
    header("HTTP/1.0 404 Not Found");

// добавляем товар в корзину
$cart[$id] = $qty;

// Получаем цену товара
$q = "select * from products where id=$id limit 1";
$res = $conn->query($q);

// Проверяем, а есть ли такой товар вообще
if ($res->num_rows > 0) {
    $product = $res->fetch_assoc();
    $price = $product['price'];
}
else
    $price = 0;    

$sum = $sum + $price * $qty;

// обновляем данные в сессии
$_SESSION['sum'] = $sum;
$_SESSION['cart'] = serialize($cart);

// уходим туда откуда вызвано
$ref = $_SERVER['HTTP_REFERER'];
Header("Location: $ref");

?>
