<?php

namespace FF\view;

use FF\exceptions\FileDoesNotExist;

/**
 * Class TemplateEngine
 * @package core
 */
class TemplateEngine implements TemplateInterface
{
    private string $templatesPath;

    /**
     * TemplateEngine constructor.
     * @param string $templatesPath
     */
    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    /**
     * @param string $templatePath
     * @param array $data
     * @return string
     * @throws FileDoesNotExist
     */
    public function render(string $templatePath, array $data = []): string
    {
        $pathToTemplate = $this->templatesPath . DIRECTORY_SEPARATOR . $templatePath . '.php';
        $this->throwExceptionIfTemplateDoesNotExist($pathToTemplate);
        return $this->renderTemplate($pathToTemplate, $data);

    }

    /**
     * @param string $pathToTemplate
     * @throws FileDoesNotExist
     */
    private function throwExceptionIfTemplateDoesNotExist(string $pathToTemplate)
    {
        if (!file_exists($pathToTemplate)) {
            throw new FileDoesNotExist("File {$pathToTemplate}.php does not exist");
        }
    }

    /**
     * @param string $pathToTemplate
     * @param array $data
     * @return string
     */
    private function renderTemplate(string $pathToTemplate, array $data = []): string
    {
        ob_start();
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        require_once $pathToTemplate;
        return ob_get_clean();
    }

    public function setTemplatePath(string $templatesPath): void
    {
        $this->templatesPath = $templatesPath;
    }
}