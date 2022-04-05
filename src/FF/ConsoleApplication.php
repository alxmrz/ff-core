<?php

namespace FF;

use Exception;
use FF\db\DatabaseConnection;

class ConsoleApplication
{
    protected DatabaseConnection $db;
    protected string $currentControllerName = '';
    protected string $currentControllerAction = 'actionIndex';
    protected string $currentControllerActionArgument = '';

    public function __construct(
        protected array $argv,
        protected array $config
    ){}

    public function run(): int
    {
        try {
            if (empty($this->argv[1])) {
                return ExitCode::ERROR;
            }

            $this->createDatabaseConnection();

            $this->registerCurrentController();
            $this->currentControllerAction = 'action' . ucfirst($this->argv[2] ?? 'index');
            $this->currentControllerActionArgument = $this->argv[3] ?? '';

            $controller = $this->createCurrentController();
            $controller->setDb($this->db);

            $controller->{$this->currentControllerAction}($this->currentControllerActionArgument);

            return ExitCode::SUCCESS;
        } catch (Exception $e) {
            echo  $e->getMessage();

            return ExitCode::ERROR;
        }
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

    protected function createDatabaseConnection()
    {
        $this->db = new DatabaseConnection($this->config);
    }
}