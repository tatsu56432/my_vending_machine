<?php

function escape ($vars) {
    if(is_array($vars)){
        return array_map("escape",$vars);
    }else{
        return htmlspecialchars($vars ,ENT_QUOTES,'UTF-8');
    }

}

function validateInput ($input = NULL) {

    if(!$input){
        $input = $_POST;
    }

    $zip_code = isset($input['zip_code']) ? $input['zip_code'] : null;
    $address = isset($input['address']) ? $input['address'] : null;
    $name = isset($input['name']) ? $input['name'] : null;
    $email = isset($input['email']) ? $input['email'] : null;



}