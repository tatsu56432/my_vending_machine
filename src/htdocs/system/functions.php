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

function get_drink_info($pdo){
    $data = array();
    $smtm = $pdo -> query("SET NAMES utf8;");
    $stmt = $pdo->query("SELECT * FROM drink_info");
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $data[] = array(
            'drink_name' => $row["drink_name"],
            'drink_price' => $row["drink_price"],
            'drink_img_path' => $row["drink_img_path"],
            'created_at' => $row["created_at"],
            'updated_at' => $row["updated_at"],
            'status' => $row["status"]
        );
    }
    return $data;
}

function insert_drink_data($pdo,$drink_data){
    if(is_array($drink_data)){
        $id = NULL;
        $drink_name =$drink_data['drink_name'];
        $drink_price = $drink_data['drink_price'];
        $drink_img_path = $drink_data['drink_img_path'];
        $created_at = $drink_data['created_at'];
        $updated_at = $drink_data['updated_at'];
        $status = $drink_data['status'];
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
    }else{
        $error = 'データの挿入に失敗しました。';
        return $error;
    }
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
    $status = isset($input['status']) ? $input['status'] : null;
    $comment = isset($input['comment']) ? $input['comment'] : null;

    $name = trim($name);
    $error = array();

    if(empty($name)){
        $error['name'] = '名前が入力されてません';
    }else if(mb_strlen($name) >= 20){
        $error['name'] = '名前は20文字以内で入力してください。';
    }
    if(empty($comment)) {
        $error['comment'] = 'コメントが入力されていません';
    }
    return $error;
}


