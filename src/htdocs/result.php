<?php
session_start();



$_SESSION['coin'] = isset($_SESSION['coin']) ? $_SESSION['coin'] : NULL;
$_SESSION['product_radio'] = isset($_SESSION['coin']) ? $_SESSION['product_radio'] : NULL;

var_dump($_SESSION['coin'],$_SESSION['product_radio']);

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

<?php  var_dump($_POST); ?>

<div class="puchase_result">
    <p class="thumbnail">
        <img src="assets/img/uploads/" alt="">
    </p>
    <p>がしゃん！<?php echo $product_name;?>が買えました！</p>
    <p>おつりは900円です！</p>
</div>


</body>
</html>