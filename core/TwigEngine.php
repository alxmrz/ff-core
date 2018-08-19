<?php
namespace core;

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
    private $twigLoaderFileSystem;
    private $twigEnvironment;


    /**
     * TwigEngine constructor.
     * @param string $templatesPath
     */
    public function __construct(
        string $templatesPath,
        \Twig_Loader_Filesystem $tlf,
        \Twig_Environment $te
    )
    {
        $this->templatesPath = $templatesPath;
        $this->twigLoaderFileSystem = $tlf;
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
        $loadedTemplate = $this->twigEnvironment->load($templatePath.'.twig');
        return  $loadedTemplate->render($data);
    }

    /**
     * @param string $pathToTemplate
     * @throws FileDoesNotExist
     */
    private function throwExceptionIfTemplateDoesNotExist(string $pathToTemplate)
    {
        if(!file_exists($this->templatesPath . DIRECTORY_SEPARATOR .$pathToTemplate . '.twig')) {
            throw new FileDoesNotExist("File {$pathToTemplate}.twig does not exist");
        }
    }
}