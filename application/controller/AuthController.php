<?php


namespace controller;


use core\Controller;

class AuthController extends Controller
{
    public function actionSignIn()
    {
        $this->view->setTitle('Sign in');

        $mainData = [
            'contentTemplate' => 'sign_in.twig',
            'title' => $this->view->getTitle(),
            'globalCss' => $this->view->getGlobalCss(),
            'globalJs' => $this->view->getGlobalJs(),
            'localCss' => $this->view->addLocalCss('mainpage/css/mainpage.css'),
        ];
        echo $this->render('layouts/main', $mainData);
    }

    public function actionSignUp()
    {
        $this->view->setTitle('Sign in');

        $mainData = [
            'contentTemplate' => 'sign_up.twig',
            'title' => $this->view->getTitle(),
            'globalCss' => $this->view->getGlobalCss(),
            'globalJs' => $this->view->getGlobalJs(),
            'localCss' => $this->view->addLocalCss('mainpage/css/mainpage.css'),
        ];
        echo $this->render('layouts/main', $mainData);
    }
}