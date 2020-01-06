<?php


namespace core;

class ConsoleApplication
{
    protected $argv = [];
    protected $currentControllerName = '';
    protected $currentControllerAction = 'actionIndex';
    protected $currentControllerActionArgument = '';

    public function __construct(array $argv = [])
    {
        $this->argv = $argv;
    }

    public function run(): int
    {
        if (empty($this->argv[1])) {
            return ExitCode::ERROR;
        }

        $this->registerCurrentController();
        $this->currentControllerAction = 'action' . ucfirst($this->argv[2] ?? 'index');
        $this->currentControllerActionArgument = $this->argv[3] ?? '';

        $this->createCurrentController()->{$this->currentControllerAction}($this->currentControllerActionArgument);

        return ExitCode::SUCCESS;
    }

    /**
     * Register current controller depending on the second console argument
     */
    protected function registerCurrentController(): void
    {
        $controllerUniqueName = '';
        $controllerParts = explode('-', $this->argv[1]);
        foreach ($controllerParts as $controllerPart) {
            $controllerUniqueName .= ucfirst($controllerPart);
        }

        $this->currentControllerName = "console\controller\\{$controllerUniqueName}Controller";
    }

    public function getCurrentControllerName(): string
    {
        return $this->currentControllerName;
    }

    /**
     * @return string
     */
    public function getCurrentControllerAction(): string
    {
        return $this->currentControllerAction;
    }

    /**
     * @return string
     */
    public function getCurrentControllerActionArgument(): string
    {
        return $this->currentControllerActionArgument;
    }

    protected function createCurrentController(): ConsoleController
    {
        return new $this->currentControllerName();
    }
}