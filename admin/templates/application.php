<?php

require_once SMARTY_DIR . 'smarty.class.php';

class Application extends Smarty {

    public function __construct() {
        parent::__construct();
        $this->template_dir = ADMIN_PRESENTATION_DIR;
        $this->compile_dir = ADMIN_COMPILE_DIR;
        $this->config_dir = CONFIG_DIR;
        $this->plugins_dir[0] = SMARTY_DIR . 'plugins';
        $this->plugins_dir[1] = PRESENTATION_DIR . 'smarty_plugins';
        $this->debugging = DEBUGGING;
        $this->caching = CACHING;
    }

}

?>
