<?php
namespace core;

/**
 * Description of View
 *
 * @author Alexandr
 */
class View
{
    protected $title;
    protected $assets;

    public function __construct()
    {
        $this->assets['global_assets'] = require dirname(__FILE__) . '/../config/assets.php';
    }
    /**
     *
     * @param string $template
     * @param mixed $data
     * @return string Возвращает результат генерации шаблона
     */
    public function render($template,$data='')
    {
        return $this->formTemplate($template,$data);

    }

    /**
     * Добавляет глобальные css файлы для сайта в тегах <header></header>
     */
    public function putGlobalCss()
    {
        foreach ($this->assets['global_assets']['css'] as $style) {
            echo "<link href='/assets/global/css/{$style}' rel='stylesheet' type='text/css' />";
        }
    }

    /**
     * Добавляет глобальные js файлы в конце страницы
     */
    public function putGlobalJs()
    {
        foreach ($this->assets['global_assets']['js'] as $script) {
            echo "<script src='/assets/global/js/{$script}'></script>";
        }
    }
    /**
     * Добавляет файл стилей на страницу
     * @param string $cssFileName Путь к файлу CSS относительно директории assets
     */
    public function addLocalCss($cssFileName)
    {
        echo "<link href='/assets/{$cssFileName}' rel='stylesheet' type='text/css' />";
    }

    /**
     * Добавляет файл стилей на страницу
     * Отличие от addLocalCss в том, что файл со стилями
     * может быть где угодно
     * @param $cssFileName путь к файлу CSS
     */
    public function addCssFrom($cssFileName)
    {
        echo "<link href='{$cssFileName}' rel='stylesheet' type='text/css' />";
    }
    /**
     *
     * @param array $jsFileNames
     */
    public function addLocalJs($jsFileNames)
    {
        foreach ($jsFileNames as $jsFileName) {
            echo "<script src='/assets/{$jsFileName}'></script>";
        }
    }
    /**
     * Возвращает результат подключения шаблона.
     * @param string $template
     * @param mixed $data
     * @return string
     */
    protected function formTemplate($template,$data='')
    {
        ob_start();
        $content = $data;
        require dirname(__FILE__) . "/../view/{$template}.php";
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    /**
     * Заголовок устанавливает в шаблоне перед выводом на экран.
     * @param string $title Заголовок страницы
     */
    public function setTitle($title) {
        $this->title = $title;
    }
    public function getAssets()
    {
      return $this->assets;
    }

}
