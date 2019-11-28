<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

include('config.php');
include('connect.php');

// Filling brands

for ($i=1; $i <= 5; $i++) {

  $sql = "insert into `brands` values(\"\", \"Brand $i\")";
  echo "<br>".$sql;
  $mysqli->query($sql);
 
  if ($mysqli->connect_errno) {
    echo "SQL errno: " . $mysqli->connect_errno . "<br>\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    die();
}
}



$price = 50;      // min price
$length = 33;     // const length
$weight = 90;     // min weight
$qty = 10;        // const qty
$sex = 'M';
$sex = 'M';
$model = '';
$info = "Polished and Brushed Stainless Steel Transparent Case-Back Fitted with Screws- Sapphire Crystal Face- Check-Stamped Sunray Dial - Two Years International Warranty
  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat
<p>augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigatione";

// Filling Products
for ($i = 1; $i <= 36; $i++) {

  if ($i < 12) $bid = 2;
  if ($i > 12 && $i < 24) $bid = 1;
  if ($i >= 24) $bid = 3;
  
  if ($i % 2 == 0) $sex = 'F';
  else $sex = 'M';
    
  $price = $price + $i * 5;
  
  
  $sql = "insert into `products` values(\"\", \"w-$i\", $bid, \"$sex\", \"Watch $i\", \"$info\", $length, $weight, \"quartz\", $qty, $price)";
  echo "<br>".$sql;
   $mysqli->query($sql);
   
    if ($mysqli->connect_errno) {
    echo "SQL errno: " . $mysqli->connect_errno . "<br>\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    die();
} 
}
  

?>