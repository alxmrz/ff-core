<?php
namespace core;

use core\request\Request;

interface BaseApplication
{
    /**
     * @return int
     */
    public function run();

    /**
     *
     * @return Request
     */
    public function getRequest(): Request;

    /**
     * @return Controller
     */
    public function getController(): Controller;

    /**
     * @return string
     */
    public function getPageToRender(): string;
}