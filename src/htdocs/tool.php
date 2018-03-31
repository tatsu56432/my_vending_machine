<?php
session_start();
require_once 'system/functions.php';

$submit = $_POST['submit'];
$posted_drink_data = array();
if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    if ($submit) {
        $product_name = isset($_SESSION['product_name']) ? $_POST['product_name'] : NULL;
        $price = isset($_SESSION['price']) ? $_POST['price'] : NULL;
        $num = isset($_SESSION['num']) ? $_POST['num'] : NULL;
        $image = isset($_SESSION['image']) ? $_POST['image'] : NULL;
        $status = isset($_SESSION['status']) ? $_POST['status'] : NULL;


        $posted_drink_data['drink_name'] = $product_name;
        $posted_drink_data['drink_price'] = $price;
        $posted_drink_data['drink_num'] = $num;
        $posted_drink_data['drink_img'] = $image;
        $posted_drink_data['status'] = $status;


        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";


    }


}


?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理画面ページ</title>
    <script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
</head>

<body class="tool">
<h1>自動販売機管理ページ</h1>

<p class="tool--ttl">新規商品名追加</p>

<div class="container">
    <div class="container__inner">
        <div class="formBlock">
            <form action="" method="post" enctype=”multipart/form-data”>
                <div class="formBlock__item">
                    <label for="product_name">商品名</label>
                    <input type="text" name="product_name" value="<?php if ($_SESSION['product_name']) {
                        echo $product_name;
                    } ?>" id="product_name">
                </div>

                <div class="formBlock__item">
                    <label for="price">値段</label>
                    <input type="text" name="price" id="price" 　value="<?php if ($_SESSION['price']) {
                        echo $price;
                    } ?>">
                </div>

                <div class="formBlock__item">
                    <label for="num">個数</label>
                    <input type="text" name="num" id="num" value="<?php if ($_SESSION['num']) {
                        echo $num;
                    } ?>">
                </div>
                <div class="formBlock__item">
                    <label for="image">商品画像</label>
                    <input type="file" name="image" id="image">
                </div>

                <div class="formBlock__item">
                    <label for="status">商品ステータス</label>
                    <select name="status" id="status">
                        <option value="open" <?php if ($status == "true") echo "selected" ?> >公開</option>
                        <option value="hidden" <?php if ($status == "false") echo "selected" ?>>非公開</option>
                    </select>
                </div>

                <div class="formBlock__item">
                    <input type="submit" id="submit" value="商品追加" name="submit">
                </div>
            </form>
        </div>
        <h2>商品情報変更</h2>
        <p>商品一覧</p>
        <ul class="productsItems js-productsItems">
            <li class="productsItem ">
                <dl>
                    <dt>商品画像</dt>
                    <dd>
                        <p class="thumbnail js-thumbnail"><img src="assets/img/uploads/coke.jpg" alt=""></p>
                    </dd>
                </dl>
                <dl>
                    <dt>商品名</dt>
                    <dd><p>コーラ</p></dd>
                </dl>
                <dl>
                    <dt>価格</dt>
                    <dd><p>100円</p></dd>
                </dl>
                <dl>
                    <dt>在庫数</dt>
                    <dd>
                        <div class="stock">
                            <form action="#" method="post">
                                <p>
                                    <input type="text" name="num">個
                                </p>
                                <p>
                                    <input type="submit" name="submit" value="変更">
                                </p>
                            </form>
                        </div>
                    </dd>
                </dl>
                <dl>
                    <dt>ステータス</dt>
                    <dd>
                        <form action="#" method="post">
                            <button type="submit" name="status_btn" value="<?php   ?>">公開→非公開</button>
                        </form>
                    </dd>
                </dl>
            </li>

            <li class="productsItem is-hidden">
                <dl>
                    <dt>商品画像</dt>
                    <dd>
                        <p class="thumbnail js-thumbnail"><img src="assets/img/uploads/coke.jpg" alt=""></p>
                    </dd>
                </dl>
                <dl>
                    <dt>商品名</dt>
                    <dd><p>コーラ</p></dd>
                </dl>
                <dl>
                    <dt>価格</dt>
                    <dd><p>100円</p></dd>
                </dl>
                <dl>
                    <dt>在庫数</dt>
                    <dd>
                        <div class="stock">
                            <form action="#" method="post">
                                <p>
                                    <input type="text" name="num">個
                                </p>
                                <p>
                                    <input type="submit" name="submit" value="変更">
                                </p>
                            </form>
                        </div>
                    </dd>
                </dl>
                <dl>
                    <dt>ステータス</dt>
                    <dd>
                        <form action="#" method="post">
                            <button type="submit" name="status_btn" value="<?php   ?>">公開→非公開</button>
                        </form>
                    </dd>
                </dl>
            </li>

        </ul>

    </div>
</div>


</body>
</html>