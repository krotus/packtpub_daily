<?php
// Autoload
spl_autoload_register(function ($className) {
    $namespace = str_replace("\\",DIRECTORY_SEPARATOR, $className);
    $className = implode(DIRECTORY_SEPARATOR, array_slice(explode(DIRECTORY_SEPARATOR, $namespace),1));
    $class = CORE_PATH . DIRECTORY_SEPARATOR . "{$className}.php";
    include_once($class);
});