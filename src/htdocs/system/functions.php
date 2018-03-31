<?php

require_once 'define.php';

function get_db_connect(){
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . HOST . '';
    $user = DB_USER_NAME;
    $password = DB_PASS;
//    $pdo = "";
    try{
        $pdo = new PDO($dsn,$user,$password);
    }catch (PDOException $e){
        echo 'Connection failed: ' . $e->getMessage();
    }
    return $pdo;
}


//画像リネーム処理
function rename_img ($img_array = array(),$img = array()) {

    $extension_array = array(
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'png' => 'image/png'
    );

    $img_extension = array_search($img_array['mime'], $extension_array,true);
    $format = '%s_%s.%s';
    $time = date('ymd');
    $sha1 = sha1(uniqid(mt_rand(),true));
    $new_file_name = sprintf($format,$time,$sha1, $img_extension);
    $img["name"] = $new_file_name;

    return $img;

}

//画像アップロード処理
function upload_img ($uploaded_img_object = array()) {
    if (is_uploaded_file($uploaded_img_object["tmp_name"])) {
        if (move_uploaded_file($uploaded_img_object["tmp_name"], $_SERVER["DOCUMENT_ROOT"] . "/assets/img/uploads/" . $uploaded_img_object["name"])) {
            chmod($_SERVER["DOCUMENT_ROOT"] . "/assets/img/uploads/" . $uploaded_img_object["name"], 0777);
            $uploaded_img_path = "/assets/img/uploads/" . $uploaded_img_object["name"];
//            echo $uploaded_img_object["name"] . "をアップロードしました。";
//            echo $uploaded_img_path;
            return $uploaded_img_path;
        } else {
            echo "ファイルをアップロードできません。アップロード用のディレクトリのパーミッションを確認してください。";
        }
    } else {
        return false;
    }
}

function get_db_data ($pdo) {
    $data = array();
    $stmt = $pdo -> query("SET NAMES utf8;");
    $stmt = $pdo->query("SELECT * FROM drink_info");
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $data[] = array(
            'drink_name' => $row["drink_name"],
            'drink_price' => $row["drink_price"],
            'drink_img_path' => $row["drink_img_path"],
            'date' => $row["date"],
            'date' => $row["date"],
        );
    }
    return $data;
}


//tableへのデータ挿入処理
function insert_drink_data($pdo,$drink_data,$stock){
    if(is_array($drink_data)){
        $id = NULL;
        $drink_name =$drink_data['product_name'];
        $drink_price = $drink_data['price'];
        $drink_img_path = $drink_data['drink_img_path'];
        $created_at = date('Ymd');
        $updated_at = date('Ymd');
        $status = $drink_data['status'];
        $num_of_stock = $stock;

        $stmt = $pdo -> query("SET NAMES utf8;");
        $stmt = $pdo -> prepare("INSERT INTO drink_info (id , drink_name, drink_price , drink_img_path , created_at , updated_at, status) VALUES (:id , :drink_name , :drink_price , :drink_img_path , :created_at , :updated_at , :status)");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);
        $stmt->bindParam(':drink_name', $drink_name, PDO::PARAM_STR);
        $stmt->bindParam(':drink_price', $drink_price, PDO::PARAM_STR);
        $stmt->bindParam(':drink_img_path', $drink_img_path, PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();


        $stmt2 = $pdo -> query("SET NAMES utf8;");
        $stmt2 = $pdo -> prepare("INSERT INTO inventory_control(id , num_of_stock, created_at , updated_at) VALUES (:id , :num_of_stock , :created_at , :updated_at)");
        $stmt2->bindValue(':id', $id , PDO::PARAM_INT);
        $stmt2->bindValue(':num_of_stock', $num_of_stock , PDO::PARAM_INT);
        $stmt2->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $stmt2->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $stmt2->execute();

        $_SESSION = array();
        session_destroy();

    }else{
        $error = 'データの挿入に失敗しました。';
        return $error;
    }
}

function insert_inventory_control () {
    $id = NULL;
    $num_of_stock = NULL;



}

function get_drink_info($pdo){
    $data = array();
    $smtm = $pdo -> query("SET NAMES utf8;");

    //tableの内部結合
    $stmt = $pdo->query("SELECT drink_info.*,inventory_control.num_of_stock FROM drink_info INNER JOIN inventory_control ON drink_info.id = inventory_control.id");
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $data[] = array(
            'id' => $row["id"],
            'drink_name' => $row["drink_name"],
            'drink_price' => $row["drink_price"],
            'drink_img_path' => $row["drink_img_path"],
            'created_at' => $row["created_at"],
            'updated_at' => $row["updated_at"],
            'status' => $row["status"],
            'num_of_stock' => $row["num_of_stock"]
        );
    }
    return $data;
}

function display_productItem_tools(){

    $img_path = "";

    $productItem = <<<HTML
                <li class="productsItem ">
                <dl>
                    <dt>商品画像</dt>
                    <dd>
                        <p class="thumbnail js-thumbnail"><img src="{$img_path}" alt=""></p>
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
                                    <input type="submit" name="submit" value="変更" form="formBlock">
                                </p>
                            </form>
                        </div>
                    </dd>
                </dl>
                <dl>
                    <dt>ステータス</dt>
                    <dd>
                        <form action="#" method="post">
                            <button type="submit" name="status_btn" value="" form="formBlock">公開→非公開</button>
                        </form>
                    </dd>
                </dl>
            </li>
HTML;

    echo $productItem;
}


function display_productItem_indx(){

}

function display_product_result(){


}


function escape ($vars) {
    if(is_array($vars)){
        return array_map("escape",$vars);
    }else{
        return htmlspecialchars($vars ,ENT_QUOTES,'UTF-8');
    }

}


function validation ($input = null) {

    if (!$input) {
        $input = $_POST;
    }

    $name = isset($input['product_name']) ? $input['product_name'] : null;
    $price = isset($input['price']) ? $input['price'] : null;
    $num = isset($input['num']) ? $input['num'] : null;
    $image = isset($input['image']) ? $input['image'] : null;
    $status = isset($input['status']) ? $input['status'] : null;


    $name = trim($name);
    $price = trim($price);
    $error = array();

    if(empty($name)){
        $error['product_name'] = '名前が入力されてません';
    }
    if(empty($price)) {
        $error['price'] = '値段が入力されていません';
    }elseif (!is_numeric($price)){
        $error['price'] = '値段は数値で入力してください';
    }
    if(empty($num)) {
        $error['num'] = '在庫数が入力されていません';
    }elseif (!is_numeric($num)){
        $error['price'] = '在庫数は数値で入力してください';
    }
    if(empty($image)) {
        $error['image'] = '画像を入力してください';
    }

    if(empty($status)) {
        $error['status'] = 'ステータスを選択してください';
    }

    return $error;
}


