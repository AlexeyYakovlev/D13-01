<?php

Class Main extends System {

    public $mainTpl;

    public function __construct() {
        
    }

    public function init() {
        /*setcookie("logged", 1, time() - 1987200);
        if (isset($_GET) && $_GET['exit'] == 1) {
            session_destroy();
            $this->Redirect(Link::ToIndex(), $_SESSION);
        }
        if (isset($_SESSION['logged']) && $_SESSION['logged'] == true)
            $this->mainTpl = 'struct.tpl';
        else {
            if (isset($_COOKIE['logged']) && $_COOKIE['logged'] == 1)
                $this->mainTpl = 'lock.tpl';
            else
                $this->mainTpl = 'login.tpl';
        }*/
    }

}

?>
