<?php

namespace core;

class View
{
  /**
   * @var string
   */
  protected $title;
  
  /**
   * @var array 
   */
  protected $assets;
  
  public function __construct()
  {
    $this->assets['global_assets'] = require dirname(__FILE__) . '/../config/assets.php';
  }

    /**
     * Render template and return result string
     * @param string $template
     * @param mixed $data
     * @return  string
     */
  public function render($template, $data = []): string
  {
    $loader = new \Twig_Loader_Filesystem('../view/');
    $twig = new \Twig_Environment($loader, array(
        'cache' => '../cache/twig/',
        'debug' => true
    ));
    $twigEngine = new TwigEngine('../view', $loader, $twig);
    return  $twigEngine->render($template, $data);
  }

  /**
   * Add global css in tags <header></header>
   * @return string
   */
  public function getGlobalCss(): string
  {
    $return = '';
    foreach ($this->assets['global_assets']['css'] as $style) {
      $return .= "<link href='/assets/global/css/{$style}' rel='stylesheet' type='text/css' />";
    }
    return $return;
  }

  /**
   * Add global JS before tag </body>
   * @return string
   */
  public function getGlobalJs(): string
  {
    $return = '';
    foreach ($this->assets['global_assets']['js'] as $script) {
      $return .= "<script src='/assets/global/js/{$script}'></script>";
    }
    return $return;
  }

  /**
   * Add css to page where method executed
   * @param string $cssFileName
   */
  public function addLocalCss($cssFileName = ''): string
  {
    return "<link href='/assets/{$cssFileName}' rel='stylesheet' type='text/css' />";
  }

  /**
   * The same as addLocalCss but $cssFilename may be in other locations
   * @param $cssFileName путь к файлу CSS
   */
  public function addCssFrom($cssFileName): string
  {
    return "<link href='{$cssFileName}' rel='stylesheet' type='text/css' />";
  }
  
  /**
   * Add js from assets
   * @param string $jsFileName
   * @return string
   */
  
  public function addLocalJs(string $jsFileName): string
  {
    return "<script src='/assets/{$jsFileName}'></script>";
  }

  /**
   * @param string $title
   */
  public function setTitle($title): void
  {
    $this->title = $title;
  }
  
  /**
   * @return array
   */
  public function getAssets(): array
  {
    return  $this->assets;
  }
  
  /**
   * @return string
   */
  public function getTitle()
  {
    return  $this->title;
  }

}
