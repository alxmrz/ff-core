<?php

declare(strict_types=1);

namespace FF\view;

use FF\exceptions\FileDoesNotExist;

/**
 * Class TemplateEngine
 * @package core
 */
class TemplateEngine implements TemplateInterface
{
    /**
     * TemplateEngine constructor.
     */
    public function __construct(private string $templatesPath)
    {
    }

    /**
     * @throws FileDoesNotExist
     */
    public function render(string $templatePath, array $data = []): string
    {
        $pathToTemplate = $this->templatesPath . DIRECTORY_SEPARATOR . $templatePath . '.php';
        $this->throwExceptionIfTemplateDoesNotExist($pathToTemplate);
        return $this->renderTemplate($pathToTemplate, $data);
    }

    /**
     * @throws FileDoesNotExist
     */
    private function throwExceptionIfTemplateDoesNotExist(string $pathToTemplate): void
    {
        if (!file_exists($pathToTemplate)) {
            throw new FileDoesNotExist("File {$pathToTemplate}.php does not exist");
        }
    }

    private function renderTemplate(string $pathToTemplate, array $data = []): string
    {
        ob_start();
        foreach ($data as $key => $value) {
            ${$key} = $value;
        }
        require_once $pathToTemplate;
        return ob_get_clean();
    }

    public function setTemplatePath(string $templatesPath): void
    {
        $this->templatesPath = $templatesPath;
    }
}
