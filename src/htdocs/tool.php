<?php
session_start();
require_once 'system/define.php';
require_once 'system/functions.php';

$pdo = get_db_connect();
$drink_info = get_drink_info($pdo);

//echo "<pre>";
//var_dump($drink_info);
//echo "</pre>";


$submit = $_POST['submit'];
$submit2 = $_POST['submit2'];
$submit3 = $_POST['submit3'];

$posted_drink_data = array();

if ($submit) {

    $product_name = isset($_SESSION['product_name']) ? $_POST['product_name'] : NULL;
    $price = isset($_SESSION['price']) ? $_POST['price'] : NULL;
    $num = isset($_SESSION['num']) ? $_POST['num'] : NULL;
    if (is_uploaded_file($_FILES["image"]["tmp_name"])){
        $image = true;
    }else{
        $image = false;
    }
//    $image = isset($_SESSION['image']) ? $_FILES['image'] : NULL;
    $status = isset($_SESSION['status']) ? $_POST['status'] : NULL;



    $posted_drink_data['product_name'] = $product_name;
    $posted_drink_data['price'] = $price;
    $posted_drink_data['num'] = $num;
    $posted_drink_data['image'] = $image;
    $posted_drink_data['status'] = $status;



    $error = validation($posted_drink_data);

    if (count($error) > 0) {
        $data = array();
        $data['error'] = $error;
        escape($data['error']);
        $_SESSION['product_name'] = isset($_POST['product_name']) ? $_POST['product_name'] : NULL;
        $_SESSION['price'] = isset($_POST['price']) ? $_POST['price'] : NULL;
        $_SESSION['num'] = isset($_POST['num']) ? $_POST['num'] : NULL;
        $_SESSION['image'] = isset($_FILES['image']) ? $_FILES['image'] : NULL;
        $_SESSION['status'] = isset($_POST['status']) ? $_POST['status'] : NULL;

    } else {

//        var_dump($posted_drink_data);

        $insert_data = array();

        //画像アップロード

        $insert_data['product_name'] = $product_name;
        $insert_data['price'] = $price;

        if (is_uploaded_file($_FILES["image"]["tmp_name"])){
            $img_object = getimagesize($_FILES['image']['tmp_name']);
            $new_img_object = rename_img($img_object , $_FILES["image"]);
            $img_uploaded_path = upload_img($new_img_object);
//            var_dump($img_uploaded_path);
            $insert_data['drink_img_path'] = $img_uploaded_path;
        }

        if($status === "open"){
            $insert_data['status'] = 1;
        }else{
            $insert_data['status'] = 0;
        }
//        echo "<pre>";
//        var_dump($insert_data);
//        echo "</pre>";

        $num_of_stock = $num;


        insert_drink_data($pdo,$insert_data ,$num_of_stock);

        $_SESSION = array();
        session_destroy();
//
//        header("Location:" . TOOL_PAGE);

    }

}

if($submit2){

    $_POST = escape($_POST);
    $post_data = array();

    $product_id = isset($_POST['product_stock_id']) ? $_POST['product_stock_id'] : NULL;
    $num_of_sock_changed = isset($_POST['num_of_stock_changed']) ? $_POST['num_of_stock_changed'] : NULL;

    if(!empty($product_id) && !empty($num_of_sock_changed)){
        $post_data['id'] = $product_id;
        $post_data['num_of_sock_changed'] = $num_of_sock_changed;
        update_inventory_control($pdo,$post_data);
    }

}

if($submit3){

    $_POST = escape($_POST);
    $post_data = array();
    $product_id = isset($_POST['product_status_id']) ? $_POST['product_status_id'] : NULL;
    $status_reverse_value = isset($_POST['product_status_value']) ? $_POST['product_status_value'] : NULL;

//    var_dump($product_id);
//    var_dump($status_reverse_value);


        $post_data['id'] = $product_id;
        $post_data['status_reverse_value'] = $status_reverse_value;
//        var_dump($post_data);
        update_drink_info($pdo,$post_data);



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
            <form action="" method="post" enctype="multipart/form-data">
                <div class="formBlock__item">
                    <label for="product_name">商品名</label>
                    <input type="text" name="product_name" value="<?php if ($_SESSION['product_name']) {
                        echo $_SESSION['product_name'];
                    } ?>" id="product_name">
                    <?php if (isset($error['product_name'])) echo '<p class="error">' . $error['product_name'] . '</p>'; ?>
                </div>

                <div class="formBlock__item">
                    <label for="price">値段</label>
                    <input type="text" name="price" id="price" value="<?php if ($_SESSION['price']) {
                        echo $_SESSION['price'];
                    } ?>">
                    <?php if (isset($error['price'])) echo '<p class="error">' . $error['price'] . '</p>'; ?>
                </div>

                <div class="formBlock__item">
                    <label for="num">個数</label>
                    <input type="text" name="num" id="num" value="<?php if ($_SESSION['num']) {
                        echo $_SESSION['num'];
                    } ?>">
                    <?php if (isset($error['num'])) echo '<p class="error">' . $error['num'] . '</p>'; ?>
                </div>
                <div class="formBlock__item">
                    <label for="image">商品画像</label>
                    <input type="file" name="image" id="image">
<!--                    --><?php //if (isset($error['image'])) echo '<p class="error">' . $error['image'] . '</p>'; ?>
                </div>

                <div class="formBlock__item">
                    <label for="status">商品ステータス</label>
                    <select name="status" id="status">
                        <option value="open" <?php if ($_SESSION['status'] === "open") echo "selected" ?> >公開</option>
                        <option value="hidden" <?php if ($_SESSION['status'] === "hidden") echo "selected" ?>>非公開
                        </option>
                    </select>
                    <!--                    --><?php // if(isset($error['status'])) echo '<p class="error">'.$error['status'].'</p>';?>
                </div>

                <div class="formBlock__item">
                    <input type="submit" id="formBlock" value="商品追加" name="submit">
                </div>
            </form>
        </div>
        <h2>商品情報変更</h2>
        <p>商品一覧</p>
        <ul class="productsItems js-productsItems">
            <?php

            $id_array = get_target_col($drink_info,'id');
            $name_array = get_target_col($drink_info,'drink_name');
            $price_array = get_target_col($drink_info,'drink_price');
            $drink_img_path_array = get_target_col($drink_info,'drink_img_path');
            $status_array = get_target_col($drink_info,'status');
//            $num_of_stock = get_target_col($drink_info,'num_of_stock');
            display_productItem_tools($drink_info,$id_array,$name_array,$price_array,$drink_img_path_array,$status_array);

            ?>


        </ul>

    </div>
</div>


</body>
</html>