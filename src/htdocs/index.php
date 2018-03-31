<?php

require_once 'system/functions.php';

$pdo = get_db_connect();

$drink_data = array();
$drink_data = get_drink_info($pdo);


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

        <div class="formBlock">
            <form method="post" form="purchase_post">
                <label for="coin">お金</label>
                <input type="text" name="coin" id="coin">
            </form>
        </div>


        <form method="post" form="purchase_post">
            <ul class="productsItems">
                <li class="productsItem">
                    <div class="productsItem__inner">
                        <p class="thumbnail js-thumbnail"><img src="assets/img/uploads/coke.jpg" alt=""></p>
                        <p class="name">コーラ</p>
                        <p class="price">100円</p>
                        <div class="status">
                            公開
                        </div>
                    </div>
                </li>

                <li class="productsItem">
                    <div class="productsItem__inner">
                        <p class="thumbnail js-thumbnail"><img src="assets/img/uploads/nomu_cheese.jpg" alt=""></p>
                        <p class="name">飲むチーズ</p>
                        <p class="price">140円</p>
                        <p class="status">
                            <?php if ($status === 1) echo $input_radio; ?>

                            <input type="checkbox" name="">

                        </p>
                    </div>
                </li>

                <!--            <li class="productsItem">-->
                <!--                <div class="productsItem__inner">-->
                <!--                    <p class="thumbnail js-thumbnail"><img src="assets/img/uploads/ramune.png" alt=""></p>-->
                <!--                    <p class="name">ラムネ</p>-->
                <!--                    <p class="price">100円</p>-->
                <!--                    <p class="status">公開</p>-->
                <!--                </div>-->
                <!--            </li>-->
            </ul>
        </form>


        <div class="purchaseBlock">
            <form action="result.php" method="post">
                <input type="submit" value="購入する" id="purchase_post">
            </form>
        </div>
    </div>
</div>


</body>
</html>