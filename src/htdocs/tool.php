<?php
session_start();

require_once 'system/define.php';
require_once 'system/functions.php';

$submit = $_POST['submit'];
$posted_drink_data = array();

if ($submit) {
    $product_name = isset($_SESSION['product_name']) ? $_POST['product_name'] : NULL;
    $price = isset($_SESSION['price']) ? $_POST['price'] : NULL;
    $num = isset($_SESSION['num']) ? $_POST['num'] : NULL;
    if (is_uploaded_file($_FILES["image"]["tmp_name"])){
        $image = $_FILES["image"];
    }else{
        $image = false;
    }
//    $image = isset($_SESSION['image']) ? $_FILES['image'] : NULL;
    $status = isset($_SESSION['status']) ? $_POST['status'] : NULL;

//    echo "<pre>";
//    var_dump($_FILES['image']);
//    echo "</pre>";

    $img_object = getimagesize($_FILES['image']['tmp_name']);
    $new_img_object = rename_img($img_object , $image);
    $upload_result = upload_img($new_img_object);



    $posted_drink_data['product_name'] = $product_name;
    $posted_drink_data['price'] = $price;
    $posted_drink_data['num'] = $num;
    $posted_drink_data['image'] = $upload_result;
    $posted_drink_data['status'] = $status;

    $error = validation($posted_drink_data);

    if (count($error) > 0) {
        $data = array();
        $data['error'] = $error;
        escape($data['error']);
        $_SESSION['product_name'] = isset($_POST['product_name']) ? $_POST['product_name'] : NULL;
        $_SESSION['price'] = isset($_POST['price']) ? $_POST['price'] : NULL;
        $_SESSION['num'] = isset($_POST['num']) ? $_POST['num'] : NULL;
        $_SESSION['status'] = isset($_POST['status']) ? $_POST['status'] : NULL;




    } else {




        header("Location:" . TOOL_PAGE);
        $_SESSION = array();
        session_destroy();
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
                    <input type="submit" id="submit" value="商品追加" name="submit">
                </div>
            </form>
        </div>
        <h2>商品情報変更</h2>
        <p>商品一覧</p>
        <ul class="productsItems js-productsItems">
            <?php
            display_productItem_tools();
            ?>
        </ul>

    </div>
</div>


</body>
</html>