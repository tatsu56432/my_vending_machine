<?php
session_start();

require_once 'system/define.php';
require_once 'system/functions.php';

$pdo = get_db_connect();
$pdo = get_db_connect();
$drink_info = get_drink_info($pdo);

$_POST = escape($_POST);
$submit_purchase = $_POST['submit_purchase'];
if ($submit_purchase) {

    $purchased_drink_id = isset($_POST['product_radio']) ? $_POST['product_radio'] : NULL;
    $inputed_coin = isset($_POST['coin']) ? $_POST['coin'] : NULL;
    $post_data[] = array(
       'purchased_drink_id' => $purchased_drink_id,
       'inputed_coin' => $purchased_drink_id,
    );







    update_inventory_control_by_purchase($pdo,$purchased_drink_id);

//    header("Location:" . TOOL_PAGE);


}


?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>自動販売機</title>
    <script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.0.min.js"></script>
    <!--style-->
    <link rel="stylesheet" href="assets/css/style.css">
    <!--script-->
    <script src="assets/js/script.js"></script>
</head>

<h1>自動販売機</h1>
<body class="index">
<div class="container">
    <div class="container__inner">
        <form action="" method="post">


            <div class="formBlock">
                <label for="coin">お金</label>
                <input type="text" name="coin" id="coin">
            </div>


            <ul class="productsItems">
                <?php

                $id_array = get_target_col($drink_info, 'id');
                $name_array = get_target_col($drink_info, 'drink_name');
                $price_array = get_target_col($drink_info, 'drink_price');
                $drink_img_path_array = get_target_col($drink_info, 'drink_img_path');
                $status_array = get_target_col($drink_info, 'status');
                $num_of_stock = get_target_col($drink_info, 'num_of_stock');
                display_productItem_index($drink_info, $id_array, $name_array, $price_array, $drink_img_path_array, $status_array, $num_of_stock);

                ?>
            </ul>


            <div class="purchaseBlock">
                <input type="submit" name="submit_purchase" value="購入する" id="purchase_post">
            </div>

        </form>
    </div>
</div>


</body>
</html>