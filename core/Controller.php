<?php
namespace core;

abstract class Controller
{
    /**
     * @return mixed Выводит результирующую страницу на экран
     */
    public abstract function generatePage();
}