<?php
session_start();

require_once 'system/define.php';
require_once 'system/functions.php';

$pdo = get_db_connect();
$drink_info = get_drink_info($pdo);
$_POST = escape($_POST);

$submit_purchase = $_POST['submit_purchase'];

if ($submit_purchase) {
    $purchased_drink_id = isset($_POST['product_radio']) ? $_POST['product_radio'] : NULL;
    //$purchased_drink_id = intval($purchased_drink_id);
    $inputed_coin = isset($_POST['coin']) ? $_POST['coin'] : NULL;


    $post_data[] = array(
       'purchased_drink_id' => $purchased_drink_id,
       'inputed_coin' => $inputed_coin,
    );

    //商品の値段を取得
    $product_price = get_products_price($pdo,$purchased_drink_id);

//    var_dump($product_price);

    $error = validation_index($post_data,$product_price);

    if(count($error) > 0){
        $data['error'] = $error;
        $_SESSION['product_radio'] = isset($purchased_drink_id) ? $_POST['product_radio'] : NULL;
        $_SESSION['coin'] = isset($inputed_coin) ? $_POST['coin'] : NULL;
//        header("Location:" . TOP_PAGE);
//        header('location' . TOP_PAGE);
    }else{
        update_inventory_control_by_purchase($pdo,$purchased_drink_id);
    }

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
                <input type="text" name="coin" id="coin" value="<?php if($_SESSION['coin']) echo $_SESSION['coin']; ?>">
                <?php if(isset($error['coin']))  echo  '<p class="error">' . $error['coin'] .  '</p>';?>

            </div>


            <ul class="productsItems">
                <?php

                $id_array = get_target_column($drink_info, 'id');
                $name_array = get_target_column($drink_info, 'drink_name');
                $price_array = get_target_column($drink_info, 'drink_price');
                $drink_img_path_array = get_target_column($drink_info, 'drink_img_path');
                $status_array = get_target_column($drink_info, 'status');
                $num_of_stock = get_target_column($drink_info, 'num_of_stock');
                display_productItem_index($drink_info, $id_array, $name_array, $price_array, $drink_img_path_array, $status_array, $num_of_stock);

                ?>
            </ul>


            <div class="purchaseBlock">
                <input type="submit" name="submit_purchase" value="購入する" id="purchase_post">
                <?php if(isset($error['empty']))  echo  '<p class="error">' . $error['empty'] .  '</p>';?>
            </div>

        </form>
    </div>
</div>


</body>
</html>