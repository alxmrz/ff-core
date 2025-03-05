<?php

declare(strict_types=1);

namespace FF\view;

use FF\exceptions\FileDoesNotExist;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig_Environment;

/**
 * Class TemplateEngine
 * @package core
 */
class TwigEngine implements TemplateInterface
{
    /**
     * TwigEngine constructor.
     */
    public function __construct(private string $templatesPath, private readonly Twig_Environment $twigEnvironment)
    {
    }

    /**
     * @throws FileDoesNotExist
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $templatePath, array $data = []): string
    {
        $this->throwExceptionIfTemplateDoesNotExist($templatePath);
        $loadedTemplate = $this->twigEnvironment->load($templatePath . '.twig');
        return $loadedTemplate->render($data);
    }

    /**
     * @throws FileDoesNotExist
     */
    private function throwExceptionIfTemplateDoesNotExist(string $pathToTemplate): void
    {
        $fullPath = $this->templatesPath . DIRECTORY_SEPARATOR . $pathToTemplate . '.twig';
        if (!file_exists($fullPath)) {
            throw new FileDoesNotExist("File {$fullPath} does not exist");
        }
    }

    public function setTemplatePath(string $templatesPath): void
    {
        $this->templatesPath = $templatesPath;
    }
}
