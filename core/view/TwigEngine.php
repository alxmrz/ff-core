<?php

namespace core\view;

use core\exceptions\FileDoesNotExist;

/**
 * Class TemplateEngine
 * @package core
 */
class TwigEngine implements TemplateInterface
{
    /**.
     * @var string
     */
    private $templatesPath;
    /**
     * @var \Twig_Environment
     */
    private $twigEnvironment;


    /**
     * TwigEngine constructor.
     * @param string $templatesPath
     */
    public function __construct(
        string $templatesPath,
        \Twig_Environment $te
    )
    {
        $this->templatesPath = $templatesPath;
        $this->twigEnvironment = $te;
    }

    /**
     * @param string $templatePath
     * @param array $data
     * @return string
     * @throws FileDoesNotExist
     */
    public function render(string $templatePath, array $data = [])
    {
        $this->throwExceptionIfTemplateDoesNotExist($templatePath);
        $loadedTemplate = $this->twigEnvironment->load($templatePath . '.twig');
        return $loadedTemplate->render($data);
    }

    /**
     * @param string $pathToTemplate
     * @throws FileDoesNotExist
     */
    private function throwExceptionIfTemplateDoesNotExist(string $pathToTemplate)
    {
        $fullPath = $this->templatesPath . DIRECTORY_SEPARATOR . $pathToTemplate . '.twig';
        if (!file_exists($fullPath)) {
            throw new FileDoesNotExist("File {$fullPath} does not exist");
        }
    }

    public function setTemplatePath(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }
}