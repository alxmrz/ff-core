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
class View
{

    protected $assets;

    public function __construct()
    {
        $this->assets['global_assets'] = require 'config/assets.php';
    }

    public function render($template)
    {
        require 'view/header.php';
        require "view/{$template}.php";
        require 'view/footer.php';
    }

    public function putGlobalCss()
    {
        //print_r($this->assets['global_assets']['css']);
        foreach ($this->assets['global_assets']['css'] as $style) {
                echo "<link href='/assets/global/css/{$style}' rel='stylesheet' type='text/css' />";
        
        }
    }
    public function putGlobalJs()
    {
        foreach ($this->assets['global_assets']['js'] as $script) {
                echo "<script src='/assets/global/js/{$script}'></script>";
            
        }
    }

    public function addLocalCss($cssFileName)
    {
        echo "<link href='/assets/{$cssFileName}' rel='stylesheet' type='text/css' />";
    }
    public function addLocalJs($jsFileNames)
    {
        foreach($jsFileNames as $jsFileName) {
           echo "<script src='/assets/{$jsFileName}'></script>"; 
        }
        
    }
}
