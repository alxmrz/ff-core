<?php
namespace core;


/**
 * Класс Application - основной класс приложения.
 */
interface BaseApplication
{
    /**
     * Основной публичный метод приложения. Точка входа.
     * @return int флаг успешности запуска приложения
     */
    public function run();

    /**
     *
     * @return HttpDemultiplexer
     */
    public function getHttpDemultiplexer(): HttpDemultiplexer;

    /**
     *
     * @return \core\Controller
     */
    public function getController(): \core\Controller;

    /**
     *
     * @return string
     */
    public function getPageToRender(): string;
}