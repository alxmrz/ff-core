<?php

namespace controller;

use core\Controller;

class MainpageController extends Controller
{

    public function actionIndex()
    {
        $this->view->setTitle('Main page');

        $mainData = [
            'contentTemplate' => 'mainpage.twig',
            'title' => $this->view->getTitle(),
            'globalCss' => $this->view->getGlobalCss(),
            'globalJs' => $this->view->getGlobalJs(),
            'localCss' => $this->view->addLocalCss('mainpage/css/mainpage.css'),
        ];
        echo $this->render('layouts/main', $mainData);
    }
}
