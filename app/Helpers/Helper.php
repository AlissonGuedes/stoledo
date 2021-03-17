<?php

namespace App\Helpers {

    class Helper
    {
        public function __construct()
        {
            require(base_path() . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR . 'functions.php');
        }
    }
}