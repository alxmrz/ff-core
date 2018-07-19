<?php
namespace core;

interface BaseApplication
{
    /**
     * @return int
     */
    public function run();

    /**
     *
     * @return HttpDemultiplexer
     */
    public function getHttpDemultiplexer(): HttpDemultiplexer;

    /**
     * @return Controller
     */
    public function getController(): Controller;

    /**
     * @return string
     */
    public function getPageToRender(): string;
}