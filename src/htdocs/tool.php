<?php
session_start();

$submit = $_POST['submit'];
if($submit){

}


$product_name = isset($_SESSION['product_name'])?$_POST['product_name']:NULL;
$price = isset($_SESSION['price'])?$_POST['price']:NULL;
$num = isset($_SESSION['num'])?$_POST['num']:NULL;
$image = isset($_SESSION['image'])?$_POST['image']:NULL;
$status = isset($_SESSION['status'])?$_POST['status']:NULL;






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
<form action="" method="post">
    <input type="text" name="product_name" value="<?php if($_SESSION['product_name']){ echo $product_name;} ?>">

    <input type="text" name="price" value="<?php if($_SESSION['price']){ echo $price;} ?>">

    <input type="text" name="num" value="<?php if($_SESSION['num']){ echo $num; } ?>">

    <input type="image" name="image">

    <div>
        <select name="status" id="status"></select>
        <option value="open" <?php if($status == "true") echo "selected"?> >公開</option>
        <option value="hidden" <?php if($status == "false") echo "selected"?>>非公開</option>
    </div>

    <input type="submit" id="submit" value="submit" name="submit">

</form>



</body>
</html>