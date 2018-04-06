<?php
session_start();

require_once 'system/define.php';
require_once 'system/functions.php';

$pdo = get_db_connect();
$drink_info = get_drink_info($pdo);
$_POST = escape($_POST);




$_SESSION['coin'] = isset($_SESSION['coin']) ? $_SESSION['coin'] : NULL;
$_SESSION['product_radio'] = isset($_SESSION['coin']) ? $_SESSION['product_radio'] : NULL;

$post_id = $_SESSION['product_radio'];
$purchased_drink_data = get_product_purchased($pdo,$post_id);

$coin_put = intval($_SESSION['coin']);
$product_price = intval($purchased_drink_data["drink_price"]);
$difference_money = $coin_put - $product_price;

$_SESSION = array();
session_destroy();


?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
    <title>自動販売機結果</title>
</head>
<body>
<p>自動販売機結果</p>
<div class="puchase_result">

    <p class="thumbnail">
        <img src="<?php if(isset($purchased_drink_data['drink_img_path'])) echo  $purchased_drink_data['drink_img_path']; ?>" alt="">
    </p>
    <p>がしゃん！!!<?php echo $purchased_drink_data['drink_name'];?>が買えました！</p>
    <p>おつりは<?php echo $difference_money;?>円です！</p>
</div>


</body>
</html>