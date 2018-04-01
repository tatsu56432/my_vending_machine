<?php

$domain = $_SERVER['HTTP_HOST'];

if($domain === 'codecamp.jp'){
//define constant variable;
    define("DB_NAME","codecamp20681");
    define("HOST","localhost");
    define("DB_USER_NAME","codecamp20681");
    define("DB_PASS","RVHMDUVE");

//define page
    define("TOP_PAGE", '/students/editor/vending_machine/index.php');
    define("TOOL_PAGE", '/students/editor/vending_machine/tool.php');

}else{
//define constant variable;
define("DB_NAME","my_vending_machine");
define("HOST","localhost");
define("DB_USER_NAME","root");
define("DB_PASS","password");

//define page
define("TOP_PAGE", '/index.php');
define("TOOL_PAGE", '/tool.php');
}
