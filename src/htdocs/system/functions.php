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

function upload_img($upload_img_file){

    $img_file = $upload_img_file;
//画像ファイルデータを取得
    $img_data = file_get_contents($img_file);
//MIMEタイプの取得
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_buffer($finfo, $img_data);
    finfo_close($finfo);
//MIMEタイプの出力
    echo $mime_type;
//拡張子の配列（拡張子の種類を増やせば、画像以外のファイルでもOKです）
    $extension_array = array(
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'png' => 'image/png'
    );
//MIMEタイプから拡張子を出力
    if($img_extension = array_search($mime_type, $extension_array,true)){
        //拡張子の出力
        echo $img_extension;
    }

//    $format = '%s_%s.%s';
//    $time = time();
//    $sha1 = sha1(uniqid(mt_rand(),true));
//    //$extはファイル連携時に取得した拡張子
//    $file_path = sprintf($format,$time,$sha1,'.png');


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

function get_drink_info($pdo){
    $data = array();
    $smtm = $pdo -> query("SET NAMES utf8;");
    $stmt = $pdo->query("SELECT * FROM drink_info");
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $data[] = array(
            'id' => $row["id"],
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

function display_productItem_tools(){

    $productItem = <<<HTML
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
                            <button type="submit" name="status_btn" value="">公開→非公開</button>
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
    $error = array();

    if(empty($name)){
        $error['name'] = '名前が入力されてません';
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


