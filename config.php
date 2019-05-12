<?php

define( 'MYSQL_HOST', 'localhost' );
define( 'MYSQL_USER', 'user' );
define( 'MYSQL_PASSWORD', 'pass' );
define( 'MYSQL_DB_NAME', 'vista' );

define('URL', 'http://' . $_SERVER['HTTP_HOST']);
define('GOOGLE_MAPS_API_KEY', 'AIzaSyB1jvZypaGXz4R7ibB-KD3LTxOrYB38Yy0');

function my_autoload($pClassName) {
    if(file_exists(__DIR__ . '/' . str_replace('\\', '/', $pClassName) . '.php')){
        require_once __DIR__ . '/' . str_replace('\\', '/', $pClassName) . '.php';
    }
}
spl_autoload_register("my_autoload");

