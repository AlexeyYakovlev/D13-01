<?php

function smarty_function_load_presentation_object($params, $smarty) {
    if (isset($params['dir']))
        require_once ADMIN_PRESENTATION_DIR . "tplClass/" . $params['filename'] . '.php';
    else
        require_once PRESENTATION_DIR . $params['filename'] . '.php';
    $className = str_replace(' ', '', ucfirst(str_replace('_', ' ', $params['filename'])));
    $obj = new $className();
    if (method_exists($obj, 'init')) {
        $obj->init();
    }
    $smarty->assign($params['assign'], $obj);
}