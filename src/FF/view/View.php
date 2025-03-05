<?php

declare(strict_types=1);

namespace FF\view;

class View
{
    protected string $title;
    protected array $assets;

    public function __construct(protected TemplateInterface $templateEngine, array $globalAssets = [])
    {
        $this->assets['global_assets'] = $globalAssets;
    }

    /**
     * Render template and return result string
     * @param mixed $data
     */
    public function render(string $template, array $data = []): string
    {
        return $this->templateEngine->render($template, $data);
    }

    /**
     * Add global css in tags <header></header>
     */
    public function getGlobalCss(): string
    {
        $return = '';
        foreach ($this->assets['global_assets']['css'] ?? [] as $style) {
            $return .= "<link href='/assets/global/css/{$style}' rel='stylesheet' type='text/css' />";
        }
        return $return;
    }

    /**
     * Add global JS before tag </body>
     */
    public function getGlobalJs(): string
    {
        $return = '';
        foreach ($this->assets['global_assets']['js'] ?? [] as $script) {
            $return .= "<script src='/assets/global/js/{$script}'></script>";
        }
        return $return;
    }

    /**
     * Add css to page where method executed
     */
    public function addLocalCss(string $cssFileName = ''): string
    {
        return "<link href='/assets/{$cssFileName}' rel='stylesheet' type='text/css' />";
    }

    /**
     * The same as addLocalCss but $cssFilename may be in other locations
     */
    public function addCssFrom(string $cssFileName): string
    {
        return "<link href='{$cssFileName}' rel='stylesheet' type='text/css' />";
    }

    /**
     * Add js from assets
     */
    public function addLocalJs(string $jsFileName): string
    {
        return "<script src='/assets/{$jsFileName}'></script>";
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAssets(): array
    {
        return $this->assets;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
