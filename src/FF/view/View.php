<?php

namespace FF\view;

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

    /**
     * @var TemplateInterface
     */
    protected $templateEngine;

    public function __construct(TemplateInterface $templateEngine, $globalAssets = [])
    {
        $this->templateEngine = $templateEngine;
        $this->assets['global_assets'] = $globalAssets;
    }

    /**
     * Render template and return result string
     * @param string $template
     * @param mixed $data
     * @return  string
     */
    public function render(string $template, array $data = []): string
    {
        return $this->templateEngine->render($template, $data);
    }

    /**
     * Add global css in tags <header></header>
     * @return string
     */
    public function getGlobalCss(): string
    {
        $return = '';
        foreach ($this->assets['global_assets']['css']??[] as $style) {
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
        foreach ($this->assets['global_assets']['js']??[] as $script) {
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
     * @param $cssFileName
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
        return $this->assets;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
