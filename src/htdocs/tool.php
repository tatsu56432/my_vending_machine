<?php
session_start();


$submit = $_POST['submit'];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($submit){

        $product_name = isset($_SESSION['product_name'])?$_POST['product_name']:NULL;
        $price = isset($_SESSION['price'])?$_POST['price']:NULL;
        $num = isset($_SESSION['num'])?$_POST['num']:NULL;
        $image = isset($_SESSION['image'])?$_POST['image']:NULL;
        $status = isset($_SESSION['status'])?$_POST['status']:NULL;


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
    <title>Document</title>
</head>
<body>
<h1>自動販売機管理ページ</h1>

<p>新規商品名追加</p>
<form action="" method="post" enctype=”multipart/form-data”>
    <label for="product_name">商品名</label>
    <input type="text" name="product_name" value="<?php if($_SESSION['product_name']){ echo $product_name;} ?>" id="product_name"><br>

    <label for="price">値段</label>
    <input type="text" name="price" id="price" 　value="<?php if($_SESSION['price']){ echo $price;} ?>"><br>
    <label for="num">個数</label>
    <input type="text" name="num" id="num" value="<?php if($_SESSION['num']){ echo $num; } ?>"><br>
    <label for="image">商品画像</label>
    <input type="file" name="image" id="image"><br>

    <div>
        <label for="product_name">商品名</label>
        <select name="status" id="status">
        <option value="open" <?php if($status == "true") echo "selected"?> >公開</option>
        <option value="hidden" <?php if($status == "false") echo "selected"?>>非公開</option>
        </select>
    </div>


    <input type="submit" id="submit" value="商品追加" name="submit">

</form>



</body>
</html>