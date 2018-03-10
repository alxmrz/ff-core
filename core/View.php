<?php

namespace core;

/**
 * Description of View
 *
 * @author Alexandr Moroz
 */
class View
{
  /**
   * Заголовок страницы
   * @var string
   */
  protected $title;
  /**
   * Массив зависимостей
   * @var array 
   */
  protected $assets;
  /**
   * Конструктор класса View
   */
  public function __construct()
  {
    $this->assets['global_assets'] = require dirname(__FILE__) . '/../config/assets.php';
  }

    /**
     * Возвращает результат генерации шаблона
     * @param string $template
     * @param mixed $data
     * @return  string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
  public function render($template, $data = [])
  {
    
    $loader = new \Twig_Loader_Filesystem('../view/');
    $twig = new \Twig_Environment($loader, array(
        'cache' => '../cache/twig/',
        'debug' => true
    ));
    $template = $twig->load($template.'.twig');

    return  $template->render($data);
  }

  /**
   * Добавляет глобальные css файлы для сайта в тегах <header></header>
   * @return string
   */
  public function getGlobalCss()
  {
    $return = '';
    foreach ($this->assets['global_assets']['css'] as $style) {
      $return .= "<link href='/assets/global/css/{$style}' rel='stylesheet' type='text/css' />";
    }
    return $return;
  }

  /**
   * Добавляет глобальные js файлы в конце страницы
   * @return string
   */
  public function getGlobalJs()
  {
    $return = '';
    foreach ($this->assets['global_assets']['js'] as $script) {
      $return .= "<script src='/assets/global/js/{$script}'></script>";
    }
    return $return;
  }

  /**
   * Добавляет файл стилей на страницу
   * @param string $cssFileName Путь к файлу CSS относительно директории assets
   */
  public function addLocalCss($cssFileName = '')
  {
    return "<link href='/assets/{$cssFileName}' rel='stylesheet' type='text/css' />";
  }

  /**
   * Добавляет файл стилей на страницу
   * Отличие от addLocalCss в том, что файл со стилями
   * может быть где угодно
   * @param $cssFileName путь к файлу CSS
   */
  public function addCssFrom($cssFileName)
  {
    return "<link href='{$cssFileName}' rel='stylesheet' type='text/css' />";
  }
  /**
   * Подключает отдельный js файл
   * @param string $jsFileName название подключаемого js файла
   * @return string
   */
  public function addLocalJs(string $jsFileName)
  {
    return "<script src='/assets/{$jsFileName}'></script>";
  }

  /**
   * Заголовок устанавливает в шаблоне перед выводом на экран.
   * @param string $title Заголовок страницы
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }
  /**
   * Возвращает массив медиа-зависимостей
   * @return array
   */
  public function getAssets()
  {
    return  $this->assets;
  }
  /**
   * Возвращает название заголовка страницы
   * @return string
   */
  public function getTitle()
  {
    return  $this->title;
  }

}
