<?php

function autoload($class_name) {
    $file = __DIR__.'/class/'.$class_name.'.php';
    if(is_file($file)) {
        require_once($file);
    }
}

spl_autoload_register('autoload');