<?php
namespace core;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author Alexandr
 */
class View {

    public function __construct() {
        echo 'View done';
    }

    public function render($template) {
        require 'view/header.php';
        require "view/{$template}/index.php";
        require 'view/footer.php';
    }

}
